<?php

namespace App\Controllers;

use App\Models\BookmarkModel;
use CodeIgniter\API\ResponseTrait;

class BookmarkController extends BaseController
{
    use ResponseTrait;

    public function toggle()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->failUnauthorized('You must be logged in to bookmark.');
        }

        $userId = session()->get('user_id');
        $entityType = $this->request->getPost('entity_type');
        $entityId = $this->request->getPost('entity_id');

        if (!$entityType || !$entityId) {
            return $this->fail('Invalid request parameters.');
        }

        if (!in_array($entityType, ['university', 'course', 'blog'])) {
            return $this->fail('Invalid entity type.');
        }

        $bookmarkModel = new BookmarkModel();

        // Check if exists
        $existing = $bookmarkModel->where('user_id', $userId)
            ->where('entity_type', $entityType)
            ->where('entity_id', $entityId)
            ->first();

        if ($existing) {
            // Remove
            $bookmarkModel->delete($existing['id']);
            return $this->respond([
                'status' => 'removed',
                'message' => 'Bookmark removed.',
                'icon' => 'bookmark_border'
            ]);
        } else {
            // Add
            $bookmarkModel->insert([
                'user_id' => $userId,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return $this->respond([
                'status' => 'added',
                'message' => 'Bookmark added.',
                'icon' => 'bookmark'
            ]);
        }
    }
}
