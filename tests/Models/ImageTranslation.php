<?php

namespace KitLoong\PowerJoins\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use KitLoong\PowerJoins\PowerJoins;

class ImageTranslation extends Model
{
    use PowerJoins;

    /** @var string */
    protected $table = 'image_translations';
}
