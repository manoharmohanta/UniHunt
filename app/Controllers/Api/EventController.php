<?php

namespace App\Controllers\Api;

use App\Models\EventModel;

class EventController extends ApiController
{
    /**
     * GET /api/events
     */
    public function index()
    {
        $model = new EventModel();

        $query = $model->select('id, title, slug, short_description, event_type, organizer, start_date, start_time, end_time, location_type, location_name, cost, image, is_featured, is_premium, status');
        // ->where('status', 'published')
        // ->where('start_date >=', date('Y-m-d'));

        // Location Filter (Search in name or address)
        $location = $this->request->getVar('location');
        if ($location) {
            $query->groupStart()
                ->like('location_name', $location)
                ->orLike('address', $location)
                ->groupEnd();
        }

        // Type Filter (Online vs Physical)
        $type = $this->request->getVar('type');
        if ($type) {
            $query->where('location_type', $type);
        }

        // Date Range Filter
        $dateStart = $this->request->getVar('date_start');
        $dateEnd = $this->request->getVar('date_end');
        if ($dateStart) {
            $query->where('start_date >=', $dateStart);
        }
        if ($dateEnd) {
            $query->where('start_date <=', $dateEnd);
        }
        // Fallback for single date parameter
        $date = $this->request->getVar('date');
        if ($date && !$dateStart) {
            $query->where('start_date >=', $date);
        }

        // Cost Filter (Free vs Paid)
        $costType = $this->request->getVar('cost_type'); // 'free' or 'paid'
        if ($costType === 'free') {
            $query->groupStart()
                ->where('cost', '0')
                ->orWhere('cost', '0.00')
                ->orWhere('cost', null)
                ->orLike('cost', 'free')
                ->groupEnd();
        } elseif ($costType === 'paid') {
            $query->groupStart()
                ->where('cost !=', '0')
                ->where('cost !=', '0.00')
                ->where('cost IS NOT NULL')
                ->notLike('cost', 'free')
                ->groupEnd();
        }

        $events = $query->orderBy('start_date', 'ASC')->findAll();

        return $this->success($events);
    }

    /**
     * GET /api/events/{id}
     */
    public function show($id = null)
    {
        $model = new EventModel();
        $event = $model->find($id);

        if (!$event) {
            return $this->error('Event not found.', 404);
        }

        return $this->success($event);
    }
}
