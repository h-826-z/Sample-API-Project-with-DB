<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
class PositionRegistrationValidationRequest extends FormRequest
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
            'position_name' => 'required|string',
            'position_rank' => 'required|max:3'
        ];
    }

     /**
     * Response failedValidation Function
     *@author HZ
     * @return 
     * @create date 02/09/2020
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['message'=>$validator->errors()], 400));
    }

    /**
     * Response Custom Error Message
     *@author HZ
     * @return array
     * @create date 02/09/2020
     */

    public function messages()
    {     
        return [
            'position_name.required' => "Position name is required!",
            'position_name.string' => "Position name must be string!",
            'position_rank.required' => "Position rank is required!",
            'position_rank.max' => "Position rank must be maximum 3 characters!!",
        ];
    }
}