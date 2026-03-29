<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailQueueModel;
use App\Libraries\AIService;

class CampaignController extends BaseController
{
    protected $emailQueueModel;
    protected $aiService;

    public function __construct()
    {
        $this->emailQueueModel = new EmailQueueModel();
        $this->aiService = new AIService();
    }

    public function index()
    {
        $data = [
            'title' => 'Email Campaigns',
            'campaigns' => $this->emailQueueModel->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('admin/campaigns/index', $data);
    }

    public function new()
    {
        // Redirect to Step 1
        return redirect()->to('admin/campaigns/step1');
    }

    // STEP 1: Configuration
    public function step1()
    {
        $data = [
            'title' => 'New Campaign - Step 1: Configuration',
            'saved_data' => session()->get('campaign_wizard_data') ?? []
        ];
        return view('admin/campaigns/step1', $data);
    }

    public function processStep1()
    {
        $rules = [
            'type' => 'required',
            'goal' => 'required',
            'tone' => 'required',
            // Segment is now optional/derived from Step 2, but we keep the field for AI context if manually entered
            'segment' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $currentData = session()->get('campaign_wizard_data') ?? [];
        $newData = array_merge($currentData, $this->request->getPost());

        session()->set('campaign_wizard_data', $newData);

        return redirect()->to('admin/campaigns/step2');
    }

    // STEP 2: Audience Selection
    public function step2()
    {
        $userModel = new \App\Models\UserModel();
        $subscriberModel = new \App\Models\SubscriberModel();

        // Fetch users grouped by role (assuming role_id 1=Admin, 2=Student, etc. - adjust logic as needed or just show all)
        // For now, let's just get all users and subscribers for the UI selection
        $users = $userModel->findAll();
        $subscribers = $subscriberModel->findAll();

        $data = [
            'title' => 'New Campaign - Step 2: Audience',
            'users' => $users,
            'subscribers' => $subscribers,
            'saved_data' => session()->get('campaign_wizard_data') ?? []
        ];
        return view('admin/campaigns/step2', $data);
    }

    public function processStep2()
    {
        $recipients = $this->request->getPost('recipients');

        if (empty($recipients)) {
            return redirect()->back()->with('error', 'Please select at least one recipient.');
        }

        $currentData = session()->get('campaign_wizard_data') ?? [];
        $currentData['recipients'] = $recipients;

        // Update segment description for AI context based on selection count
        $count = count($recipients);
        $currentData['segment'] = "Selected list of $count specific users/subscribers.";

        session()->set('campaign_wizard_data', $currentData);

        return redirect()->to('admin/campaigns/step3');
    }

    // STEP 3: Preview & Generation
    public function step3()
    {
        $wizardData = session()->get('campaign_wizard_data');
        if (!$wizardData) {
            return redirect()->to('admin/campaigns/step1');
        }

        // Generate AI Content if not already generated in this session (or force regenerate)
        // For this flow, we'll generate it now to show the preview
        // Ideally we cache this generation to avoid re-calling AI on refresh, unless user asks to regenerate

        $generatedContent = session()->get('campaign_generated_content');

        if (!$generatedContent || $this->request->getGet('regenerate')) {
            $generatedContent = $this->aiService->generateEmailCampaign($wizardData);

            if (isset($generatedContent['error'])) {
                return redirect()->to('admin/campaigns/step1')->with('error', 'AI Generation Failed: ' . $generatedContent['error']);
            }

            // Wrap in template for preview
            $subject = $generatedContent['email_subject'] ?? 'No Subject';
            $bodyContent = $generatedContent['email_body_html'] ?? '';
            $fullHtml = view('emails/campaign', [
                'body_content' => $bodyContent,
                'subject' => $subject
            ]);

            $generatedContent['full_html_preview'] = $fullHtml;
            session()->set('campaign_generated_content', $generatedContent);
        }

        $data = [
            'title' => 'New Campaign - Step 3: Preview',
            'wizard_data' => $wizardData,
            'preview_data' => $generatedContent
        ];
        return view('admin/campaigns/step3', $data);
    }

    public function confirm()
    {
        $wizardData = session()->get('campaign_wizard_data');
        $generatedContent = session()->get('campaign_generated_content');

        if (!$wizardData || !$generatedContent) {
            return redirect()->to('admin/campaigns/step1');
        }

        // Save to DB
        // We create ONE entry for each recipient strictly speaking, OR one entry in queue 
        // usually bulk mailers create one job. But the user request said "prepare email queue entries". 
        // "must ONLY prepare email queue entries".

        // Since we have individual recipients selected, we should probably create one queue item per recipient.
        // However, if the list is huge, this is slow. But for "select recipients" UI, it implies a manageable list.

        $recipients = $wizardData['recipients']; // Array of emails
        $count = 0;

        foreach ($recipients as $email) {
            $queueData = [
                'recipient' => $email,
                'email_subject' => $generatedContent['email_subject'],
                'email_body_html' => $generatedContent['full_html_preview'], // The templated HTML
                'email_body_text' => $generatedContent['email_body_text'],
                'target_audience_rules' => json_encode(['manual_selection' => true]),
                'priority' => $generatedContent['priority'] ?? 'medium',
                'scheduled_at' => date('Y-m-d H:i:s'), // For now assume send immediately/queued
                'campaign_tag' => $generatedContent['campaign_tag'] ?? 'general',
                'status' => 'pending',
            ];
            $this->emailQueueModel->insert($queueData);
            $count++;
        }

        // Clear session
        session()->remove('campaign_wizard_data');
        session()->remove('campaign_generated_content');

        return redirect()->to('admin/campaigns')->with('message', "Campaign created successfully. $count emails queued.");
    }

    /**
     * Process the email queue.
     * Can be run via Web (e.g., cron job via curl) or CLI.
     * Cron job: * / 5 * * * * (Every 5 minutes)
     * curl -s "https://unihunt.org/admin/campaigns/process-queue?key=UNI_CRON_2024"
     * cd /path/to/your/project && php spark queue:process 50
     */
    public function processQueue()
    {
        // Simple security: Check for a secret key if not running in CLI
        if (php_sapi_name() !== 'cli') {
            $key = $this->request->getGet('key');
            $expectedKey = env('CRON_SECRET') ?: 'UNI_CRON_2024'; // Default fallback

            if ($key !== $expectedKey) {
                return $this->response->setStatusCode(403)->setJSON(['error' => 'Forbidden']);
            }
        }

        $limit = $this->request->getGet('limit') ?: 50;

        // Fetch pending emails that are scheduled for now or earlier
        $queue = $this->emailQueueModel->where('status', 'pending')
            ->groupStart()
            ->where('scheduled_at <=', date('Y-m-d H:i:s'))
            ->orWhere('scheduled_at', null)
            ->groupEnd()
            ->orderBy('priority', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->findAll((int) $limit);

        if (empty($queue)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'No pending emails found.']);
        }

        $email = \Config\Services::email();
        $sent = 0;
        $failed = 0;

        foreach ($queue as $item) {
            $email->clear();
            $email->setTo($item['recipient']);

            $config = config('Email');
            $fromEmail = $config->fromEmail ?: 'unihunt.overseas@gmail.com';
            $fromName = $config->fromName ?: 'UniSearch';

            $email->setFrom($fromEmail, $fromName);
            $email->setSubject($item['email_subject']);
            $email->setMessage($item['email_body_html'] ?: $item['email_body_text']);

            if (!empty($item['email_body_text']) && !empty($item['email_body_html'])) {
                $email->setAltMessage($item['email_body_text']);
            }

            if ($email->send()) {
                $this->emailQueueModel->update($item['id'], ['status' => 'sent']);
                $sent++;
            } else {
                $this->emailQueueModel->update($item['id'], ['status' => 'failed']);
                $failed++;
                // Log the error if needed
                log_message('error', 'Email failed to send to ' . $item['recipient'] . ': ' . $email->printDebugger(['headers']));
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Processed ' . ($sent + $failed) . ' emails.',
            'sent' => $sent,
            'failed' => $failed
        ]);
    }
}
