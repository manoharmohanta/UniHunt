<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ExchangeRateModel;
use App\Models\VisaTypeModel;
use App\Models\CountryModel;
use App\Models\UniversityModel;
use App\Models\CourseModel;

class SettingsController extends BaseController
{
    protected $exchangeModel;
    protected $visaModel;

    public function __construct()
    {
        $this->exchangeModel = new ExchangeRateModel();
        $this->visaModel = new VisaTypeModel();
    }

    public function exchangeRates()
    {
        $data = [
            'title' => 'Exchange Rates',
            'rates' => $this->exchangeModel->findAll(),
        ];
        return view('admin/settings/exchange_rates', $data);
    }

    public function storeExchangeRate()
    {
        $data = [
            'currency' => $this->request->getPost('currency'),
            'rate_to_usd' => $this->request->getPost('rate_to_usd'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        // Dynamic upsert logic since exchange_rates has no primary key id in SQL provided (just currency)
        $this->exchangeModel->where('currency', $data['currency'])->delete();
        $this->exchangeModel->insert($data);
        return redirect()->back()->with('success', 'Exchange rate updated');
    }

    public function deleteExchangeRate($currency)
    {
        $this->exchangeModel->where('currency', $currency)->delete();
        return redirect()->back()->with('success', 'Exchange rate deleted');
    }

    public function visaTypes()
    {
        $countryModel = new CountryModel();

        $visas = $this->visaModel->select('visa_types.*, countries.name as country_name')
            ->join('countries', 'countries.id = visa_types.country_id')
            ->orderBy('countries.name', 'ASC')
            ->paginate(15);

        $data = [
            'title' => 'Visa Types',
            'visas' => $visas,
            'pager' => $this->visaModel->pager,
            'countries' => $countryModel->orderBy('name', 'ASC')->findAll(),
        ];
        return view('admin/settings/visa_types', $data);
    }

    public function storeVisaType()
    {
        $data = [
            'country_id' => $this->request->getPost('country_id'),
            'name' => $this->request->getPost('name'),
        ];
        $this->visaModel->insert($data);
        return redirect()->back()->with('success', 'Visa type added');
    }

    public function deleteVisaType($id)
    {
        $this->visaModel->delete($id);
        return redirect()->back()->with('success', 'Visa type deleted');
    }


}
