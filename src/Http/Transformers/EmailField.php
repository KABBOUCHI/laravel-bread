<?php

namespace KABBOUCHI\Bread\Http\Transformers;

use Illuminate\Support\HtmlString;

class EmailField extends Field
{
    public function render()
    {
        $attributes = array_merge([
            'type'     => 'email',
            'id'       => $this->key,
            'name'     => $this->key,
            'value'    => $this->value,
        ], $this->attributes);
        if (str_contains('required', $this->item[$this->update ? 'update_validation' : 'validation'])) {
            $attributes['required'] = true;
        }
        $html = '<input ';

        foreach ($attributes as $key => $value) {
            $html .= " {$key}='{$value}'";
        }

        $html .= ' >';

        return new HtmlString($html);
    }
}
