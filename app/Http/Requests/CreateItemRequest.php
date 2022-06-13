<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateItemRequest extends FormRequest
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
            'heading' => 'required|string|min:5|max:255',
            'category_id' => 'required|exists:item_categories,id',
            'user_id' => 'array|required|min:1',
            'description' => 'required|string|min:5|max:255'
        ];
    }
}
