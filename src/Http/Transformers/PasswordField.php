<?php

namespace KABBOUCHI\Bread\Http\Transformers;

use Illuminate\Support\HtmlString;

class PasswordField extends Field
{
    public function render()
    {
        $attributes = array_merge([
            'type'     => 'password',
            'id'       => $this->key,
            'name'     => $this->key,
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
