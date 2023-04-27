<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:categories|max:255',
            'description' => 'nullable',
            'image' => 'required|file|image',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required',
            'name.unique' => 'The name is used before',
            'image.image' => 'The image must be a valid image file'
        ];
    }
    
}
