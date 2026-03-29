<?php

if (!function_exists('get_setting')) {
    /**
     * Fetch a site configuration value by key.
     * Results are cached for the duration of the request.
     */
    function get_setting($key, $default = null)
    {
        static $settings = null;

        if ($settings === null) {
            $db = \Config\Database::connect();
            $configs = $db->table('site_config')->get()->getResultArray();
            $settings = [];
            foreach ($configs as $c) {
                $val = $c['config_value'];
                $decoded = json_decode($val, true);
                $settings[$c['config_key']] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
            }
        }

        return $settings[$key] ?? $default;
    }
}
