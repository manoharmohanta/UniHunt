<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;

class LocationController extends BaseController
{
    protected $countryModel;
    protected $stateModel;
    protected $cityModel;

    public function __construct()
    {
        $this->countryModel = new CountryModel();
        $this->stateModel = new StateModel();
        $this->cityModel = new CityModel();
    }

    public function index()
    {
        $search = $this->request->getGet('q');
        $tab = $this->request->getGet('tab') ?: 'countries';
        $countryId = $this->request->getGet('country_id');
        $stateId = $this->request->getGet('state_id');

        $activeCountry = $countryId ? $this->countryModel->find($countryId) : null;
        $activeState = $stateId ? $this->stateModel->find($stateId) : null;

        // Countries
        $countryBuilder = $this->countryModel->select('countries.*, (SELECT COUNT(*) FROM universities WHERE universities.country_id = countries.id) as university_count');
        if ($search && $tab == 'countries') {
            $countryBuilder->groupStart()->like('name', $search)->orLike('code', $search)->groupEnd();
        }
        $countries = $countryBuilder->paginate(10, 'countries');

        // States
        $stateBuilder = $this->stateModel->select('states.*, countries.name as country_name, (SELECT COUNT(*) FROM universities WHERE universities.state_id = states.id) as university_count')
            ->join('countries', 'countries.id = states.country_id');

        if ($countryId) {
            $stateBuilder->where('states.country_id', $countryId);
        }

        if ($search && $tab == 'states') {
            $stateBuilder->groupStart()->like('states.name', $search)->orLike('countries.name', $search)->groupEnd();
        }
        $states = $stateBuilder->paginate(10, 'states');

        // Cities
        $cityBuilder = $this->cityModel->select('cities.*, countries.name as country_name, states.name as state_name')
            ->join('countries', 'countries.id = cities.country_id')
            ->join('states', 'states.id = cities.state_id', 'left');

        if ($stateId) {
            $cityBuilder->where('cities.state_id', $stateId);
        } elseif ($countryId) {
            $cityBuilder->where('cities.country_id', $countryId);
        }

        if ($search && $tab == 'cities') {
            $cityBuilder->groupStart()->like('cities.name', $search)->orLike('countries.name', $search)->orLike('states.name', $search)->groupEnd();
        }
        $cities = $cityBuilder->paginate(10, 'cities');

        // Universities (New Tab)
        $universityModel = new \App\Models\UniversityModel();
        $uniBuilder = $universityModel->select('universities.*, countries.name as country_name, states.name as state_name')
            ->join('countries', 'countries.id = universities.country_id')
            ->join('states', 'states.id = universities.state_id', 'left');

        if ($stateId) {
            $uniBuilder->where('universities.state_id', $stateId);
        } elseif ($countryId) {
            $uniBuilder->where('universities.country_id', $countryId);
        }

        if ($search && $tab == 'universities') {
            $uniBuilder->groupStart()->like('universities.name', $search)->orLike('countries.name', $search)->orLike('states.name', $search)->groupEnd();
        }
        $universities = $uniBuilder->paginate(10, 'universities');

        $data = [
            'title' => 'Location Management',
            'countries' => $countries,
            'countries_pager' => $this->countryModel->pager,
            'states' => $states,
            'states_pager' => $this->stateModel->pager,
            'cities' => $cities,
            'cities_pager' => $this->cityModel->pager,
            'universities' => $universities,
            'universities_pager' => $universityModel->pager,
            'search' => $search,
            'tab' => $tab,
            'country_id' => $countryId,
            'state_id' => $stateId,
            'active_country' => $activeCountry,
            'active_state' => $activeState,
            'all_countries' => $this->countryModel->findAll(), // For dropdowns
        ];

        // Preserve filters in pager
        $pagerParams = array_filter([
            'tab' => $tab,
            'q' => $search,
            'country_id' => $countryId,
            'state_id' => $stateId
        ]);

        if ($tab == 'countries')
            $this->countryModel->pager->only(array_keys($pagerParams));
        if ($tab == 'states')
            $this->stateModel->pager->only(array_keys($pagerParams));
        if ($tab == 'cities')
            $this->cityModel->pager->only(array_keys($pagerParams));
        if ($tab == 'universities')
            $universityModel->pager->only(array_keys($pagerParams));

        return view('admin/locations/index', $data);
    }

    public function storeCountry()
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'code' => $this->request->getPost('code'),
            'currency' => $this->request->getPost('currency'),
        ];

        $this->countryModel->insert($data);
        return redirect()->to(base_url('admin/locations?tab=countries'))->with('success', 'Country added successfully');
    }

    public function updateCountry($id)
    {
        $data = [
            'name' => $this->request->getPost('name'),
            'slug' => url_title($this->request->getPost('name'), '-', true),
            'code' => $this->request->getPost('code'),
            'currency' => $this->request->getPost('currency'),
        ];

        $this->countryModel->update($id, $data);
        return redirect()->to(base_url('admin/locations?tab=countries'))->with('success', 'Country updated successfully');
    }

    public function deleteCountry($id)
    {
        $this->countryModel->delete($id);
        return redirect()->to(base_url('admin/locations?tab=countries'))->with('success', 'Country deleted successfully');
    }

    public function storeState()
    {
        $name = $this->request->getPost('name');
        $countryId = $this->request->getPost('country_id');

        // Duplicate Check
        $exists = $this->stateModel->where('name', $name)->where('country_id', $countryId)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'State "' . $name . '" already exists in this country.')->withInput();
        }

        $data = [
            'country_id' => $countryId,
            'name' => $name,
        ];

        $this->stateModel->insert($data);
        return redirect()->to(base_url('admin/locations?tab=states'))->with('success', 'State added successfully');
    }

    public function updateState($id)
    {
        $data = [
            'country_id' => $this->request->getPost('country_id'),
            'name' => $this->request->getPost('name'),
        ];

        $this->stateModel->update($id, $data);
        return redirect()->to(base_url('admin/locations?tab=states'))->with('success', 'State updated successfully');
    }

    public function deleteState($id)
    {
        $this->stateModel->delete($id);
        return redirect()->to(base_url('admin/locations?tab=states'))->with('success', 'State deleted successfully');
    }

    public function storeCity()
    {
        $data = [
            'country_id' => $this->request->getPost('country_id'),
            'state_id' => $this->request->getPost('state_id'),
            'name' => $this->request->getPost('name'),
            'living_cost' => $this->request->getPost('living_cost'),
        ];

        $this->cityModel->insert($data);
        return redirect()->to(base_url('admin/locations?tab=cities'))->with('success', 'City added successfully');
    }

    public function updateCity($id)
    {
        $data = [
            'country_id' => $this->request->getPost('country_id'),
            'state_id' => $this->request->getPost('state_id'),
            'name' => $this->request->getPost('name'),
            'living_cost' => $this->request->getPost('living_cost'),
        ];

        $this->cityModel->update($id, $data);
        return redirect()->to(base_url('admin/locations?tab=cities'))->with('success', 'City updated successfully');
    }

    public function deleteCity($id)
    {
        $this->cityModel->delete($id);
        return redirect()->to(base_url('admin/locations?tab=cities'))->with('success', 'City deleted successfully');
    }

    public function getStatesByCountry($country_id)
    {
        $states = $this->stateModel->where('country_id', $country_id)->findAll();
        return $this->response->setJSON($states);
    }
}
