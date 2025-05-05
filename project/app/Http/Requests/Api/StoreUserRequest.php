<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
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
            'fio' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[а-яёА-ЯЁa-zA-Z\s\-]+$/u' // регулярное выражение из трех слов (ФИО)
            ],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
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
