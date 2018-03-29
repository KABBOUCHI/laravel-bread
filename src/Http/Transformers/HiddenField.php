<?php

namespace KABBOUCHI\Bread\Http\Transformers;


use Illuminate\Support\HtmlString;

class HiddenField extends Field
{
    public function render()
    {
        $attributes = array_merge([
            'type'     => 'hidden',
            'id'       => $this->key,
            'name'     => $this->key,
            'value'     => $this->value,
        ], $this->attributes);

        $html = "<input ";

        foreach ($attributes as $key => $value) {
            $html .= " {$key}='{$value}'";
        }

        $html .= " >";

        return new HtmlString($html);
    }
}