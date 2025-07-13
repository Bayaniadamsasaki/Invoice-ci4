<?php

if (!function_exists('hasRole')) {
    /**
     * Check if user has specific role
     */
    function hasRole($role)
    {
        return session()->get('role') === $role;
    }
}

if (!function_exists('hasAnyRole')) {
    /**
     * Check if user has any of the specified roles
     */
    function hasAnyRole($roles)
    {
        $userRole = session()->get('role');
        return in_array($userRole, $roles);
    }
}

if (!function_exists('isAdmin')) {
    /**
     * Check if user is admin
     */
    function isAdmin()
    {
        return session()->get('role') === 'admin';
    }
}

if (!function_exists('isBagianKeuangan')) {
    /**
     * Check if user is bagian keuangan
     */
    function isBagianKeuangan()
    {
        return session()->get('role') === 'bagian_keuangan';
    }
}

if (!function_exists('isManager')) {
    /**
     * Check if user is manager
     */
    function isManager()
    {
        return session()->get('role') === 'manager';
    }
}

if (!function_exists('getUserRole')) {
    /**
     * Get current user role
     */
    function getUserRole()
    {
        return session()->get('role');
    }
}

if (!function_exists('checkRoleAccess')) {
    /**
     * Check role access and redirect if unauthorized
     */
    function checkRoleAccess($allowedRoles, $redirectTo = '/dashboard')
    {
        $userRole = session()->get('role');
        if (!in_array($userRole, $allowedRoles)) {
            session()->setFlashdata('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.'
            ]);
            return redirect()->to($redirectTo);
        }
        return null;
    }
}
