<?php

namespace App\Controllers\Api;

use App\Models\UniversityModel;
use App\Models\CourseModel;
use App\Models\CountryModel;

class SuggestionController extends ApiController
{
    /**
     * GET /api/suggest
     * 
     * Query Parameters:
     * - primary_destination: string (Country name or slug)
     * - secondary_destination: string (Country name or slug)
     * - field_of_interest: string (e.g. "Computer Science")
     * - level: string (e.g. "Masters", "Bachelor")
     * - budget_max: numeric
     * - cgpa: numeric
     * - backlogs: numeric
     */
    public function suggest()
    {
        $params = [
            'primary_destination' => $this->request->getVar('primary_destination'),
            'secondary_destination' => $this->request->getVar('secondary_destination'),
            'field_of_interest' => $this->request->getVar('field_of_interest'),
            'level' => $this->request->getVar('level'),
            'budget_max' => $this->request->getVar('budget_max'),
        ];

        return $this->getUniversitySuggestions($params);
    }

    public function suggestByProfile()
    {
        $userId = $this->request->user_id;
        $db = \Config\Database::connect();

        $profile = $db->table('user_academic_profiles')->where('user_id', $userId)->get()->getRowArray();

        // Check if essential fields have values
        $hasCountry = !empty($profile['target_country']);
        $hasCourse = !empty($profile['course_choice']);

        if (!$profile || !$hasCountry || !$hasCourse) {
            return $this->success([], 'Academic profile is incomplete.', ['status_code' => 'profile_required']);
        }

        // Parse academic_data metadata to extract secondary destination and budget
        $metadata = [];
        if (isset($profile['academic_data']) && is_string($profile['academic_data'])) {
            $metadata = json_decode($profile['academic_data'], true) ?: [];
        }

        $params = [
            'primary_destination' => $profile['target_country'],
            'secondary_destination' => $metadata['secondary_destination'] ?? null,
            'field_of_interest' => $profile['course_choice'],
            'target_level' => $profile['target_level'],
            'level' => null,
            'budget_max' => $metadata['budget_max'] ?? null,
        ];

        return $this->getUniversitySuggestions($params);
    }

    public function matchByProfile()
    {
        $userId = $this->request->user_id;
        $db = \Config\Database::connect();

        $profile = $db->table('user_academic_profiles')->where('user_id', $userId)->get()->getRowArray();

        if (!$profile) {
            return $this->success([], 'Academic profile is required for matching.', ['status_code' => 'profile_required']);
        }

        $userIelts = (float) ($profile['ielts_score'] ?? 0);
        $userGre = (int) ($profile['gre_score'] ?? 0);

        // Get Requirement Parameter IDs for IELTS and GRE
        $params = $db->table('requirement_parameters')
            ->whereIn('code', ['ielts_score', 'gre_score'])
            ->get()
            ->getResultArray();

        $ieltsParamId = null;
        $greParamId = null;

        foreach ($params as $p) {
            if ($p['code'] === 'ielts_score')
                $ieltsParamId = $p['id'];
            if ($p['code'] === 'gre_score')
                $greParamId = $p['id'];
        }

        $uniModel = new UniversityModel();
        $query = $uniModel->select('universities.*, countries.name as country_name, countries.slug as country_slug')
            ->join('countries', 'countries.id = universities.country_id');

        // Filter by user's target country if set
        if (!empty($profile['target_country'])) {
            $query->groupStart()
                ->like('countries.name', $profile['target_country'])
                ->orLike('countries.slug', $profile['target_country'])
                ->groupEnd();
        }

        $allUnis = $query->findAll();

        $categories = [
            'ambition' => [], // User meets but matches requirement exactly or barely
            'target' => [],   // User exceeds requirement by a bit
            'safety' => []    // User exceeds requirement significantly
        ];

        foreach ($allUnis as $uni) {
            $isMatch = true;
            $ieltsDiff = 0;
            $greDiff = 0;

            // Check IELTS
            if ($ieltsParamId && $userIelts > 0) {
                $req = $db->table('university_requirements')
                    ->where('university_id', $uni['id'])
                    ->where('parameter_id', $ieltsParamId)
                    ->get()
                    ->getRowArray();

                if ($req) {
                    $reqValue = (float) $req['value'];
                    if ($reqValue > $userIelts) {
                        $isMatch = false;
                    } else {
                        $ieltsDiff = $userIelts - $reqValue;
                    }
                }
            }

            // Check GRE
            if ($isMatch && $greParamId && $userGre > 0) {
                $req = $db->table('university_requirements')
                    ->where('university_id', $uni['id'])
                    ->where('parameter_id', $greParamId)
                    ->get()
                    ->getRowArray();

                if ($req) {
                    $reqValue = (int) $req['value'];
                    if ($reqValue > $userGre) {
                        $isMatch = false;
                    } else {
                        $greDiff = $userGre - $reqValue;
                    }
                }
            }

            if ($isMatch) {
                // Attach logo
                $logo = $db->table('university_images')
                    ->where('university_id', $uni['id'])
                    ->where('image_type', 'logo')
                    ->get()
                    ->getRowArray();
                $uni['logo_url'] = $logo ? $logo['file_name'] : null;

                // Determine category
                // For IELTS: 0 gap = ambition, 0.5 gap = target, >=1.0 gap = safety
                // For GRE: 0-10 gap = ambition, 11-30 gap = target, >30 gap = safety

                if ($ieltsDiff >= 1.0 || ($userGre > 0 && $greDiff > 30)) {
                    $categories['safety'][] = $uni;
                } elseif ($ieltsDiff >= 0.5 || ($userGre > 0 && $greDiff > 10)) {
                    $categories['target'][] = $uni;
                } else {
                    $categories['ambition'][] = $uni;
                }
            }
        }

        // Sort each category by ranking ASC
        foreach ($categories as $key => &$list) {
            usort($list, function ($a, $b) {
                return ($a['ranking'] ?? 9999) - ($b['ranking'] ?? 9999);
            });
        }

        return $this->success($categories);
    }

    public function matchCoursesByProfile()
    {
        $userId = $this->request->user_id;
        $db = \Config\Database::connect();

        $profile = $db->table('user_academic_profiles')->where('user_id', $userId)->get()->getRowArray();

        if (!$profile) {
            return $this->success([], 'Academic profile is required for course matching.', ['status_code' => 'profile_required']);
        }

        $userIelts = (float) ($profile['ielts_score'] ?? 0);
        $userGre = (int) ($profile['gre_score'] ?? 0);
        $targetField = $profile['course_choice'] ?? null;
        $targetLevel = $profile['target_level'] ?? null;

        // Get Requirement Parameter IDs for IELTS and GRE
        $params = $db->table('requirement_parameters')
            ->whereIn('code', ['ielts_score', 'gre_score'])
            ->get()
            ->getResultArray();

        $ieltsParamId = null;
        $greParamId = null;

        foreach ($params as $p) {
            if ($p['code'] === 'ielts_score')
                $ieltsParamId = $p['id'];
            if ($p['code'] === 'gre_score')
                $greParamId = $p['id'];
        }

        $courseModel = new \App\Models\CourseModel();
        $query = $courseModel->select('courses.*, universities.name as university_name, countries.name as country_name, countries.slug as country_slug, universities.slug as university_slug')
            ->join('universities', 'universities.id = courses.university_id')
            ->join('countries', 'countries.id = universities.country_id');

        // Filter by user's field of interest if set
        if (!empty($targetField)) {
            $query->like('courses.field', $targetField)->orLike('courses.name', $targetField);
        }

        // Filter by target level if set
        if (!empty($targetLevel)) {
            $dbLevel = $targetLevel;
            if (strpos($targetLevel, 'Bachelors') !== false)
                $dbLevel = 'Bachelors';
            if (strpos($targetLevel, 'Masters') !== false)
                $dbLevel = 'Masters';
            $query->like('courses.level', $dbLevel);
        }

        // Filter by target country if set
        if (!empty($profile['target_country'])) {
            $query->groupStart()
                ->like('countries.name', $profile['target_country'])
                ->orLike('countries.slug', $profile['target_country'])
                ->groupEnd();
        }

        $allCourses = $query->limit(50)->findAll(); // Limiting to top 50 matches for performance

        $categories = [
            'ambition' => [],
            'target' => [],
            'safety' => []
        ];

        foreach ($allCourses as $course) {
            $isMatch = true;
            $ieltsDiff = 0;
            $greDiff = 0;

            // Check Course-specific IELTS
            if ($ieltsParamId && $userIelts > 0) {
                $req = $db->table('course_requirements')
                    ->where('course_id', $course['id'])
                    ->where('parameter_id', $ieltsParamId)
                    ->get()
                    ->getRowArray();

                if ($req) {
                    $reqValue = (float) $req['value'];
                    if ($reqValue > $userIelts) {
                        $isMatch = false;
                    } else {
                        $ieltsDiff = $userIelts - $reqValue;
                    }
                }
            }

            // Check Course-specific GRE
            if ($isMatch && $greParamId && $userGre > 0) {
                $req = $db->table('course_requirements')
                    ->where('course_id', $course['id'])
                    ->where('parameter_id', $greParamId)
                    ->get()
                    ->getRowArray();

                if ($req) {
                    $reqValue = (int) $req['value'];
                    if ($reqValue > $userGre) {
                        $isMatch = false;
                    } else {
                        $greDiff = $userGre - $reqValue;
                    }
                }
            }

            if ($isMatch) {
                // Attach University Logo
                $logo = $db->table('university_images')
                    ->where('university_id', $course['university_id'])
                    ->where('image_type', 'logo')
                    ->get()
                    ->getRowArray();
                $course['logo_url'] = $logo ? $logo['file_name'] : null;

                // Determine category
                if ($ieltsDiff >= 1.0 || ($userGre > 0 && $greDiff > 30)) {
                    $categories['safety'][] = $course;
                } elseif ($ieltsDiff >= 0.5 || ($userGre > 0 && $greDiff > 10)) {
                    $categories['target'][] = $course;
                } else {
                    $categories['ambition'][] = $course;
                }
            }
        }

        return $this->success($categories);
    }

    private function getUniversitySuggestions(array $params)
    {
        $primaryDest = $params['primary_destination'] ?? null;
        $secondaryDest = $params['secondary_destination'] ?? null;
        $field = $params['field_of_interest'] ?? null;
        $targetLevel = $params['target_level'] ?? null;
        $level = $params['level'] ?? $targetLevel; // Fallback to targetLevel if provided
        $budgetMax = $params['budget_max'] ?? null;

        $uniModel = new \App\Models\UniversityModel();

        $query = $uniModel->select('universities.*, countries.name as country_name, countries.slug as country_slug')
            ->join('countries', 'countries.id = universities.country_id');

        // 1. Filter by Destinations
        $destNames = array_filter([$primaryDest, $secondaryDest]);
        if (!empty($destNames)) {
            $query->groupStart();
            foreach ($destNames as $index => $name) {
                if ($index === 0) {
                    $query->like('countries.name', $name)->orLike('countries.slug', $name);
                } else {
                    $query->orLike('countries.name', $name)->orLike('countries.slug', $name);
                }
            }
            $query->groupEnd();
        }

        // 2. Filter by Budget (Tuition Fee Max)
        if ($budgetMax && is_numeric($budgetMax)) {
            $query->where('universities.tuition_fee_max <=', $budgetMax);
        }

        // 3. Filter by Course Field and Level if provided
        if ($field || $level) {
            $db = \Config\Database::connect();
            $courseQuery = $db->table('courses')->select('university_id');

            if ($field) {
                $courseQuery->like('field', $field)->orLike('name', $field);
            }

            if ($level) {
                // Map frontend labels to approximate DB values
                $dbLevel = $level;
                if (strpos($level, 'Bachelors') !== false)
                    $dbLevel = 'Bachelors';
                if (strpos($level, 'Masters') !== false)
                    $dbLevel = 'Masters';
                if (strpos($level, '12th') !== false)
                    $dbLevel = 'High School';

                $courseQuery->groupStart()
                    ->where('level', $dbLevel)
                    ->orLike('level', $dbLevel)
                    ->groupEnd();
            }

            $matchingUniIds = $courseQuery->get()->getResultArray();
            $uniIds = array_unique(array_column($matchingUniIds, 'university_id'));

            if (!empty($uniIds)) {
                $query->whereIn('universities.id', $uniIds);
            } else {
                // If no courses match, the whole suggestion fails to find matches
                return $this->success([], 'No matching courses found for your selection.');
            }
        }

        // Sort by ranking (lower is better usually)
        $universities = $query->orderBy('ranking', 'ASC')->limit(12)->findAll();

        if (empty($universities)) {
            return $this->success([], 'No universities match your criteria.');
        }

        // 4. Attach Logos
        $imageModel = new \App\Models\UniversityImageModel();
        $uniIds = array_column($universities, 'id');
        $logos = $imageModel->whereIn('university_id', $uniIds)
            ->where('image_type', 'logo')
            ->findAll();

        $logosByUni = [];
        foreach ($logos as $logo) {
            $logosByUni[$logo['university_id']] = $logo['file_name'];
        }

        foreach ($universities as &$uni) {
            $uni['logo_url'] = isset($logosByUni[$uni['id']]) ? $logosByUni[$uni['id']] : null;
            // Clean up metadata
            if (isset($uni['metadata']) && is_string($uni['metadata'])) {
                $uni['metadata'] = json_decode($uni['metadata'], true) ?: [];
            }
        }

        return $this->success($universities);
    }

    public function matchScholarshipsByProfile()
    {
        $userId = $this->request->user_id;
        $db = \Config\Database::connect();

        $profile = $db->table('user_academic_profiles')->where('user_id', $userId)->get()->getRowArray();

        if (!$profile) {
            return $this->success([], 'Academic profile is required for scholarship matching.', ['status_code' => 'profile_required']);
        }

        $targetField = $profile['course_choice'] ?? null;
        $targetLevel = $profile['target_level'] ?? null;

        $courseModel = new \App\Models\CourseModel();
        $query = $courseModel->select('courses.*, universities.name as university_name, universities.slug as university_slug, countries.name as country_name, countries.slug as country_slug')
            ->join('universities', 'universities.id = courses.university_id')
            ->join('countries', 'countries.id = universities.country_id');

        // Filter by user's field of interest if set
        if (!empty($targetField)) {
            $query->groupStart()
                ->like('courses.field', $targetField)
                ->orLike('courses.name', $targetField)
                ->groupEnd();
        }

        // Filter by target level if set
        if (!empty($targetLevel)) {
            $dbLevel = $targetLevel;
            if (strpos($targetLevel, 'Bachelors') !== false)
                $dbLevel = 'Bachelors';
            if (strpos($targetLevel, 'Masters') !== false)
                $dbLevel = 'Masters';
            $query->like('courses.level', $dbLevel);
        }

        $allCourses = $query->findAll();

        $results = [];

        foreach ($allCourses as $course) {
            $metadata = json_decode($course['metadata'], true) ?: [];

            $hasScholarship = false;
            $scholarshipTitle = 'International Student Scholarship';
            $deadline = '';

            if (isset($metadata['scholarship_deadline']) && !empty($metadata['scholarship_deadline'])) {
                $hasScholarship = true;
                $deadline = $metadata['scholarship_deadline'];
                $scholarshipTitle = $metadata['scholarship_info'] ?? $metadata['scholarship_details'] ?? 'Academic Scholarship';
            } elseif (isset($metadata['scholarship']) && !empty($metadata['scholarship'])) {
                $hasScholarship = true;
                $scholarshipTitle = $metadata['scholarship'];
            }

            if ($hasScholarship) {
                // Attach University Logo
                $logo = $db->table('university_images')
                    ->where('university_id', $course['university_id'])
                    ->where('image_type', 'logo')
                    ->get()
                    ->getRowArray();

                $results[] = [
                    'id' => $course['id'],
                    'type' => 'Course Scholarship',
                    'title' => $course['name'],
                    'university_name' => $course['university_name'],
                    'university_slug' => $course['university_slug'],
                    'country_name' => $course['country_name'],
                    'logo_url' => $logo ? $logo['file_name'] : null,
                    'scholarship_title' => $scholarshipTitle,
                    'deadline' => $deadline,
                    'course_level' => $course['level']
                ];
            }
        }

        // Also check University-wide scholarships
        $param = $db->table('requirement_parameters')->where('code', 'scholarship_deadline')->get()->getRowArray();
        if ($param) {
            $uniReqs = $db->table('university_requirements')
                ->select('university_requirements.*, universities.name as university_name, universities.slug as university_slug, countries.name as country_name')
                ->join('universities', 'universities.id = university_requirements.university_id')
                ->join('countries', 'countries.id = universities.country_id')
                ->where('parameter_id', $param['id'])
                ->get()
                ->getResultArray();

            foreach ($uniReqs as $ur) {
                $alreadyAdded = false;
                foreach ($results as $r) {
                    if ($r['university_name'] == $ur['university_name'] && $r['type'] == 'University Scholarship') {
                        $alreadyAdded = true;
                        break;
                    }
                }

                if (!$alreadyAdded) {
                    $logo = $db->table('university_images')
                        ->where('university_id', $ur['university_id'])
                        ->where('image_type', 'logo')
                        ->get()
                        ->getRowArray();

                    $results[] = [
                        'id' => $ur['id'],
                        'type' => 'University Scholarship',
                        'title' => 'General Excellence Scholarship',
                        'university_name' => $ur['university_name'],
                        'university_slug' => $ur['university_slug'],
                        'country_name' => $ur['country_name'],
                        'logo_url' => $logo ? $logo['file_name'] : null,
                        'scholarship_title' => 'University-wide Funding',
                        'deadline' => $ur['value'],
                        'course_level' => 'All Levels'
                    ];
                }
            }
        }

        return $this->success($results);
    }
}
