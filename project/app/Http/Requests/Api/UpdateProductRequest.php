<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'max:255',
            'description' => 'max:255',
            'price' => 'integer',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = collect($validator->errors()->getMessages())->mapWithKeys(function ($messages, $field) {
            return [$field => $messages[0]]; // Берём только первую ошибку для каждого поля
        })->toArray();

        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation error',
                ...$errors,
            ], 422)
        );
    }
}
