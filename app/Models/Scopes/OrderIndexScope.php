<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OrderIndexScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
    	// desc and desc
    	$builder->orderBy('index');

    }//end of fun

}//end of class