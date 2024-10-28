<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use App\Models\Scopes\OrderScope;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = ['admin_id', 'guard_name', 'name'];

    public function scopeAdminJoin(Builder $query): Builder
    {
        return $query->join('admins', 'roles.admin_id', '=', 'admins.id')
                     ->select('roles.*', 'admins.name as admin_name');

    }// end of scope Role

    public function createdAt(): Attribute
    {
        return Attribute::make(get: fn ($value) => now()->parse($value)->format('Y-m-d'));

    }//end of get createdAt Attribute

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id');

    }//end of belongsToMany permissions

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);

    }//end of admin

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id');

    }//end of belongsToMany admin

    public function adminsRoleCount(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class, 'model_has_roles', 'role_id', 'model_id');

    }//end of belongsToMany admin

    protected static function booted(): void
    {
        static::addGlobalScope(new OrderScope);

    }//end of Global Scope

}//end of model