<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParkingLotDetailsRequests extends FormRequest
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
            'name' => 'required|string|min:1|max:25|unique:parking_lot_details,name',
            'width' => 'integer|min:5|max:8',
            'height' => 'integer|min:5|max:8',
        ];
    }
}
