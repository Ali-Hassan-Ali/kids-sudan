<?php 

use App\Models\Setting;

 if(!function_exists('getSetting')) {
    
    function getSetting(string $key, bool $json = false)
    {
        $setting = Setting::where('key', $key)->first();
        if($setting) {
            return $json ? json_decode($setting->value, true) : $setting->value;
        } else {
            $setting = Setting::create(['key' => $key]);
            return;
        }

    }//en dof fun

 }//end of getSetting

 if(!function_exists('saveSetting')) {
    
    function saveSetting(string $key, $value = '')
    {
        $setting = Setting::where('key', $key)->first();
        if(!$setting) {
            return $setting = Setting::create(['key' => $key]);
        }
        return $setting->update(['value' => $value]);

    }//en dof fun

 }//end of getSetting

 if(!function_exists('getImageSetting')) {
    
    function getImageSetting(string $key)
    {
        return asset('storage/' . getSetting($key));

    }//en dof fun

 }//end of getImageSetting

 if(!function_exists('getTransSetting')) {
    
    function getTransSetting(string $key, $lang)
    {
        $setting = Setting::where('key', $key)->first();
        if($setting) {
            if(!empty(json_decode($setting->value, true)[$lang])) {
                return json_decode($setting->value, true)[$lang];
            } else {
                return json_decode($setting->value, true)[app()->getLocale()] ?? '';
            }
        } else {
            $setting = Setting::create(['key' => $key]);
            return '';
        }

    }//en dof fun

 }//end of getTransSetting

 if(!function_exists('saveTransSetting')) {
    
    function saveTransSetting(string $key, $value)
    {
        $setting = Setting::where('key', $key)->first();
        if(!$setting) {
            $setting = Setting::create(['key' => $key]);  
        } 
        $setting->update(['value' => $value]);

    }//en dof fun

 }//end of getTransSetting

 if(!function_exists('getMulteSetting')) {
    
    function getMulteSetting(string $key, string $name, string | int $index, string $lang)
    {
        $setting = Setting::where('key', $key)->first();

        if($setting) {

            if(!empty(json_decode(getSetting($key), true)[$name][$index][$lang])) {

                return json_decode(getSetting($key), true)[$name][$index][$lang];

            } else {

                return false;
            }

        } else {

            $setting = Setting::create(['key' => $key]);

            return '';

        }//end of if

    }//en dof fun

 }//end of getMulteSetting


 if(!function_exists('getItemTagesSetting')) {
    
    function getItemTagesSetting(string $key, string $lang, bool $toArray = true)
    {
        $values = collect(getTransSetting($key, $lang));
        $tages  = collect([]);
        $old    = old($key . '.' . $lang) ?? [];

        if ($toArray) {

            $values?->each(fn ($item, $key) => $tages->put($item, $item));

        } else {

            $values?->each(fn ($item, $key) => $tages->push($item));

        }//end of toArray

        if ($old === []) {

            return $tages?->toArray();
            
        } else {

            $olds = collect([]);

            foreach ($old as $key=>$value) {

                $toArray ? ($olds[$value] = $value) : ($olds[] = $value);

            }//end of each

            return $olds?->toArray();

        }//end of if old

    }//end of fun

 }//end of getItemTagesSetting