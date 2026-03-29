<?php

namespace App\Controllers\Api;

use App\Models\CountryModel;
use App\Models\UniversityModel;
use App\Models\CourseModel;
use App\Models\BlogModel;
use App\Models\AdsModel;

class HomeController extends ApiController
{
    /**
     * GET /api/home
     * Returns all data needed for the home screen in one request
     */
    public function index()
    {
        // Countries
        $countryModel = new CountryModel();
        $countries = $countryModel->select('id, name, code, slug, currency')->findAll();

        // Top rated universities - order by ranking, limit 10
        $uniModel = new UniversityModel();
        $topUniversities = $uniModel
            ->select('id, name, slug, type, ranking, tuition_fee_min, tuition_fee_max')
            ->where('ranking IS NOT NULL')
            ->orderBy('CAST(ranking AS UNSIGNED)', 'ASC')
            ->limit(10)
            ->findAll();

        // Attach main image to each university
        $db = \Config\Database::connect();
        foreach ($topUniversities as &$uni) {
            $img = $db->table('university_images')
                ->where('university_id', $uni['id'])
                ->where('is_main', 1)
                ->limit(1)
                ->get()
                ->getRowArray();
            if (!$img) {
                // Fallback to any image
                $img = $db->table('university_images')
                    ->where('university_id', $uni['id'])
                    ->limit(1)
                    ->get()
                    ->getRowArray();
            }
            $uni['image'] = $img['file_name'] ?? null;
        }

        // Popular courses worldwide - ordered by most recently added, limit 12
        $courseModel = new CourseModel();
        $popularCourses = $db->table('courses')
            ->select('courses.id, courses.name, courses.level, courses.field, courses.tuition_fee, courses.duration_months, universities.name as university_name, universities.id as university_id')
            ->join('universities', 'universities.id = courses.university_id', 'left')
            ->limit(12)
            ->get()
            ->getResultArray();

        // Latest blog posts (study abroad insights)
        $blogModel = new BlogModel();
        $latestBlogs = $blogModel
            ->select('id, title, slug, category, featured_image, created_at')
            ->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->limit(6)
            ->findAll();

        // Banner Ads for homepage placement
        $adsModel = new AdsModel();
        $bannerAds = $adsModel
            ->where('placement', 'homepage_banner')
            ->where('status', 'active')
            ->where('(end_date IS NULL OR end_date >= CURDATE())')
            ->findAll();

        // Decode ad_content for direct ads
        foreach ($bannerAds as &$ad) {
            if ($ad['source_type'] === 'direct') {
                $ad['ad_content'] = json_decode($ad['ad_content'] ?? '{}', true);
            }
        }

        return $this->success([
            'countries' => $countries,
            'top_universities' => $topUniversities,
            'popular_courses' => $popularCourses,
            'latest_blogs' => $latestBlogs,
            'banner_ads' => $bannerAds,
        ]);
    }
}
