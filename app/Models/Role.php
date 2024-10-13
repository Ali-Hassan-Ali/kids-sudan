<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Scopes\OrderScope;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = ['admin_id', 'guard_name', 'name'];

    public function scopeRoleNot(Builder $query, $rolesName = 'super_admin'): Builder
    {
        return $query->when($rolesName, fn ($query) => $query->whereNot('name', $rolesName));

    }// end of scope Role

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