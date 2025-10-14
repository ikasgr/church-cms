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

use App\Models\SettingModel;

if (!function_exists('app_setting')) {
    function app_setting(string $key, $default = null)
    {
        static $cache = [];

        if (!array_key_exists($key, $cache)) {
            $model = model(SettingModel::class);
            $value = $model->getSetting($key, $default);
            $cache[$key] = $value ?? $default;
        }

        return $cache[$key];
    }
}

if (!function_exists('app_setting_asset')) {
    function app_setting_asset(string $key, ?string $fallback = null): ?string
    {
        $value = app_setting($key);

        if (!$value) {
            return $fallback ? base_url($fallback) : null;
        }

        $path = 'uploads/settings/' . ltrim($value, '/');

        return base_url($path);
    }
}
