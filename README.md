# laravel-bread

Installation
----
 
``` bash
composer require kabbouchi/laravel-bread
```


## Usage

```bash
php artisan make:bread UsersController User
```
=> `routes/web.php`

```php
Bread::routes('users');
// or specify a custom controller
Bread::routes('users','UsersController');
```

=> `UsersController.php`
```php

use App\User;
use KABBOUCHI\Bread\Http\BreadType;
use KABBOUCHI\Bread\Http\Controllers\Traits\Bread;

class UsersController extends controller
{
    use Bread;
    
    protected function model()
    {
        return User::class;
    }

    public function getFieldOptions(Model $model)
    {
        return [
            'avatar'      => [
                'type'              => BreadType::IMAGE,
                'validation'        => ['required'],
                'update_validation' => []
            ],
            'name'        => [
            'name' => [
                'type'       => BreadType::TEXT,
                'validation' => ['required']
            ],
            'email'       => [
                'type'       => BreadType::EMAIL,
                'validation' => ['required', 'unique:users'],
                'update_validation' => ['required', 'unique:users,email,' . $model->id]
            ],
            'password'    => [
                'type'       => BreadType::PASSWORD,
                'validation' => ['required'],
            ],
            'role_id'     => [
                'type'       => BreadType::SELECT,
                'select'     => [
                    'data'  => Role::all(),
                    'value' => 'id',
                    'name'  => 'name',
                ],
                'validation' => ['required']
            ],
            'description' => [
                'type'       => BreadType::TEXT_AREA,
                'validation' => [],
            ],
        ];
    }
    
    /* 
     * Custom Table : https://github.com/KABBOUCHI/laravel-table-view
     */
    public function getTableFields()
    {
        return [
            'ID'         => 'id',
            'Name'       => 'name',
            'Role'       => 'role.name',
            'Created At' => function (User $model) {
                return $model->created_at->toDateString();
            },
        ];
    }
}

```
