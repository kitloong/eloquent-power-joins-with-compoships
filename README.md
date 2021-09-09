# Eloquent Power Joins with Compoships Support

This package is an [Eloquent Power Joins](https://github.com/kirschbaum-development/eloquent-power-joins) extension to support [Compoships](https://github.com/topclaudy/compoships).

You can now use joins in Laravel way, with composite key support.

This package support composite keys for relation:

1. hasOne
2. HasMany
3. belongsTo

You could read the detail explanation at [here](https://kitloong.medium.com/laravel-eloquent-join-with-composite-keys-40a53a4e2dcc).

## Installation

You can install the package via composer:

```
composer require kitloong/eloquent-power-joins-with-compoships
```

## Usage

To implement join with composite key

```sql
select users.* from users inner join posts on users.team_id = posts.team_id and users.category_id = posts.category_id;
```

First, you need to define the model relationship the way Compoships did.

```php
use Awobaz\Compoships\Compoships;
use Kirschbaum\PowerJoins\PowerJoins;

class User extends Model
{
    use PowerJoins;
    use Compoships;
    
    public function posts()
    {
        return $this->hasMany(
            Post::class, 
            ['team_id', 'category_id'], 
            ['team_id', 'category_id']
        );
    }
}
```

Then you can get the same result by simply write

```php
User::joinRelationship('posts');
```

## License

This package is open-sourced software licensed under the [MIT license](LICENSE)
