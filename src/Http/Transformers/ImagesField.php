<?php

namespace KABBOUCHI\Bread\Http\Transformers;


use Illuminate\Support\HtmlString;

class ImagesField extends Field
{
    public function render()
    {
        $attributes = array_merge([
            'type'     => 'file',
            'id'       => $this->key,
            'name'     => $this->key . '[]',
            'accept'   => 'image/*',
            'required' => str_contains("required", $this->item[ $this->update ? 'update_validation' : 'validation' ])
        ], $this->attributes);

        $html = "<input";

        foreach ($attributes as $key => $value) {
            $html .= " {$key}='{$value}'";
        }

        $html .= " multiple>";

        return new HtmlString($html);
    }
}