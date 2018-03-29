<?php

namespace KABBOUCHI\Bread\Http\Transformers;


use Illuminate\Support\HtmlString;

class CheckboxField extends Field
{
    public function render()
    {
        $html = "<input type='hidden' name='{$this->key}' value='0'/>";

        $attributes = array_merge([
            'type'     => 'checkbox',
            'id'       => $this->key,
            'name'     => $this->key,
            'value'    => '1',
        ], $this->attributes);

        if (!!$this->value) {
            $attributes['checked'] = 'checked';
        }

        $html .= "<input ";

        foreach ($attributes as $key => $value) {
            $html .= " {$key}='{$value}'";
        }

        $html .= " >";

        return new HtmlString($html);
    }
}