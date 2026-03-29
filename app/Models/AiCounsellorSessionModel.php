<?php

namespace App\Models;

use CodeIgniter\Model;

class AiCounsellorSessionModel extends Model
{
    protected $table = 'ai_counsellor_sessions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'student_profile',
        'recommendations',
        'conversation_history',
        'payment_status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'coupon_code',
        'final_amount',
        'session_status',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get sessions for a specific user
     */
    public function getUserSessions($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get active session for user
     */
    public function getActiveSession($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('session_status', 'active')
                    ->where('payment_status', 'paid')
                    ->orderBy('created_at', 'DESC')
                    ->first();
    }

    /**
     * Add message to conversation history
     */
    public function addMessage($sessionId, $role, $message)
    {
        $session = $this->find($sessionId);
        if (!$session) return false;

        $history = json_decode($session['conversation_history'] ?? '[]', true);
        $history[] = [
            'role' => $role,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];

        return $this->update($sessionId, [
            'conversation_history' => json_encode($history)
        ]);
    }

    /**
     * Save recommendations
     */
    public function saveRecommendations($sessionId, $recommendations)
    {
        return $this->update($sessionId, [
            'recommendations' => json_encode($recommendations),
            'session_status' => 'completed'
        ]);
    }
}
