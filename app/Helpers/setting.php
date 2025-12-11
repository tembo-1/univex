<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return Setting::query()
            ->where('key', $key)->value('value') ?? $default;
    }
}
