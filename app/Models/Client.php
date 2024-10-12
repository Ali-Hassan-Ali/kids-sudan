<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Scopes\StatusScope;
use App\Models\Scopes\OrderIndexScope;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;

    protected $guarded      = [];
    protected $translatable = ['name', 'job', 'description'];
    protected $appends      = ['image_path'];

    protected function imagePath(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->picture != 'default.png' ? asset('storage/' . $this->picture) : asset('admin_assets/images/default.png'),
        );

    }//end of get ImagePath Attribute

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);

    }//end of admin

    protected static function booted(): void
    {
        static::addGlobalScope(new OrderIndexScope);

        if(!request()->is('*clients*')) static::addGlobalScope(new StatusScope);

    }//end of Global Scope

}//end of model