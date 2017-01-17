<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ScreenRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name'                  => 'required',
            'title'                 => 'required',
            'type'                  => 'required',
            'visibility.country_id' => 'required',
        ];
        if ($this->isMethod("patch")) {
            unset($rules['type']);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required'                  => 'Name is required',
            'title.required'                 => 'Title is required',
            'type.required'                  => 'Type is required',
            'visibility.country_id.required' => 'Visibility Country is required',
        ];
    }
}