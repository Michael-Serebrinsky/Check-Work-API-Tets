<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProduct extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product-name'     => 'required|max:80|alpha_num',
            'product-price'    => 'required|numeric',
            'product-currency' => 'required|alpha'
        ];
    }
}
