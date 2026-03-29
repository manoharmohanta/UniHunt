<?php

namespace App\Controllers;

use App\Models\UniversityModel;
use App\Models\CourseModel;
use CodeIgniter\API\ResponseTrait;

class ComparisonController extends BaseController
{
    use ResponseTrait;

    protected $session;

    public function __construct()
    {
        $this->session = session();
        if (!$this->session->has('compare_universities')) {
            $this->session->set('compare_universities', []);
        }
        if (!$this->session->has('compare_courses')) {
            $this->session->set('compare_courses', []);
        }
    }

    public function toggle()
    {
        $type = $this->request->getPost('type'); // 'university' or 'course'
        $id = $this->request->getPost('id');

        if (!$type || !$id) {
            return $this->fail('Invalid parameters.');
        }

        $sessionKey = ($type === 'university') ? 'compare_universities' : 'compare_courses';
        $currentList = $this->session->get($sessionKey);

        if (in_array($id, $currentList)) {
            // Remove
            $currentList = array_diff($currentList, [$id]);
            $this->session->set($sessionKey, array_values($currentList));
            return $this->respond([
                'status' => 'removed',
                'message' => 'Removed from comparison.',
                'count' => count($currentList)
            ]);
        } else {
            // Add (limit to 3 for UX)
            if (count($currentList) >= 3) {
                return $this->fail('You can only compare up to 3 items at a time.');
            }
            $currentList[] = $id;
            $this->session->set($sessionKey, array_values($currentList));
            return $this->respond([
                'status' => 'added',
                'message' => 'Added to comparison.',
                'count' => count($currentList)
            ]);
        }
    }

    public function university()
    {
        $uniIds = $this->session->get('compare_universities');

        $universities = [];
        if (!empty($uniIds)) {
            $uniModel = new UniversityModel();
            $universities = $uniModel->select('universities.*, countries.name as country_name, countries.slug as country_slug, logo_img.file_name as logo_path')
                ->join('countries', 'countries.id = universities.country_id')
                ->join('university_images as logo_img', 'logo_img.university_id = universities.id AND logo_img.image_type = "logo"', 'left')
                ->whereIn('universities.id', $uniIds)
                ->findAll();
        }

        return view('web/university-comparision', [
            'universities' => $universities,
            'title' => 'University Comparison | UniHunt'
        ]);
    }

    public function course()
    {
        $courseIds = $this->session->get('compare_courses');

        $courses = [];
        if (!empty($courseIds)) {
            $courseModel = new CourseModel();
            $courses = $courseModel->select('courses.*, universities.name as university_name, universities.slug as uni_slug, countries.name as country_name, countries.slug as country_slug, logo_img.file_name as logo_path')
                ->join('universities', 'universities.id = courses.university_id')
                ->join('countries', 'countries.id = universities.country_id')
                ->join('university_images as logo_img', 'logo_img.university_id = universities.id AND logo_img.image_type = "logo"', 'left')
                ->whereIn('courses.id', $courseIds)
                ->findAll();
        }

        return view('web/course-comparison', [
            'courses' => $courses,
            'title' => 'Course Comparison | UniHunt'
        ]);
    }

    public function clear()
    {
        $type = $this->request->getGet('type');
        if ($type === 'university') {
            $this->session->set('compare_universities', []);
        } elseif ($type === 'course') {
            $this->session->set('compare_courses', []);
        } else {
            $this->session->set('compare_universities', []);
            $this->session->set('compare_courses', []);
        }
        return redirect()->back();
    }
}
