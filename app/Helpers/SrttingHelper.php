<?php 

 if(!function_exists('getSetting')) {
    
    function getSetting($key)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        if($setting) {
            return $setting->value;
        } else {
            $setting = \App\Models\Setting::create(['key' => $key]);
            return '';
        }

    }//en dof fun

 }//end of getSetting

 if(!function_exists('saveSetting')) {
    
    function saveSetting($key, $value = '')
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        if(!$setting) {
            return $setting = \App\Models\Setting::create(['key' => $key]);
        }
        return $setting->update(['value' => $value]);

    }//en dof fun

 }//end of getSetting

 if(!function_exists('getImageSetting')) {
    
    function getImageSetting($key)
    {
        return asset('storage/' . getSetting($key));

    }//en dof fun

 }//end of getImageSetting

 if(!function_exists('getTransSetting')) {
    
    function getTransSetting($key, $lang)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        if($setting) {
            if(!empty(json_decode($setting->value, true)[$lang])) {
                return json_decode($setting->value, true)[$lang];
            } else {
                return json_decode($setting->value, true)[app()->getLocale()] ?? '';
            }
        } else {
            $setting = \App\Models\Setting::create(['key' => $key]);
            return '';
        }

    }//en dof fun

 }//end of getTransSetting

 if(!function_exists('saveTransSetting')) {
    
    function saveTransSetting($key, $value)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();
        if(!$setting) {
            $setting = \App\Models\Setting::create(['key' => $key]);  
        } 
        $setting->update(['value' => $value]);

    }//en dof fun

 }//end of getTransSetting

 if(!function_exists('getMulteSetting')) {
    
    function getMulteSetting($key, $name, $index, $lang)
    {
        $setting = \App\Models\Setting::where('key', $key)->first();

        if($setting) {

            if(!empty(json_decode(getSetting($key), true)[$name][$index][$lang])) {

                return json_decode(getSetting($key), true)[$name][$index][$lang];

            } else {

                return false;
            }

        } else {

            $setting = \App\Models\Setting::create(['key' => $key]);

            return '';

        }//end of if

    }//en dof fun

 }//end of getMulteSetting


 if(!function_exists('getItemTagesSetting')) {
    
    function getItemTagesSetting($key, $lang)
    {
        $values = collect(json_decode(getTransSetting($key, $lang), true));
        $tages  = collect();

        $values->each(fn ($item, $key) => $tages->push($item['value'], $item['value']));

        return $tages;

    }//en dof fun

 }//end of getItemTagesSetting