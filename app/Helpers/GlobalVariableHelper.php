<?php

if (!function_exists('getApplicationRoles')) {

    /**
     * Get list of application roles
     *
     * @param
     * @return
     */
    function getApplicationRoles()
    {
        return([
            1 => 'super-admin'
        ]);
    }
}

if (!function_exists('getApplicationPermission')) {

    /**
     * Get single application permission
     *
     * @param
     * @return
     */
    function getApplicationPermission($role)
    {
        return $role . '-permission';
    }
}
