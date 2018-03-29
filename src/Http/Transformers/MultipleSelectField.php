<?php

namespace KABBOUCHI\Bread\Http\Transformers;


use Illuminate\Support\HtmlString;

class MultipleSelectField extends Field
{
    public function render()
    {
        $attributes = array_merge([
            'type'     => 'text',
            'id'       => $this->key,
            'name'     => $this->key . '[]',
            'required' => str_contains("required", $this->item[ $this->update ? 'update_validation' : 'validation' ])
        ], $this->attributes);

        $html = "<select ";

        foreach ($attributes as $key => $value) {
            $html .= " {$key}='{$value}'";
        }

        $html .= " multiple>";

        foreach ($this->item['select']['data'] as $option):

            $html .= "<option value='{$option[$this->item['select']['value']]}'";

            if (str_contains($option[$this->item['select']['value']], $this->value)):
                $html .= " selected";
            endif;

            $html .= "> {$option[$this->item['select']['name']]}</option>";

        endforeach;

        $html .= "</select>";

        return new HtmlString($html);
    }
}