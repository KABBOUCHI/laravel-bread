<?php

namespace KABBOUCHI\Bread\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;

class Bread extends Facade
{
    public static function routes($name, $controller = null)
    {
        $name = strtolower($name);

        if (!$controller) {
            $controller = ucfirst($name) . "Controller";
        }

        Route::get("/{$name}", "{$controller}@index")->name("{$name}.index");
        Route::post("/{$name}", "{$controller}@store")->name("{$name}.store");
        Route::get("/{$name}/create", "$controller@create")->name("{$name}.create");
        Route::get("/{$name}/{model}/edit", "{$controller}@edit")->name("{$name}.edit");
        Route::get("/{$name}/{model}/delete", "{$controller}@delete")->name("{$name}.delete");
        Route::patch("/{$name}/{model}", "{$controller}@update")->name("{$name}.update");
        Route::delete("/{$name}/{model}", "{$controller}@destroy")->name("{$name}.destroy");
    }

    public static function field($key, $item, $attributes = [], $value = null, $update = false)
    {
        $type = $item['type'];

        $class = 'KABBOUCHI\\Bread\\Http\\Transformers\\' . studly_case(strtolower($type)) . 'Field';

        return (new $class($key, collect($item), $attributes, $value, $update))->render();
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected
    static function getFacadeAccessor()
    {
        return 'bread';
    }
}