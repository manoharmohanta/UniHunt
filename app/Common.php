<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('isAdmin')) {
    function isAdmin() {
        if (!session()->get('isLoggedIn')) return false;
        
        // Optimize: Cache role check in session upon login
        // For now, assuming if role_id is in session or fetch user
        $roleId = session()->get('role_id');
        if(!$roleId) {
            // Lazy load if not in session (though login usually sets it)
            return false;
        }
        
        return (int)$roleId === 1;
    }
}
