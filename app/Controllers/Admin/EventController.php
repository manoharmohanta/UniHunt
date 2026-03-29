<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;

class EventController extends BaseController
{
    protected $eventModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    public function index()
    {
        $search = $this->request->getVar('search');

        if ($search) {
            $this->eventModel->like('title', $search)
                ->orLike('description', $search)
                ->orLike('event_type', $search);
        }

        $data = [
            'title' => 'Events Manager',
            'events' => $this->eventModel->orderBy('created_at', 'DESC')->paginate(20),
            'pager' => $this->eventModel->pager->only(['search']),
            'search' => $search
        ];
        return view('admin/events/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Create New Event',
            'event' => null,
        ];
        return view('admin/events/form', $data);
    }

    public function create()
    {
        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'start_date' => 'required|valid_date',
            'event_type' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        // Handle Slug
        if (empty($data['slug'])) {
            $data['slug'] = url_title($data['title'], '-', true);
        }

        // Handle File Upload
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            if (!is_dir(FCPATH . 'uploads/events')) {
                mkdir(FCPATH . 'uploads/events', 0777, true);
            }
            $img->move(FCPATH . 'uploads/events', $newName);
            $data['image'] = 'uploads/events/' . $newName;
        }

        // Handle JSON fields
        $data['agenda'] = $this->processJsonField($this->request->getPost('agenda_json'));
        $data['speakers'] = $this->processJsonField($this->request->getPost('speakers_json'));
        $data['learning_points'] = $this->processJsonField($this->request->getPost('learning_points_json'));

        // Handle Checkboxes
        $data['is_featured'] = isset($data['is_featured']) ? 1 : 0;
        $data['is_premium'] = isset($data['is_premium']) ? 1 : 0;

        // Ensure cost has a default if empty
        if (empty($data['cost'])) {
            $data['cost'] = 'Free';
        }

        if ($this->eventModel->insert($data)) {
            return redirect()->to('admin/events')->with('message', 'Event created successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->eventModel->errors());
        }
    }

    public function edit($id = null)
    {
        $event = $this->eventModel->find($id);
        if (!$event) {
            return redirect()->to('admin/events')->with('error', 'Event not found');
        }

        // JSON fields are handled by Model if casted, or we trust the raw string for Alpine
        $jsonFields = ['agenda', 'speakers', 'learning_points'];

        $data = [
            'title' => 'Edit Event',
            'event' => $event,
        ];
        return view('admin/events/form', $data);
    }

    public function update($id = null)
    {
        $event = $this->eventModel->find($id);
        if (!$event) {
            return redirect()->to('admin/events')->with('error', 'Event not found');
        }

        $rules = [
            'title' => 'required|min_length[3]|max_length[255]',
            'start_date' => 'required|valid_date',
            'event_type' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        // Handle Slug
        if (empty($data['slug'])) {
            $data['slug'] = url_title($data['title'], '-', true);
        }

        // Handle File Upload
        $img = $this->request->getFile('image');
        if ($img && $img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            if (!is_dir(FCPATH . 'uploads/events')) {
                mkdir(FCPATH . 'uploads/events', 0777, true);
            }
            $img->move(FCPATH . 'uploads/events', $newName);
            $data['image'] = 'uploads/events/' . $newName;

            // Delete old image if exists
            if (!empty($event['image']) && file_exists(FCPATH . $event['image'])) {
                @unlink(FCPATH . $event['image']);
            }
        }

        // Handle JSON fields
        $data['agenda'] = $this->processJsonField($this->request->getPost('agenda_json'));
        $data['speakers'] = $this->processJsonField($this->request->getPost('speakers_json'));
        $data['learning_points'] = $this->processJsonField($this->request->getPost('learning_points_json'));

        // Handle Checkboxes
        $data['is_featured'] = isset($data['is_featured']) ? 1 : 0;
        $data['is_premium'] = isset($data['is_premium']) ? 1 : 0;

        if ($this->eventModel->update($id, $data)) {
            return redirect()->to('admin/events')->with('message', 'Event updated successfully');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->eventModel->errors());
        }
    }

    public function delete($id = null)
    {
        $event = $this->eventModel->find($id);
        if ($event) {
            if (!empty($event['image']) && file_exists(FCPATH . $event['image'])) {
                @unlink(FCPATH . $event['image']);
            }
            $this->eventModel->delete($id);
            return redirect()->to('admin/events')->with('message', 'Event deleted successfully');
        }
        return redirect()->to('admin/events')->with('error', 'Event not found');
    }

    private function processJsonField($jsonString)
    {
        if (empty($jsonString))
            return null;

        // If it's already an array, JSON encode it
        if (is_array($jsonString))
            return json_encode($jsonString);

        // Verify it is valid JSON
        $decoded = json_decode($jsonString);
        if (json_last_error() === JSON_ERROR_NONE) {
            // If it decoded to an empty array or object, consider if we want to store it as null or empty json
            // But usually we just return the string as is for DB insertion
            return $jsonString;
        }

        return null;
    }
}
