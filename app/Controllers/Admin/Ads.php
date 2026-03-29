<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminController;
use App\Models\AdsModel;

class Ads extends AdminController
{
    public function index()
    {
        $model = new AdsModel();
        $search = $this->request->getVar('search');

        $model->select('ads.*, users.name as posted_by')
            ->join('users', 'users.id = ads.user_id', 'left');

        if ($search) {
            $model->groupStart()
                ->like('ads.title', $search)
                ->orLike('ads.network_name', $search)
                ->orLike('ads.placement', $search)
                ->orLike('users.name', $search)
                ->groupEnd();
        }

        $data = [
            'title' => 'Ads Management | Admin',
            'ads' => $model->orderBy('ads.created_at', 'DESC')->paginate(20),
            'pager' => $model->pager->only(['search']),
            'search' => $search
        ];

        return view('admin/ads/index', $data);
    }

    public function create()
    {
        return view('admin/ads/form', [
            'title' => 'Create Ad | Admin',
            'ad' => null
        ]);
    }

    public function store()
    {
        $model = new AdsModel();

        // Prepare data
        $data = [
            'title' => $this->request->getPost('title'),
            'source_type' => $this->request->getPost('source_type'),
            'network_name' => $this->request->getPost('network_name'),
            'format' => $this->request->getPost('format'),
            'placement' => $this->request->getPost('placement'),
            'status' => $this->request->getPost('status'),
            'ad_content' => $this->request->getPost('ad_content'),

            // JSON fields need to be handled
            'targeting' => json_encode([
                'role' => $this->request->getPost('target_role') ?: [], // array input check
                'country' => $this->request->getPost('target_country')
            ]),
            'frequency_capping' => json_encode([
                'max_impressions' => $this->request->getPost('max_impressions'),
                'cooldown' => $this->request->getPost('cooldown')
            ])
        ];

        // Handle Image Upload if Direct Ad and using file upload (vs URL)
        if ($data['source_type'] === 'direct') {
            // Logic to handle direct content if it's an image upload
            // For now assume ad_content contains text/script/url, but let's check for file
            if ($file = $this->request->getFile('ad_image')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/ads', $newName);
                    // Store JSON in ad_content
                    $data['ad_content'] = json_encode([
                        'image_url' => 'uploads/ads/' . $newName,
                        'link_url' => $this->request->getPost('link_url'),
                        'cta_text' => $this->request->getPost('cta_text')
                    ]);
                }
            }
        }

        if (!$model->insert($data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(base_url('admin/ads'))->with('message', 'Ad created successfully.');
    }

    public function edit($id)
    {
        $model = new AdsModel();
        $ad = $model->find($id);

        if (!$ad) {
            return redirect()->to(base_url('admin/ads'))->with('error', 'Ad not found.');
        }

        return view('admin/ads/form', [
            'title' => 'Edit Ad | Admin',
            'ad' => $ad
        ]);
    }

    public function update($id)
    {
        $model = new AdsModel();
        $ad = $model->find($id); // fetch existing to keep old image if not updated

        // Prepare data (similar to store, but merging)
        $data = [
            'title' => $this->request->getPost('title'),
            'source_type' => $this->request->getPost('source_type'),
            'network_name' => $this->request->getPost('network_name'),
            'format' => $this->request->getPost('format'),
            'placement' => $this->request->getPost('placement'),
            'status' => $this->request->getPost('status'),
        ];

        // Handle Content updates carefully
        if ($data['source_type'] === 'network') {
            $data['ad_content'] = $this->request->getPost('ad_content');
        } else {
            // Direct
            if ($file = $this->request->getFile('ad_image')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/ads', $newName);
                    $data['ad_content'] = json_encode([
                        'image_url' => 'uploads/ads/' . $newName,
                        'link_url' => $this->request->getPost('link_url'),
                        'cta_text' => $this->request->getPost('cta_text')
                    ]);
                }
            } else {
                // If no new file, update link/cta but keep image? 
                // Or we might need to parse existing ad_content.
                // For MVP simplicty: If they provide link_url/cta_text update those, keep image if exists.
                $existingContent = json_decode($ad['ad_content'] ?? '{}', true);
                if (is_array($existingContent)) {
                    $existingContent['link_url'] = $this->request->getPost('link_url');
                    $existingContent['cta_text'] = $this->request->getPost('cta_text');
                    $data['ad_content'] = json_encode($existingContent);
                }
            }
        }

        $data['targeting'] = json_encode([
            'role' => $this->request->getPost('target_role') ?: [],
            'country' => $this->request->getPost('target_country')
        ]);

        $data['frequency_capping'] = json_encode([
            'max_impressions' => $this->request->getPost('max_impressions'),
            'cooldown' => $this->request->getPost('cooldown')
        ]);

        if (!$model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }

        return redirect()->to(base_url('admin/ads'))->with('message', 'Ad updated successfully.');
    }

    public function delete($id)
    {
        $model = new AdsModel();
        $model->delete($id);
        return redirect()->to(base_url('admin/ads'))->with('message', 'Ad deleted successfully.');
    }

    public function togglePause($id)
    {
        $model = new AdsModel();
        $ad = $model->find($id);

        if (!$ad) {
            return redirect()->to(base_url('admin/ads'))->with('error', 'Ad not found.');
        }

        $newStatus = ($ad['status'] === 'active') ? 'paused' : 'active';
        $model->update($id, ['status' => $newStatus]);

        return redirect()->to(base_url('admin/ads'))->with('message', "Ad {$newStatus} successfully.");
    }
}
