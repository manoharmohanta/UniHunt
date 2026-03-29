<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\EmailQueueModel;

class ProcessEmailQueue extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Queue';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'queue:process';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Process pending emails from the email queue.';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'queue:process [limit]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [
        'limit' => 'Number of emails to process (default: 50)',
    ];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $limit = isset($params[0]) ? (int) $params[0] : 50;

        CLI::write("Starting email queue processing... (Limit: $limit)", 'yellow');

        $model = new EmailQueueModel();
        $email = \Config\Services::email();

        // Fetch pending emails that are scheduled for now or earlier
        $queue = $model->where('status', 'pending')
            ->groupStart()
            ->where('scheduled_at <=', date('Y-m-d H:i:s'))
            ->orWhere('scheduled_at', null)
            ->groupEnd()
            ->orderBy('priority', 'ASC') // Low to High? Usually 1 is High. Enum is low,medium,high. enum sorting is string based usually or index?
            // MySQL ENUM 'low','medium','high' index is 1,2,3.
            // Let's rely on created_at for FIFO if priority is same
            ->orderBy('created_at', 'ASC')
            ->findAll($limit);

        if (empty($queue)) {
            CLI::write("No pending emails found.", 'green');
            return;
        }

        CLI::write("Found " . count($queue) . " pending emails.", 'cyan');

        $countObj = 0;

        foreach ($queue as $item) {
            $countObj++;
            CLI::write("[$countObj] Processing ID: {$item['id']} To: {$item['recipient']}", 'white');

            $email->clear();
            $email->setTo($item['recipient']);

            // Assuming config has default 'from' setup, otherwise use a fallback
            $config = config('Email');
            if (!empty($config->fromEmail)) {
                $email->setFrom($config->fromEmail, $config->fromName);
            } else {
                $email->setFrom('unihunt.overseas@gmail.com', 'UniSearch System');
            }

            $email->setSubject($item['email_subject']);
            $email->setMessage($item['email_body_html'] ?: $item['email_body_text']);

            if (!empty($item['email_body_text']) && !empty($item['email_body_html'])) {
                $email->setAltMessage($item['email_body_text']);
            }

            if ($email->send()) {
                $model->update($item['id'], ['status' => 'sent']);
                CLI::write(" -> Sent successfully.", 'green');
            } else {
                $model->update($item['id'], ['status' => 'failed']);
                CLI::write(" -> Failed to send.", 'red');
                CLI::write($email->printDebugger(), 'red');
            }
        }

        CLI::write("Queue processing complete.", 'green');
    }
}
