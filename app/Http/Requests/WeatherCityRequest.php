<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class WeatherCityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.'exists:cities,name'
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'city' => 'exists:cities,name'
        ];
    }


    protected function prepareForValidation() : void
    {
        $this->merge([
            'city' => $this->route('city')
        ]);
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
