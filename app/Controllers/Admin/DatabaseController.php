<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\EnvManager;
use Config\Database;

class DatabaseController extends BaseController
{
    protected EnvManager $envManager;

    public function __construct()
    {
        $this->envManager = new EnvManager();
    }

    public function index()
    {
        $currentGroup = env('DB_GROUP', 'default');

        $data = [
            'title' => 'Database Management',
            'currentGroup' => $currentGroup,
        ];

        return view('admin/database/index', $data);
    }

    public function switch()
    {
        $targetGroup = $this->request->getPost('db_group');
        $currentGroup = env('DB_GROUP', 'default');

        if (!in_array($targetGroup, ['default', 'sqlite'])) {
            return redirect()->back()->with('error', 'Invalid database group');
        }

        if ($targetGroup === $currentGroup) {
            return redirect()->back()->with('info', 'Database group is already set to ' . $targetGroup);
        }

        // 1. Ensure target database is migrated to latest schema before sync
        try {
            $migrate = \Config\Services::migrations(null, \Config\Database::connect($targetGroup));
            $migrate->latest();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Target database migration failed: ' . $e->getMessage());
        }

        // 2. Perform Data Sync before switching
        try {
            $this->syncData($currentGroup, $targetGroup);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Synchronization failed: ' . $e->getMessage() . '. Tables must exist in both databases for sync.');
        }

        if ($this->envManager->set('DB_GROUP', $targetGroup)) {
            return redirect()->to(base_url('admin/database'))->with('success', "Switched to {$targetGroup} and synchronized data successfully.");
        }

        return redirect()->back()->with('error', 'Failed to update .env file');
    }

    /**
     * Synchronizes data from source group to target group
     */
    private function syncData(string $sourceGroup, string $targetGroup)
    {
        $sourceDb = \Config\Database::connect($sourceGroup);
        $targetDb = \Config\Database::connect($targetGroup);

        // 1. Get all tables from source
        $tables = $sourceDb->listTables();

        // 2. Disable foreign key checks on target
        if ($targetDb->DBDriver === 'SQLite3') {
            $targetDb->query('PRAGMA foreign_keys = OFF');
        } else {
            $targetDb->query('SET FOREIGN_KEY_CHECKS = 0');
        }

        foreach ($tables as $table) {
            if ($table === 'migrations')
                continue;

            // Check if table exists in target
            if (!$targetDb->tableExists($table)) {
                continue;
            }

            // 3. Clear target table
            $targetDb->table($table)->truncate();

            // 4. Fetch data from source
            $data = $sourceDb->table($table)->get()->getResultArray();

            if (!empty($data)) {
                // 5. Insert into target in chunks
                $chunks = array_chunk($data, 100);
                foreach ($chunks as $chunk) {
                    $targetDb->table($table)->insertBatch($chunk);
                }
            }
        }

        // 6. Re-enable foreign key checks
        if ($targetDb->DBDriver === 'SQLite3') {
            $targetDb->query('PRAGMA foreign_keys = ON');
        } else {
            $targetDb->query('SET FOREIGN_KEY_CHECKS = 1');
        }
    }

    public function migrate()
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
            return redirect()->back()->with('success', 'Migrations completed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Migration failed: ' . $e->getMessage());
        }
    }
}
