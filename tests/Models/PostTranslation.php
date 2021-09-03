<?php

namespace KitLoong\PowerJoins\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use KitLoong\PowerJoins\PowerJoins;

class PostTranslation extends Model
{
    use PowerJoins;

    /** @var string */
    protected $table = 'post_translations';
}
