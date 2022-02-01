<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddParkingSlotRequest extends FormRequest
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
            'parking_slot_type' => 'integer|required',
            'distance' => 'array|min:1|required',
            'distance.*.id' => 'integer|required',
            'distance.*.entrance_distances' => 'array|min:1|required',
            'distance.*.entrance_distances.*.distance' => 'integer|required',
            'distance.*.entrance_distances.*.id' => 'integer|required',
        ];
    }

    public function attributes() {
        return [
            'distance.*.entrance_distances' => 'entrace',
            'distance.*.entrance_distances.*.distance' => 'entrance distance',
            'distance.*.entrance_distances.*.id' => 'entrance distance ID',
            'distance.*.id' => 'tile ID',
            'distance' => 'distance',
        ];
    }
}
