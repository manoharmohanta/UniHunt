<?php

namespace App\Controllers\Api;

use App\Models\UniversityModel;
use App\Models\CourseModel;

class UniversityController extends ApiController
{
    /**
     * GET /api/universities
     */
    public function index()
    {
        $model = new UniversityModel();

        // Handle Filtering
        $countryId = $this->request->getGet('country_id');
        $type = $this->request->getGet('type'); // public/private
        $rankingMax = $this->request->getGet('ranking_max');
        $feeMax = $this->request->getGet('fee_max');
        $search = $this->request->getGet('q');
        $limit = $this->request->getGet('limit') ?? 30;
        $offset = $this->request->getGet('offset') ?? 0;

        if ($countryId) {
            $model->where('country_id', $countryId);
        }
        if ($type) {
            $model->where('type', $type);
        }
        if ($rankingMax) {
            $model->where('ranking <=', $rankingMax);
        }
        if ($feeMax) {
            $model->where('tuition_fee_max <=', $feeMax);
        }
        if ($search) {
            $model->groupStart()
                ->like('name', $search)
                ->orLike('slug', $search)
                ->groupEnd();
        }

        $data = $model->orderBy('id', 'DESC')->findAll($limit, $offset);

        if (!empty($data)) {
            $universityIds = array_column($data, 'id');
            $imageModel = new \App\Models\UniversityImageModel();
            $logos = $imageModel->whereIn('university_id', $universityIds)
                ->where('image_type', 'logo')
                ->findAll();

            // Group logos by university_id
            $logosByUni = [];
            foreach ($logos as $logo) {
                $logosByUni[$logo['university_id']][] = $logo;
            }

            // Attach logos to each university
            foreach ($data as &$uni) {
                $uni['images'] = $logosByUni[$uni['id']] ?? [];
            }
        }

        return $this->success($data);
    }

    /**
     * GET /api/universities/{id}
     */
    public function show($id = null)
    {
        $model = new UniversityModel();
        $university = $model->find($id);

        if (!$university) {
            return $this->error('University not found.', 404);
        }

        // Fetch courses for this university
        $courseModel = new CourseModel();
        $university['courses'] = $courseModel->where('university_id', $id)->findAll();

        // Fetch images
        $imageModel = new \App\Models\UniversityImageModel();
        $university['images'] = $imageModel->where('university_id', $id)->findAll();

        if (isset($university['metadata']) && is_string($university['metadata'])) {
            $university['metadata'] = json_decode($university['metadata'], true) ?: [];
        }

        return $this->success($university);
    }
}
