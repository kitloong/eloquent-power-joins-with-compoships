<?php

namespace KitLoong\PowerJoins;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use KitLoong\PowerJoins\Mixins\RelationshipsExtraMethods;

class PowerJoinsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        Relation::mixin(new RelationshipsExtraMethods, true);
    }
}
