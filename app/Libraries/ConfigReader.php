<?php

namespace App\Libraries;

class ConfigReader
{
    private $_configs = [];

    public function __construct()
    {
        $this->_configs = [];
    }

    public function set($config_group, $config_subgroup, $config_name, $value)
    {
        $this->_configs[$config_group][$config_subgroup][$config_name] = $value;
    }

    public function get($config_group = '', $config_subgroup = '', $config_name = '', $default_value = null)
    {
        if ($config_group == '') {
            return $this->_configs;
        } else {
            if ($config_subgroup == '') {
                return isset($this->_configs[$config_group]) ? $this->_configs[$config_group] : $default_value;
            } else {
                if ($config_name == '') {
                    return isset($this->_configs[$config_group][$config_subgroup]) ? $this->_configs[$config_group][$config_subgroup] : $default_value;
                } else {
                    if (isset($this->_configs[$config_group][$config_subgroup][$config_name])) {
                        return $this->_configs[$config_group][$config_subgroup][$config_name];
                    } else {
                        return $default_value;
                    }
                }
            }
        }
    }
}
