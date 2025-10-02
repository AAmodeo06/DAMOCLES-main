<?php

if (!function_exists('git_version')) {
    function git_version()
    {
        $path = storage_path('git_version');

        if (file_exists($path)) {
            $version = trim(file_get_contents($path));
            return !empty($version) ? $version : 'undefined';
        }

        return 'undefined';
    }
}
