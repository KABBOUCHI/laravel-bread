<?php

namespace KABBOUCHI\Bread\Http\Transformers;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class MultipleSelectField extends Field
{
    public function render()
    {
        if ($this->value instanceof Collection)
            $this->value = $this->value->pluck($this->item['select']['value'])->toArray();

        $attributes = array_merge([
            'type'     => 'text',
            'id'       => $this->key,
            'name'     => $this->key.'[]',
        ], $this->attributes);
        if (str_contains('required', $this->item[$this->update ? 'update_validation' : 'validation'])) {
            $attributes['required'] = true;
        }
        $html = '<select ';

        foreach ($attributes as $key => $value) {
            $html .= " {$key}='{$value}'";
        }

        $html .= ' multiple>';

        foreach ($this->item['select']['data'] as $option):

            $html .= "<option value='{$option[$this->item['select']['value']]}'";

        if (str_contains($option[$this->item['select']['value']], $this->value)):
                $html .= ' selected';
        endif;

        $html .= "> {$option[$this->item['select']['name']]}</option>";

        endforeach;

        $html .= '</select>';

        return new HtmlString($html);
    }
}
