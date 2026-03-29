<?php

namespace App\Libraries;

class EnvManager
{
    protected string $envPath;

    public function __construct()
    {
        $this->envPath = ROOTPATH . '.env';
    }

    public function get(string $key, $default = null)
    {
        $content = file_get_contents($this->envPath);
        if (preg_match("/^{$key}\s*=\s*(.*)$/m", $content, $matches)) {
            return trim($matches[1], '"\' ');
        }
        return $default;
    }

    public function set(string $key, string $value): bool
    {
        if (!file_exists($this->envPath)) {
            return false;
        }

        $content = file_get_contents($this->envPath);
        $newContent = "";

        if (preg_match("/^{$key}\s*=(.*)$/m", $content)) {
            $newContent = preg_replace("/^{$key}\s*=(.*)$/m", "{$key} = {$value}", $content);
        } else {
            $newContent = $content . "\n{$key} = {$value}";
        }

        return file_put_contents($this->envPath, $newContent) !== false;
    }
}
