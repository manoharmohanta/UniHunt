<?php

if (! function_exists('honeypot_field')) {
    /**
     * Generates a Honeypot field for forms.
     * Uses the Honeypot configuration.
     *
     * @return string
     */
    function honeypot_field()
    {
        $config = config('Honeypot');
        
        if (! $config->hidden) {
            return '';
        }

        $template = $config->template;
        $template = str_replace('{label}', $config->label, $template);
        $template = str_replace('{name}', $config->name, $template);
        
        return str_replace('{template}', $template, $config->container);
    }
}
