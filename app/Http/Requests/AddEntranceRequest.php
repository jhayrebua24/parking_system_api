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
        $id = $this->route('id');
        return [
            'tile_ids' => 'array|min:1|required',
            'tile_ids.*.name' => 'string|required|max:25|min:1|unique:parking_lot_entrances,name,'.$id.',parking_lot_tile_id',
            'tile_ids.*.id' => 'integer|required',
        ];
    }

    public function attributes() {
        return [
            'tile_ids.*.name'  => 'tiles name',
            'tile_ids.*.id' => 'tiles ID',
            'tile_ids' => 'tiles',
        ];
    }
}
