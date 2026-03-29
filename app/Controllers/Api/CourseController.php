<?php

namespace App\Controllers\Api;

use App\Models\CourseModel;
use App\Models\UniversityModel;

class CourseController extends ApiController
{
    /**
     * GET /api/courses/{id}
     */
    public function show($id = null)
    {
        $model = new CourseModel();
        $course = $model->find($id);

        if (!$course) {
            return $this->error('Course not found.', 404);
        }

        // Fetch university details for this course
        $uniModel = new UniversityModel();
        $course['university'] = $uniModel->find($course['university_id']);

        return $this->success($course);
    }
}
