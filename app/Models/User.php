<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Scopes\StatusScope;
use App\Models\Scopes\OrderScope;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded    = [];
    protected $appends    = ['profile_image', 'status_name'];
    protected $hidden     = ['password', 'verification_code', 'image', 'remember_token'];
    protected $attributes = ['status' => 1];

    public function scopeSort(Builder $query): Builder
    {
        return $query->orderBy('id', 'desc');

    }// end of scope sort

    public function getProfileImageAttribute()
    {
        return $this->image ? Storage::url('users/'.$this->image) :  null;

    }//end of get getProfileImage Attribute


    public function statusName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status ? __('cms.active') : __('cms.in_active'),
        );

    }//end of status name

    protected function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? asset('storage/' . $this->image) : asset('assets/images/default.png'),
        );

    }//end of get ImagePath Attribute

    protected static function booted(): void
    {
        static::addGlobalScope(new OrderScope);

        if(!request()->is('*users*')) {
            static::addGlobalScope(new StatusScope);
        }

    }//end of Global Scope

}//end of model