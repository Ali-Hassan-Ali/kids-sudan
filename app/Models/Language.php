<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Scopes\StatusScope;
use App\Models\Scopes\OrderScope;

class Language extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = ['image_path'];

    protected function imagePath(): Attribute
    {
        if ($this->code == 'ar') {
            $flagPath = asset('admin_assets/images/flags/saudi-arabia.svg');
        } elseif($this->code == 'en') {
            $flagPath = asset('admin_assets/images/flags/united-states.svg');
        } else {
            $flagPath = asset('storage/' . $this->flag);
        }

        return Attribute::make(get: fn () => $flagPath);

    }//end of get ImagePath Attribute

    protected static function booted(): void
    {
        static::addGlobalScope(new OrderScope);

        if(!request()->is('*languages*')) static::addGlobalScope(new StatusScope);

    }//end of Global Scope

}//end of model