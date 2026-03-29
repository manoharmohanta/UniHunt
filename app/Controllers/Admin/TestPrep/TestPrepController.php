<?php

namespace App\Controllers\Admin\TestPrep;

use App\Controllers\BaseController;
use App\Models\TestPrep\ExamModel;
use App\Models\TestPrep\ExamModuleModel;
use App\Models\TestPrep\ExamQuestionModel;
use App\Models\TestPrep\ExamResourceModel;

class TestPrepController extends BaseController
{
    protected $examModel;
    protected $moduleModel;
    protected $questionModel;
    protected $resourceModel;

    public function __construct()
    {
        $this->examModel = new ExamModel();
        $this->moduleModel = new ExamModuleModel();
        $this->questionModel = new ExamQuestionModel();
        $this->resourceModel = new ExamResourceModel();
    }

    public function index()
    {
        $data['exams'] = $this->examModel->findAll();
        return view('admin/test_prep/index', $data);
    }

    public function modules($examId)
    {
        $data['exam'] = $this->examModel->find($examId);
        $data['modules'] = $this->moduleModel->where('exam_id', $examId)->findAll();
        return view('admin/test_prep/modules', $data);
    }

    // --- Resources Logic ---

    public function resources($moduleId)
    {
        $data['module'] = $this->moduleModel->find($moduleId);
        $data['exam'] = $this->examModel->find($data['module']['exam_id']);
        $data['resources'] = $this->resourceModel->where('module_id', $moduleId)->orderBy('id', 'DESC')->findAll();

        return view('admin/test_prep/resources/index', $data);
    }

    public function storeResource()
    {
        $moduleId = $this->request->getPost('module_id');
        $title = trim($this->request->getPost('title'));

        // Check for duplicates
        $exists = $this->resourceModel->where('module_id', $moduleId)
            ->where('title', $title)
            ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'A resource with this title already exists in this module.');
        }

        $type = $this->request->getPost('res_type');

        $data = [
            'module_id' => $moduleId,
            'title' => $title,
            'type' => $type,
            'content' => $this->request->getPost('content'),
        ];

        // Handle Media Upload (Audio or Image)
        $file = $this->request->getFile('media_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();

            if ($type === 'image') {
                $file->move(FCPATH . 'uploads/test_prep_resources/images', $newName);
                $data['media_path'] = 'uploads/test_prep_resources/images/' . $newName;
            } else {
                $file->move(FCPATH . 'uploads/test_prep_resources', $newName);
                $data['media_path'] = 'uploads/test_prep_resources/' . $newName;
            }
        }

        $this->resourceModel->insert($data);

        return redirect()->to("admin/test-prep/resources/$moduleId")->with('success', 'Resource added successfully');
    }

    public function manageResource($resourceId)
    {
        $data['resource'] = $this->resourceModel->find($resourceId);
        if (!$data['resource']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Resource not found');
        }

        $data['module'] = $this->moduleModel->find($data['resource']['module_id']);
        if (!$data['module']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Module not found');
        }

        $data['exam'] = $this->examModel->find($data['module']['exam_id']);
        if (!$data['exam']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Exam not found');
        }

        // Fetch questions linked to this resource
        $data['questions'] = $this->questionModel->where('resource_id', $resourceId)->orderBy('id', 'DESC')->findAll();

        return view('admin/test_prep/resources/manage', $data);
    }

    public function deleteResource($id)
    {
        $resource = $this->resourceModel->find($id);
        if ($resource) {
            if (!empty($resource['media_path']) && file_exists(FCPATH . $resource['media_path'])) {
                unlink(FCPATH . $resource['media_path']);
            }
            // Questions cascade delete due to DB setup, but good to be safe if model deleting
            $this->resourceModel->delete($id);
            return redirect()->back()->with('success', 'Resource deleted successfully');
        }
        return redirect()->back()->with('error', 'Resource not found');
    }

    // --- Questions Logic ---

    // DIRECT Question Creation (For modules without grouped resources, if any)
    public function createQuestion($moduleId)
    {
        $data['module'] = $this->moduleModel->find($moduleId);
        $data['exam'] = $this->examModel->find($data['module']['exam_id']);

        // Fetch existing questions for this module (that might not have a resource)
        $data['questions'] = $this->questionModel->where('module_id', $moduleId)->where('resource_id', null)->orderBy('id', 'DESC')->findAll();

        return view('admin/test_prep/create_question', $data);
    }

    public function storeQuestion()
    {
        $moduleId = $this->request->getPost('module_id');
        $resourceId = $this->request->getPost('resource_id'); // Optional

        $questionText = $this->request->getPost('question_text');
        $type = $this->request->getPost('type');
        $correctAnswer = $this->request->getPost('correct_answer');

        // Handle Options (JSON)
        $options = $this->request->getPost('options');

        // Filter out empty options
        $cleanOptions = [];
        if (is_array($options)) {
            foreach ($options as $key => $val) {
                if (!empty(trim($val))) {
                    $cleanOptions[$key] = trim($val);
                }
            }
        }

        // Only encode if we have options, otherwise null (or empty JSON depending on DB)
        // Only encode if we have options, otherwise null (or empty JSON depending on DB)
        // CODE FIX: Do not json_encode here, the Model handles it via $casts
        // CODE FIX 2: Pass [] instead of null to avoid "Field options is not nullable" error
        $optionsData = !empty($cleanOptions) ? $cleanOptions : [];

        $data = [
            'module_id' => $moduleId,
            'resource_id' => !empty($resourceId) ? $resourceId : null,
            'question_text' => $questionText,
            'type' => $type,
            'options' => $optionsData,
            'correct_answer' => $correctAnswer,
        ];

        // Legacy Media Upload (Directly on question)
        $file = $this->request->getFile('media_file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/test_prep_media', $newName);
            $data['media_path'] = 'uploads/test_prep_media/' . $newName;
        }

        if (!$this->questionModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', 'Failed to save question. Please check internal logs.');
        }

        // Redirect based on where it came from
        if (!empty($resourceId)) {
            return redirect()->to("admin/test-prep/manage-resource/$resourceId")->with('success', 'Question added to resource');
        }

        return redirect()->to("admin/test-prep/create-question/$moduleId")->with('success', 'Question added successfully');
    }

    public function aiSuggestTopic()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid request']);
        }

        $type = $this->request->getPost('type') ?? 'writing';

        try {
            $ai = new \App\Libraries\AIService();
            $result = $ai->generateTestPrepTopic($type);

            if (isset($result['error'])) {
                return $this->response->setStatusCode(500)->setJSON($result);
            }

            return $this->response->setJSON($result);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function deleteQuestion($id)
    {
        $question = $this->questionModel->find($id);
        if ($question) {
            if (!empty($question['media_path']) && file_exists(FCPATH . $question['media_path'])) {
                unlink(FCPATH . $question['media_path']);
            }
            $this->questionModel->delete($id);
            return redirect()->back()->with('success', 'Question deleted successfully');
        }
        return redirect()->back()->with('error', 'Question not found');
    }
}
