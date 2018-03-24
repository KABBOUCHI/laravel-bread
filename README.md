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
```

=> `UsersController.php`
```php
class UsersController extends BreadController
{
    protected $modelClass = User::class;

    public function getFieldOptions()
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
                'validation' => ['required', 'unique:users']
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
