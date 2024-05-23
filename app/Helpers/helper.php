<?php

use App\Models\SystemSetting;

function get_setting($key,$default = null)
{
    global $option_name;
    $option_name = $key;
    $value = SystemSetting::where('key', $option_name)->first();

    return !empty($value) ? $value->value : $default;
}

function get_logo($default = null) {
    $logo_path = SystemSetting::where('key', 'site_logo')->value('value');
    if (empty($logo_path)) {
        return $default;
    }

    return url('public/uploads/logo/' . $logo_path);
}
