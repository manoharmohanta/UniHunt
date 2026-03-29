<?php

namespace App\Controllers\Api;

use App\Models\UserModel;

class UserController extends ApiController
{
    /**
     * GET /api/user/profile
     */
    public function profile()
    {
        $userId = $this->request->user_id;
        $model = new UserModel();

        // Joined user and academic profile
        $user = $model->select('users.*, user_academic_profiles.academic_data, user_academic_profiles.course_choice, user_academic_profiles.target_country, user_academic_profiles.ielts_score, user_academic_profiles.gre_score, user_academic_profiles.backlogs, user_academic_profiles.is_15_years_education, user_academic_profiles.stem_interest')
            ->join('user_academic_profiles', 'user_academic_profiles.user_id = users.id', 'left')
            ->find($userId);

        if (!$user) {
            return $this->error('User not found.', 404);
        }

        // Decode academic_data if it exists
        if (isset($user['academic_data']) && is_string($user['academic_data'])) {
            $user['academic_data'] = json_decode($user['academic_data'], true) ?: [];
        }

        return $this->success($user);
    }

    /**
     * POST /api/user/update-profile
     */
    public function updateProfile()
    {
        $userId = $this->request->user_id;
        $db = \Config\Database::connect();
        $db->transStart();

        // 1. Update Basic Info in Users Table
        $userModel = new UserModel();
        $userData = [];
        if ($this->request->getVar('name'))
            $userData['name'] = $this->request->getVar('name');
        if ($this->request->getVar('phone'))
            $userData['phone'] = $this->request->getVar('phone');
        if ($this->request->getVar('marketing_consent') !== null) {
            $userData['marketing_consent'] = $this->request->getVar('marketing_consent') ? 1 : 0;
        }

        if (!empty($userData)) {
            $userModel->update($userId, $userData);
        }

        // 2. Update Academic Profile
        $academicModel = new \App\Models\UserAcademicProfileModel();

        $academicDataField = $this->request->getVar('academic_data');
        if (is_array($academicDataField) || is_object($academicDataField)) {
            $academicDataField = json_encode($academicDataField);
        }

        $academicData = [
            'course_choice' => $this->request->getVar('course_choice'),
            'target_level' => $this->request->getVar('target_level'),
            'target_country' => $this->request->getVar('target_country'),
            'ielts_score' => $this->request->getVar('ielts_score'),
            'gre_score' => $this->request->getVar('gre_score'),
            'backlogs' => $this->request->getVar('backlogs'),
            'academic_data' => $academicDataField
        ];

        if ($this->request->getVar('is_15_years_education') !== null) {
            $academicData['is_15_years_education'] = $this->request->getVar('is_15_years_education') ? 1 : 0;
        }
        if ($this->request->getVar('stem_interest') !== null) {
            $academicData['stem_interest'] = $this->request->getVar('stem_interest') ? 1 : 0;
        }

        // Filter out nulls to avoid overwriting with empty if not provided
        $academicData = array_filter($academicData, fn($v) => $v !== null);

        $existingProfile = $academicModel->where('user_id', $userId)->first();
        if ($existingProfile) {
            $academicModel->update($existingProfile['id'], $academicData);
        } else {
            $academicData['user_id'] = $userId;
            $academicModel->insert($academicData);
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return $this->error('Failed to update profile.');
        }

        return $this->success(null, 'Profile updated successfully.');
    }

    /**
     * POST /api/user/onboarding
     */
    public function onboarding()
    {
        $userId = $this->request->user_id;
        $name = $this->request->getVar('name');
        $phone = $this->request->getVar('phone');
        $consent = $this->request->getVar('marketing_consent');

        if (empty($name) || empty($phone)) {
            return $this->error('Name and Phone are required.');
        }

        $model = new UserModel();
        // Just storing consent in the DB if the column exists or ignoring if not.
        // Assuming we update the existing fields. Let's make sure it handles the DB properly.
        $updateData = [
            'name' => $name,
            'phone' => $phone
        ];

        // Let's check if the column exists dynamically
        $db = \Config\Database::connect();
        if ($db->fieldExists('marketing_consent', 'users')) {
            $updateData['marketing_consent'] = $consent ? 1 : 0;
        }

        $model->update($userId, $updateData);

        return $this->success(null, 'Profile updated successfully.');
    }

    /**
     * DELETE /api/user/delete
     */
    public function deleteAccount()
    {
        $userId = $this->request->user_id;

        $model = new UserModel();
        $user = $model->find($userId);

        if (!$user) {
            return $this->error('User not found.', 404);
        }

        // Soft delete or hard delete based on your preference. Using hard delete for now.
        $model->delete($userId);

        return $this->success(null, 'Account deleted successfully.');
    }
}
