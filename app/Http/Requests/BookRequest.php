<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:60',
            'authors' => 'required|array|min:1',
            'authors.*' => 'nullable|string|between:2,60',
            'price' => 'numeric|distinct|min:0',
            'discount' => 'integer|distinct|between:0,100',
            'genres' => 'required|array|min:1',
            'genres.*' => 'integer|min:1|exists:genres,id',
            'description' => 'string|required|max:255',
            'cover' => 'required|image|mimes:jpeg,png,jpg'
        ];
    }
}
