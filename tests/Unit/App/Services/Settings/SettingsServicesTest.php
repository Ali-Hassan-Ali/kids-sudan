<?php

namespace Tests\Unit\App\Services\Settings;

use App\Services\Settings\SettingsServices;
use Tests\TestCase;
use App\Models\Admin;

class SettingsServicesTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $admin = Admin::find(1);
        $this->actingAs($admin, 'admin');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_save_and_retrieve_string_setting()
    {
        $items = 'logo_name.png';
        response(setting('logo')->save($items), 200);
        $this->assertEquals($items, setting('logo')->value);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_save_and_retrieve_single_setting()
    {
        $items = [
            'name' => 'name value new',
            'email' => 'email value',
        ];

        response(setting('item_single')->save($items), 200);

        $this->assertEquals('name value new', setting('item_single')->name);
        $this->assertEquals('email value', setting('item_single')->email);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_save_and_retrieve_single_language_setting()
    {
        $items = [
            'name' => ['ar' => 'name ar', 'en' => 'name en'],
            'email' => ['ar' => 'email ar', 'en' => 'email en'],
        ];

        response(setting('single_language')->save($items), 200);

        $this->assertEquals('name ' . app()->getLocale(), setting('single_language')->name);
        $this->assertEquals('email ' . app()->getLocale(), setting('single_language')->email);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_save_and_retrieve_single_multiple_setting()
    {
        $items = [
            [
                'name' => 'name value 1',
                'email' => 'email value 1',
            ],
            [
                'name' => 'name value 2',
                'email' => 'email value 2',
            ],
        ];

        response(setting('single_multiple')->save($items), 200);

        $result = setting('single_multiple')->get();

        foreach ($result as $index=>$value) {

            $this->assertEquals($value->name, $items[$index]['name']);
            $this->assertEquals($value->email, $items[$index]['email']);

        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_save_and_retrieve_single_multiple_language_setting()
    {
        $items = [
            [
                'name' => ['ar' => 'name value 1 ar', 'en' => 'name value 1 en'],
                'email' => ['ar' => 'email value 1 ar', 'en' => 'email value 1 en'],
            ],
            [
                'name' => ['ar' => 'name value 2 ar', 'en' => 'name value 2 en'],
                'email' => ['ar' => 'email value 2 ar', 'en' => 'email value 2 en'],
            ],
        ];

        response(setting('single_multiple_langugage')->save($items), 200);

        $result = setting('single_multiple_langugage')->get();

        foreach ($result as $index=>$value) {

            $this->assertEquals($value->name, $items[$index]['name'][app()->getLocale()]);
            $this->assertEquals($value->email, $items[$index]['email'][app()->getLocale()]);
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_save_and_retrieve_multiple_setting()
    {
        $items = [
            [
                'name' => 'name 1 multiples',
                'email' => 'email 1 multiples',
            ],
            [
                'name' => 'name 2 multiples',
                'email' => 'email 2 multiples',
            ],
        ];

        response(setting('multiple')->save($items), 200);

        $result = setting('multiple')->get();

        foreach ($result as $index=>$value) {

            $this->assertEquals($value->name, $items[$index]['name']);
            $this->assertEquals($value->email, $items[$index]['email']);
        }
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_save_and_retrieve_multiple_language_setting()
    {
        $items = [
            [
                'name' => ['ar' => 'name value 1 ar', 'en' => 'name value 1 en'],
                'email' => ['ar' => 'email value 1 ar', 'en' => 'email value 1 en'],
            ],
            [
                'name' => ['ar' => 'name value 2 ar', 'en' => 'name value 2 en'],
                'email' => ['ar' => 'email value 2 ar', 'en' => 'email value 2 en'],
            ],
        ];

        $save = setting('multiple_langugage')->save($items);

        response($save, 200);

        $result = setting('multiple_langugage')->get();

        foreach ($result as $index=>$value) {

            $this->assertEquals($value->name, $items[$index]['name'][app()->getLocale()]);
            $this->assertEquals($value->email, $items[$index]['email'][app()->getLocale()]);
        }
    }
}
