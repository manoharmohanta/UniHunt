<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class Setup extends Controller
{
    private $lockFile = WRITEPATH . 'install.lock';



    public function index()
    {
        return view('setup/index');
    }

    public function database()
    {
        return view('setup/database');
    }

    public function databaseSave()
    {
        $host = $this->request->getPost('hostname');
        $db = $this->request->getPost('database');
        $user = $this->request->getPost('username');
        $pass = $this->request->getPost('password');

        // Test connection
        try {
            $mysqli = @new \mysqli($host, $user, $pass, $db);
            if ($mysqli->connect_errno) {
                return redirect()->back()->with('error', 'Database connection failed: ' . $mysqli->connect_error);
            }
            $mysqli->close();

            // Rewrite .env file
            $envFile = ROOTPATH . '.env';
            if (!file_exists($envFile)) {
                // copy from env to .env
                if (file_exists(ROOTPATH . 'env')) {
                    copy(ROOTPATH . 'env', $envFile);
                } else {
                    $content = "CI_ENVIRONMENT = development\n";
                    file_put_contents($envFile, $content);
                }
            }

            $currentEnv = file_get_contents($envFile);

            $config = [
                'database.default.hostname' => $host,
                'database.default.database' => $db,
                'database.default.username' => $user,
                'database.default.password' => $pass,
                'database.default.DBDriver' => 'MySQLi',
                'database.default.DBPrefix' => '',
                'database.default.port' => 3306,
                'DB_GROUP' => 'default'
            ];

            foreach ($config as $key => $value) {
                $pattern = '/^#?\s*' . preg_quote($key, '/') . '\s*=(.*)$/m';
                if (preg_match($pattern, $currentEnv)) {
                    $currentEnv = preg_replace($pattern, "$key = $value", $currentEnv);
                } else {
                    $currentEnv .= "\n$key = $value";
                }
            }

            file_put_contents($envFile, $currentEnv);

            return redirect()->to(base_url('setup/admin'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Exception: ' . $e->getMessage());
        }
    }

    public function admin()
    {
        return view('setup/admin');
    }

    public function adminSave()
    {
        $name = $this->request->getPost('admin_name');
        $email = $this->request->getPost('admin_email');
        // Let's assume password isn't directly needed in the users table from the migration,
        // Wait, the CreateUsersTable migration doesn't have a 'password' column!
        // We'll just create the user. Or check if there handles a different table for auth?
        // Let's create the user in `users`.

        try {
            // First run migrations
            $migrations = Services::migrations();
            $migrations->setGroup('default');
            $migrations->latest();

            // Run seeders
            $seeder = \Config\Database::seeder();
            $seeder->call('MainSeeder'); // Call the correct MainSeeder

            // Create admin user
            $db = \Config\Database::connect('default');

            // Find admin role
            $roleId = 1;
            $roleQuery = $db->table('roles')->where('name', 'Admin')->get()->getRow();
            if ($roleQuery) {
                $roleId = $roleQuery->id;
            } else {
                // insert admin role
                $db->table('roles')->insert(['name' => 'Admin']);
                $roleId = $db->insertID();
            }

            $userData = [
                'name' => $name,
                'email' => $email,
                'role_id' => $roleId,
                'status' => 'active',
                'registered_from' => 'web',
                'is_verified' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Check if user already exists
            $existing = $db->table('users')->where('email', $email)->get()->getRow();
            if (!$existing) {
                $db->table('users')->insert($userData);
            } else {
                $db->table('users')->where('id', $existing->id)->update($userData);
            }

            // Create lock file
            file_put_contents($this->lockFile, 'installed at ' . date('Y-m-d H:i:s'));

            return redirect()->to(base_url('setup/success'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error during setup: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('setup/success');
    }
}
