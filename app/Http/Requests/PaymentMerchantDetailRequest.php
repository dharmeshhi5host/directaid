<?php
namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class PaymentMerchantDetailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'center_id' => 'required',
            'title' => 'required',
            'merchant_id' => 'required|numeric',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        //write your bussiness logic here otherwise it will give same old JSON response
        throw new HttpResponseException(response()->json(['success' => false, 'message' => $validator->errors()->first()], 422));
    }
}

