<?php

namespace App\Modules\Bases\src\scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ScopeModel implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check() && !auth()->user()->isAdmin()) {
            return $builder->where('user_id', auth()->id());
        }
    }
}
