<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CourseModel;
use App\Models\UniversityModel;
use App\Models\ImportLogModel;

class CourseController extends BaseController
{
    protected $courseModel;
    protected $universityModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->universityModel = new UniversityModel();
    }

    public function index()
    {
        $search = $this->request->getVar('search');

        $courseModel = $this->courseModel->select('courses.*, universities.name as university_name, universities.slug as university_slug, countries.slug as country_slug')
            ->join('universities', 'universities.id = courses.university_id')
            ->join('countries', 'countries.id = universities.country_id');

        if ($search) {
            $courseModel->groupStart()
                ->like('courses.name', $search)
                ->orLike('universities.name', $search)
                ->orLike('courses.field', $search)
                ->orLike('courses.field', $search)
                ->groupEnd();
        }

        // Filter for Uni Rep
        if (session()->get('role_id') == 4) {
            $courseModel->where('universities.id', session()->get('university_id'));
        }

        $data = [
            'title' => 'Manage Courses',
            'courses' => $courseModel->paginate(20, 'default'),
            'pager' => $this->courseModel->pager,
            'search' => $search
        ];
        return view('admin/courses/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Add Course',
            'universities' => (session()->get('role_id') == 4)
                ? $this->universityModel->where('id', session()->get('university_id'))->findAll()
                : $this->universityModel->findAll(),
        ];
        return view('admin/courses/create', $data);
    }

    public function store()
    {
        if (!$this->checkPermission('create', 'course')) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $uniId = $this->request->getPost('university_id');
        // Extra check for Uni Rep to prevent tampering
        if (session()->get('role_id') == 4 && $uniId != session()->get('university_id')) {
            return redirect()->back()->with('error', 'Permission denied. Cannot add course to another university.');
        }

        $data = [
            'university_id' => $uniId,
            'name' => $this->request->getPost('name'),
            'level' => $this->request->getPost('level'),
            'field' => $this->request->getPost('field'),
            'stem' => $this->request->getPost('stem') ? 1 : 0,
            'duration_months' => $this->request->getPost('duration_months'),
            'tuition_fee' => $this->request->getPost('tuition_fee'),
            'credits' => (int) $this->request->getPost('credits'),
            'intake_months' => json_encode($this->request->getPost('intake_months')),
            'metadata' => json_encode($this->request->getPost('metadata')),
        ];

        $this->courseModel->insert($data);
        return redirect()->to(base_url('admin/courses'))->with('success', 'Course added successfully');
    }

    public function uploadBulk()
    {
        // Only Admin and Counsellor can upload bulk
        if (session()->get('role_id') == 4) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        set_time_limit(600); // 10 minutes for AI processing
        $aiService = new \App\Libraries\AIService();

        $file = $this->request->getFile('bulk_csv');
        if (!$file->isValid())
            return redirect()->back()->with('error', 'Invalid file');

        $csvFile = fopen($file->getTempName(), 'r');
        $headers = fgetcsv($csvFile);
        if (!$headers)
            return redirect()->back()->with('error', 'CSV file is empty');

        // Clean headers
        $headers = array_map(function ($h) {
            return strtolower(trim($h));
        }, $headers);

        // Define column mapping
        $mapping = [
            'university_id' => ['university_id', 'university', 'uni_id'],
            'name' => ['name', 'course_name', 'program_name', 'program'],
            'level' => ['level', 'course_level', 'degree', 'program_level'],
            'field' => ['field', 'subject', 'discipline', 'study_field', 'field_of_study'],
            'stem' => ['stem', 'is_stem'],
            'duration_months' => ['duration', 'duration_months', 'months'],
            'tuition_fee' => ['fee', 'tuition', 'tuition_fee', 'cost', 'annual_tuition_fee'],
            'credits' => ['credits', 'total_credits', 'credit_hours'],
            'intake_months' => ['intake', 'intake_months', 'intakes'],
            'notes' => ['notes', 'description', 'about'],
            'syllabus' => ['syllabus', 'modules', 'subjects'],
            'career_outcomes' => ['career_outcomes', 'careers', 'outcomes'],
            'employment_rate' => ['employment_rate', 'employment'],
            'avg_salary' => ['avg_salary', 'salary'],
            'top_roles' => ['top_roles', 'roles', 'jobs'],
            'ielts_score' => ['ielts_score', 'ielts'],
            'toefl_score' => ['toefl_score', 'toefl'],
            'pte_score' => ['pte_score', 'pte'],
            'duolingo_score' => ['duolingo_score', 'duolingo'],
            'gpa_requirement' => ['gpa_requirement', 'gpa'],
            'work_experience_years' => ['work_experience_years', 'work_exp', 'experience'],
            'application_deadline' => ['application_deadline', 'deadline'],
            'document_submission_deadline' => ['document_deadline', 'document_submission_deadline'],
            'application_url' => ['application_url', 'link'],
            'official_course_url' => ['official_course_url', 'course_url'],
            'scholarship_deadline' => ['scholarship_deadline'],
            'tuition_deposit_deadline' => ['tuition_deposit_deadline', 'deposit_deadline'],
            'gmat_score' => ['gmat_score', 'min_gmat'],
            'gre_score' => ['gre_score', 'min_gre'],
            'accepts_15_years' => ['accepts_15_years', '15_years_education'],
            'sat_score' => ['sat_score', 'min_sat'],
            'act_score' => ['act_score', 'min_act'],
            'application_fee' => ['application_fee', 'app_fee', 'fee']
        ];

        // Dynamically add requirement parameters from database
        $paramModel = new \App\Models\RequirementParameterModel();
        $dbParams = $paramModel->findAll();

        $metadataFields = [
            'notes',
            'syllabus',
            'career_outcomes',
            'employment_rate',
            'avg_salary',
            'top_roles'
        ];

        foreach ($dbParams as $p) {
            $code = $p['code'];
            // Add to mapping if not already there, using code and label as aliases
            if (!isset($mapping[$code])) {
                $mapping[$code] = [$code, strtolower($p['label'])];
            }
            if (!in_array($code, $metadataFields)) {
                $metadataFields[] = $code;
            }
        }

        $success = 0;
        $failed = 0;

        while (($row = fgetcsv($csvFile, 10000, ",")) !== FALSE) {
            try {
                $data = [];
                $metadata = [];

                foreach ($headers as $index => $header) {
                    $value = isset($row[$index]) ? trim($row[$index]) : null;
                    if ($value === null || $value === '')
                        continue;

                    $mapped = false;
                    foreach ($mapping as $field => $aliases) {
                        if (in_array($header, $aliases)) {
                            if ($field == 'stem') {
                                $data[$field] = (strtoupper($value) == 'YES' || $value == '1' || strtoupper($value) == 'STEM') ? 1 : 0;
                            } elseif ($field == 'intake_months') {
                                $intakes = array_map('trim', explode(',', $value));
                                $data[$field] = json_encode($intakes);
                            } elseif (in_array($field, $metadataFields)) {
                                $metadata[$field] = $value;
                            } else {
                                $data[$field] = $value;
                            }
                            $mapped = true;
                            break;
                        }
                    }

                    if (!$mapped && $value !== null && $value !== '') {
                        $metadata[$header] = $value;
                    }
                }

                if (isset($data['name']) && isset($data['university_id'])) {
                    // AI Filling for missing dynamic fields
                    $needsAI = empty($data['field']) || empty($metadata['notes']) || empty($metadata['syllabus']);
                    if ($needsAI) {
                        $uni = $this->universityModel->find($data['university_id']);
                        $aiInput = [
                            'university' => $uni['name'] ?? 'Selected University',
                            'name' => $data['name'],
                            'level' => $data['level'] ?? 'N/A'
                        ];
                        $aiData = $aiService->generateCourseInsights($aiInput);
                        if ($aiData && !isset($aiData['error'])) {
                            if (empty($data['field']))
                                $data['field'] = $aiData['field'] ?? null;
                            if (empty($data['credits']))
                                $data['credits'] = $aiData['credits'] ?? null;
                            foreach (['notes', 'syllabus', 'career_outcomes', 'employment_rate', 'avg_salary', 'top_roles'] as $k) {
                                if (empty($metadata[$k]))
                                    $metadata[$k] = $aiData[$k] ?? null;
                            }
                        }
                    }

                    if (!empty($metadata)) {
                        $data['metadata'] = json_encode($metadata);
                    }

                    $this->courseModel->insert($data);
                    $success++;
                } else {
                    $failed++;
                }
            } catch (\Exception $e) {
                $failed++;
            }
        }
        fclose($csvFile);

        $logModel = new ImportLogModel();
        $logModel->insert(['entity' => 'course', 'total' => $success + $failed, 'success' => $success, 'failed' => $failed]);

        return redirect()->back()->with('success', "Import complete: $success success, $failed failed. AI assisted in filling missing program details.");
    }

    public function downloadTemplate()
    {
        $filename = "course_upload_template_" . date('Y-m-d') . ".csv";

        // Base Headers (removed AI-generated fields: notes, syllabus, career_outcomes, employment_rate, avg_salary, top_roles)
        $header = [
            'university_id',
            'course_name',
            'program_level',
            'is_stem',
            'duration_months',
            'annual_tuition_fee',
            'total_credits',
            'intake_months'
        ];

        // Fetch all requirement parameters from DB
        $paramModel = new \App\Models\RequirementParameterModel();
        $dbParams = $paramModel->findAll();
        foreach ($dbParams as $p) {
            if (!in_array($p['code'], $header)) {
                $header[] = $p['code'];
            }
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, $header);

        // Sample Data row
        $sampleData = [
            '1',
            'MS Machine Learning',
            'Masters',
            'YES',
            '24',
            '45000',
            '120',
            'Jan, Sep',
            '',
            '',
            '',
            '',
            '',
            ''
        ];

        // Fill empty values for all extra parameters to match header length
        $extraCount = count($header) - count($sampleData);
        for ($i = 0; $i < $extraCount; $i++) {
            $sampleData[] = '';
        }

        fputcsv($output, $sampleData);
        fclose($output);
        exit;
    }
    public function edit($id)
    {
        $course = $this->courseModel->find($id);
        if (!$course)
            return redirect()->back()->with('error', 'Course not found');

        // Decode JSON fields for easier access in the view
        $course['intake_months'] = json_decode($course['intake_months'] ?? '[]', true) ?: [];
        $course['metadata'] = json_decode($course['metadata'] ?? '{}', true) ?: [];

        if (!$this->checkPermission('update', 'course', $id)) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $data = [
            'title' => 'Edit Course',
            'course' => $course,
            'universities' => (session()->get('role_id') == 4)
                ? $this->universityModel->where('id', session()->get('university_id'))->findAll()
                : $this->universityModel->findAll(),
        ];
        return view('admin/courses/edit', $data);
    }

    public function update($id)
    {
        if (!$this->checkPermission('update', 'course', $id)) {
            return redirect()->back()->with('error', 'Permission denied.');
        }

        $data = [
            'university_id' => (session()->get('role_id') == 4) ? session()->get('university_id') : $this->request->getPost('university_id'),
            'name' => $this->request->getPost('name'),
            'level' => $this->request->getPost('level'),
            'field' => $this->request->getPost('field'),
            'stem' => $this->request->getPost('stem') ? 1 : 0,
            'duration_months' => $this->request->getPost('duration_months'),
            'tuition_fee' => $this->request->getPost('tuition_fee'),
            'credits' => (int) $this->request->getPost('credits'),
            'intake_months' => json_encode($this->request->getPost('intake_months')),
            'metadata' => json_encode($this->request->getPost('metadata')),
        ];

        $this->courseModel->update($id, $data);
        return redirect()->to(base_url('admin/courses'))->with('success', 'Course updated successfully');
    }

    public function delete($id)
    {
        if (!$this->checkPermission('delete', 'course', $id)) {
            return redirect()->back()->with('error', 'Permission denied.');
        }
        $this->courseModel->delete($id);
        return redirect()->to(base_url('admin/courses'))->with('success', 'Course deleted successfully');
    }

    public function aiAutoFill()
    {
        $url = $this->request->getPost('url');
        if (!$url) {
            return $this->response->setJSON(['error' => 'URL is required']);
        }

        $aiService = new \App\Libraries\AIService();
        $result = $aiService->extractCourseDetails($url);

        return $this->response->setJSON([
            'csrf' => csrf_hash(),
            'data' => $result
        ]);
    }

    public function generateInsights()
    {
        $universityId = $this->request->getPost('university_id');
        $university = $this->universityModel->find($universityId);

        $courseData = [
            'university' => $university['name'] ?? 'Selected University',
            'name' => $this->request->getPost('name'),
            'level' => $this->request->getPost('level'),
            'field' => $this->request->getPost('field'),
        ];

        $aiService = new \App\Libraries\AIService();
        $result = $aiService->generateCourseInsights($courseData);

        return $this->response->setJSON([
            'csrf' => csrf_hash(),
            'data' => $result
        ]);
    }
}
