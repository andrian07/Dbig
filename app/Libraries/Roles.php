<?php

namespace App\Libraries;

class Roles
{
    protected $defaultAccess = 0;
    protected $userRoles = [];

    public function __construct($rolesConfig, $userGroup)
    {
        $default_access = $userGroup == 'L00' ? 1 : 0;
        $userRoles = [];
        foreach ($rolesConfig as $module_name => $module_val) {
            if (isset($module_val['roles'])) {
                foreach ($module_val['roles'] as $role_name => $role_val) {
                    $access = isset($role_val['default']) ? intval($role_val['default']) : $default_access;
                    $userRoles[$module_name][$role_name] = $access;
                }
            }
        }
        $this->userRoles = $userRoles;
        $this->defaultAccess = $default_access;
    }

    public function get($module_name = '', $role_name = '')
    {
        if ($module_name == '') {
            return $this->userRoles;
        } else {
            if ($role_name == '') {
                if (isset($this->userRoles[$module_name])) {
                    return $this->userRoles[$module_name];
                } else {
                    return [];
                }
            } else {
                if (isset($this->userRoles[$module_name][$role_name])) {
                    return $this->userRoles[$module_name][$role_name];
                } else {
                    return $this->defaultAccess;
                }
            }
        }
    }

    public function set($module_name, $role_name, $value)
    {
        $this->userRoles[$module_name][$role_name] = $value;
    }

    public function hasRole($module)
    {
        $hasRole = TRUE;
        $eMod = explode('|', $module);
        foreach ($eMod as $mod) {
            $role = explode('.', $mod);
            if ($this->get($role[0], $role[1]) == 0) {
                $hasRole = FALSE;
            }
        }
        return $hasRole;
    }
}
