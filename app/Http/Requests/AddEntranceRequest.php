<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEntranceRequest extends FormRequest
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
            'tile_ids' => 'array|min:0|required',
            'tile_ids.*.name' => 'string|required|max:25|min:1',
            'tile_ids.*.id' => 'integer|required',
        ];
    }
}
