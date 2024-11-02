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

        if (!$setting) {

            Setting::updateOrCreate(['key' => $this->key]);

            $setting = Setting::where('key', $this->key)->first();
        }

        $this->value = isset($setting?->value) ? (json_validate($setting?->value) ? json_decode($setting->value, true) : $setting?->value) : null;
    }

    public function get(): string | array
	{
	    $locale = app()->getLocale();

        if (!is_array($this->value)) return $this->value;

        return array_map(fn($item) => (object) collect($item)->mapWithKeys(
            fn($value, $key) => [$key => is_array($value) ? ($value[$locale] ?? reset($value)) : $value]
        )->all(), $this->value);
	}

    public function __get($property)
    {
        $locale = app()->getLocale();

        return $this->value[$property][$locale] ?? $this->value[$property] ?? $this->value ?? null;
    }

    public function toArray()
    { 
        return $this->value;
    }
}