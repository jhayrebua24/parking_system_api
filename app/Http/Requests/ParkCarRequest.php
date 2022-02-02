<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParkCarRequest extends FormRequest
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
            "entry_id" => "integer|required",
            "vehicle_type" => "integer|required",
            "plate_number" => "string|min:6|max:6|required",
            "datetime_in" => "required|date_format:Y-m-d H:i",
            "tile_id" => "integer|required",
        ];
    }
}
