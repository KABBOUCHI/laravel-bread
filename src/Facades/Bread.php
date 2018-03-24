<?php

namespace KABBOUCHI\Bread\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;

class Bread extends Facade
{
    public static function routes($name, $controller)
    {
        $name = strtolower($name);

        Route::get("/{$name}", "{$controller}@index")->name("{$name}");
        Route::post("/{$name}", "{$controller}@store")->name("{$name}.store");
        Route::get("/{$name}/create", "$controller@create")->name("{$name}.create");
        Route::get("/{$name}/{model}/edit", "{$controller}@edit")->name("{$name}.edit");
        Route::get("/{$name}/{model}/delete", "{$controller}@delete")->name("{$name}.delete");
        Route::patch("/{$name}/{model}", "{$controller}@update")->name("{$name}.update");
        Route::delete("/{$name}/{model}", "{$controller}@destroy")->name("{$name}.destroy");
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bread';
    }
}