<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Scopes\StatusScope;
use App\Models\Scopes\OrderScope;

class Admin extends Authenticatable
{
    use HasFactory;
    use HasRoles;

    protected $fillable = ['name', 'email', 'phone', 'password', 'status', 'image'];
    protected $hidden   = ['password', 'remember_token'];
    protected $appends  = ['image_path'];

    ///// scope
    public function scopeSort($query , $request)
    {
        return $query->orderBy('id', 'desc');

    }//end of fun

    public function scopeRoleNot(Builder $query, $rolesName = ['super_admin']): Builder
    {
        return $query->when($rolesName, fn ($query) => $query->whereDoesntHave('roles')->orWhereHas('roles', fn($query) => $query->whereNotIn('name', $rolesName)));

    }// end of scope Role

    protected function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image != 'default.png' ? asset('storage/' . $this->image) : asset('admin_assets/images/default.png'),
        );

    }//end of get ImagePath Attribute

    protected static function booted(): void
    {
        static::addGlobalScope(new OrderScope);

        // if(!request()->is('*admins*')) static::addGlobalScope(new StatusScope);

    }//end of Global Scope

}//end pf model