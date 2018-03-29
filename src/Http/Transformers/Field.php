<?php

namespace KABBOUCHI\Bread\Http\Transformers;

abstract class Field
{
    protected $item;
    protected $key;
    protected $attributes;
    protected $value;
    protected $update;

    public function __construct($key, $item, $attributes = [], $value, $update = false)
    {
        $this->key = $key;
        $this->item = $item;
        $this->attributes = $attributes;
        $this->value = $value;
        $this->update = $update;
    }

    public function render()
    {
        
    }
}