<?php

namespace App\Http\Requests\Description;

use Illuminate\Foundation\Http\FormRequest;

class StoreDescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('description-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'user_id' => 'required',
            'leader_id' => ''
        ];
    }
}
