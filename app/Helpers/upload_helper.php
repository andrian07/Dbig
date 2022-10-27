<?php
if (!function_exists('upload_image')) {
    function upload_image($_inputFileName = '', $_renameTo = '', $_configImageName = '')
    {
        $_config    = new \Config\MyApp();
        $_request   = \Config\Services::request();

        $file       = $_request->getFile($_inputFileName);
        $ext        = $file->getClientExtension();

        $filename = $_renameTo . '.' . $ext;
        $temp_name = 'temp_' . $filename;

        //init config//
        $default_config = $_config->uploadImage['default'];
        $custom_config = [];
        if (!($_configImageName == '')) {
            $custom_config = isset($_config->uploadImage[$_configImageName]) ? $_config->uploadImage[$_configImageName] : [];
        }
        $config = array_merge($default_config, $custom_config);

        if ($file->isValid() && !$file->hasMoved()) {
            // upload file as temp //
            $file->move($config['upload_dir'], $temp_name);

            // init image library //
            $image = \Config\Services::image($config['module']);

            // resize image //
            $saveTo = $config['upload_dir'] . $filename;
            $image->withFile($config['upload_dir'] . $temp_name)
                ->resize($config['width'], $config['height'], $config['maintainRatio'], $config['masterDim'])
                ->save($saveTo);

            /* Create Thumbnail */
            if ($config['create_thumb'] == TRUE) {
                $saveTo = $config['thumb_dir'] . $filename;
                $image->withFile($config['upload_dir'] . $temp_name)
                    ->resize($config['thumb_width'], $config['thumb_height'], $config['maintainRatio'], $config['masterDim'])
                    ->save($saveTo);
            }

            unlink($config['upload_dir'] . $temp_name);
            return $filename;
        } else {
            return '';
        }
    }
}
