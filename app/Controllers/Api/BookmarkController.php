<?php

namespace App\Controllers\Api;

use App\Models\BookmarkModel;

class BookmarkController extends ApiController
{
    /**
     * POST /api/bookmarks/toggle
     */
    public function toggle()
    {
        $userId = $this->request->user_id;
        $entityType = $this->request->getVar('entity_type');
        $entityId = $this->request->getVar('entity_id');

        if (!$entityType || !$entityId) {
            return $this->error('Invalid request parameters.');
        }

        if (!in_array($entityType, ['university', 'course'])) {
            return $this->error('Invalid entity type.');
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
            return $this->success(['status' => 'removed'], 'Bookmark removed.');
        } else {
            // Add
            $bookmarkModel->insert([
                'user_id' => $userId,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return $this->success(['status' => 'added'], 'Bookmark added.');
        }
    }

    /**
     * GET /api/bookmarks
     */
    public function index()
    {
        $userId = $this->request->user_id;
        $bookmarkModel = new BookmarkModel();

        $bookmarks = $bookmarkModel->where('user_id', $userId)->findAll();

        // We might want to join with universities/courses to get details, 
        // but for now let's just return the raw list.
        return $this->success($bookmarks);
    }
}
