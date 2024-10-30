<?php

namespace App\Services\Settings;

use App\Models\Setting;

class SettingsServices
{
    private static ?SettingsServices $instance = null;
    private string $key;
    private mixed $value;

    public function __construct(string $key)
    {
        $this->key = $key;
        $this->loadValue();
    }

    public static function instance(string | array $key): SettingsServices
    {
        if (!self::$instance || self::$instance->key !== $key) {

            self::$instance = new self($key);

        }

        return self::$instance;
    }

    public function save(array|string $data): void
    {
        $value = is_array($data) ? json_encode($data) : $data;

        Setting::updateOrCreate(['key' => $this->key], ['value' => $value]);

        $this->value = is_array($data) ? $data : json_decode($value, true);
    }

    private function loadValue(): void
    {
        $setting = Setting::where('key', $this->key)->first();

        $this->value = $setting ? json_decode($setting->value, true) : null;
    }

    public function get(): string | array
	{
	    $locale = app()->getLocale();

	    return array_map(function ($item) use ($locale) {

	        $localizedItem = [];

	        foreach ($item as $key => $value) {

	            $localizedItem[$key] = is_array($value) ? ($value[$locale] ?? $value[$locale] ?? reset($value)) : $value;

	        }

	        return (object) $localizedItem;

	    }, $this->value);
	}

    public function __get($property)
    {
        return $this->value[$property] ?? $this->value ?? null;
    }
}