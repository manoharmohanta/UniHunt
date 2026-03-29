<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RequirementParameterModel;

class RequirementController extends BaseController
{
    protected $paramModel;

    public function __construct()
    {
        $this->paramModel = new RequirementParameterModel();
    }

    public function index()
    {
        $countryModel = new \App\Models\CountryModel();
        $search = $this->request->getGet('q');

        $query = $this->paramModel->select('requirement_parameters.*, countries.name as country_name')
            ->join('countries', 'countries.id = requirement_parameters.country_id', 'left');

        if ($search) {
            $query->groupStart()
                ->like('requirement_parameters.code', $search)
                ->orLike('requirement_parameters.label', $search)
                ->orLike('requirement_parameters.category_tags', $search)
                ->orLike('countries.name', $search)
                ->groupEnd();
        }

        $data = [
            'title' => 'Requirement Parameters',
            'parameters' => $query->orderBy('requirement_parameters.id', 'DESC')->paginate(20),
            'pager' => $this->paramModel->pager->only(['q']),
            'countries' => $countryModel->findAll(),
            'search' => $search
        ];
        return view('admin/settings/requirements', $data);
    }

    public function storeParam()
    {
        $data = [
            'code' => trim($this->request->getPost('code')),
            'label' => trim($this->request->getPost('label')),
            'country_id' => $this->request->getPost('country_id') ?: null,
            'applies_to' => $this->request->getPost('applies_to'),
            'type' => $this->request->getPost('type'),
            'category_tags' => trim($this->request->getPost('category_tags')),
        ];

        try {
            if ($this->paramModel->save($data)) {
                return redirect()->back()->with('success', 'Parameter "' . $data['label'] . '" added successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to add parameter. Please check your inputs.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Database Error: ' . $e->getMessage());
        }
    }

    public function updateParam()
    {
        $id = $this->request->getPost('id');
        if (!$id) {
            return redirect()->back()->with('error', 'Missing Parameter ID for update.');
        }

        $data = [
            'id' => $id,
            'code' => trim($this->request->getPost('code')),
            'label' => trim($this->request->getPost('label')),
            'country_id' => $this->request->getPost('country_id') ?: null,
            'applies_to' => $this->request->getPost('applies_to'),
            'type' => $this->request->getPost('type'),
            'category_tags' => trim($this->request->getPost('category_tags')),
        ];

        try {
            if ($this->paramModel->save($data)) {
                return redirect()->to(base_url('admin/requirements'))->with('success', 'Parameter "' . $data['label'] . '" updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to update parameter. Check if the code is unique.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Database Error: ' . $e->getMessage());
        }
    }

    public function deleteParam($id)
    {
        $this->paramModel->delete($id);
        return redirect()->back()->with('success', 'Parameter deleted successfully');
    }

    public function getRequirements()
    {
        $targetType = $this->request->getPost('target_type'); // 'University' or 'Course'
        $countryId = $this->request->getPost('country_id');
        $universityId = $this->request->getPost('university_id');
        $level = $this->request->getPost('level');
        $isStem = $this->request->getPost('stem') == 'true' || $this->request->getPost('stem') === true;

        $countryName = null;
        $countryCode = null;

        // If university_id is provided but country_id is not, fetch the country_id from the university
        if ($universityId) {
            $universityModel = new \App\Models\UniversityModel();
            $university = $universityModel->find($universityId);
            if ($university) {
                $countryId = $university['country_id'];

                $countryModel = new \App\Models\CountryModel();
                $country = $countryModel->find($countryId);
                if ($country) {
                    $countryName = $country['name'];
                    $countryCode = $country['code'];
                }
            }
        }

        $query = $this->paramModel->whereIn('applies_to', [$targetType, 'Both']);

        // Filter by country context: Global (null) or specific country
        $query->groupStart()
            ->where('country_id', NULL)
            ->orWhere('country_id', $countryId ?: null)
            ->groupEnd();

        // If it's a course, filter by level tags and country tags
        if ($targetType == 'Course' && $level) {
            $query->groupStart()
                ->like('category_tags', $level)
                ->orLike('category_tags', 'General')
                ->orLike('category_tags', 'International');

            if ($countryName) {
                $query->orLike('category_tags', $countryName);
            }
            if ($countryCode) {
                $query->orLike('category_tags', $countryCode);
            }

            if ($isStem) {
                $query->orLike('category_tags', 'STEM');
            }
            $query->groupEnd();

            // Special logic: If it's a Masters but the tag says Bachelors (and not Masters), exclude it
            // We can do this with a post-process or more complex query.
            // For now, adding the country tags will fix the "not showing" issue.
        }

        $results = $query->findAll();

        // Post-filter level mismatches to be precise
        if ($targetType == 'Course' && $level) {
            $allLevels = ['Diploma', 'Bachelors', 'Masters', 'PhD'];
            $otherLevels = array_diff($allLevels, [$level]);

            $results = array_filter($results, function ($param) use ($level, $otherLevels) {
                // Ensure category_tags is not null
                $tagStr = $param['category_tags'] ?? '';
                $tags = explode(',', $tagStr);
                $tags = array_map('trim', $tags);

                // If the param specifically mentions other levels, but not the current one, exclude it
                // This prevents a Masters course from seeing Bachelors-only requirements
                $mentionsCurrent = in_array($level, $tags);
                $mentionsOther = !empty(array_intersect($otherLevels, $tags));

                if ($mentionsOther && !$mentionsCurrent) {
                    return false;
                }

                return true;
            });
            $results = array_values($results); // Reset indices
        }

        $countryData = null;
        if ($countryId) {
            $countryModel = new \App\Models\CountryModel();
            $countryData = $countryModel->find($countryId);
        }

        return $this->response->setJSON([
            'csrf' => csrf_hash(),
            'results' => $results,
            'country' => $countryData
        ]);
    }
}
