<?php

namespace KABBOUCHI\Bread\Http\Transformers;

use Illuminate\Support\HtmlString;

class TextAreaField extends Field
{
    public function render()
    {
        $attributes = array_merge([
            'id'       => $this->key,
            'name'     => $this->key,
            'class'     => 'form-control',
        ], $this->attributes);
        if (str_contains('required', $this->item[$this->update ? 'update_validation' : 'validation'])) {
            $attributes['required'] = true;
        }
        $html = '<textarea ';

        foreach ($attributes as $key => $value) {
            $html .= " {$key}='{$value}'";
        }

        $html .= ' >';

        $html .= $this->value;

        $html .= '</textarea>';

        return new HtmlString($html);
    }
}
