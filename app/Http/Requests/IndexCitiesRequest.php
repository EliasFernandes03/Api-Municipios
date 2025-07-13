<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\BrazilUFEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class IndexCitiesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'uf' => $this->has('uf') && is_string($this->input('uf')) ? strtoupper($this->input('uf')) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'uf' => ['required', 'string', 'size:2', Rule::in(BrazilUFEnum::values())],
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'uf.required' => 'O parâmetro UF é obrigatório.',
            'uf.size' => 'O parâmetro UF deve conter exatamente 2 letras.',
            'uf.in' => 'O parâmetro UF deve ser uma UF válida do Brasil',
            'page.required' => 'O parâmetro page é obrigatório.',
            'page.integer' => 'O parâmetro page deve ser um número inteiro.',
            'per_page.required' => 'O parâmetro per_page é obrigatório.',
            'per_page.integer' => 'O parâmetro per_page deve ser um número inteiro.',
            'per_page.max' => 'O per_page não pode ser maior que 100.',
        ];
    }

    #[\Override]
    protected function failedValidation(Validator $validator): void
    {
        $errors = [];

        foreach ($validator->errors()->all() as $message) {
            $errors[] = [
                'title' => 'Campo inválido',
                'detail' => $message,
            ];
        }

        $response = [
            'status' => 'FAIL',
            'message' => 'Parâmetro(s) inválido(s). Tente novamente.',
            'data' => null,
            'errors' => $errors,
        ];

        throw new HttpResponseException(new JsonResponse($response, Response::HTTP_BAD_REQUEST));
    }
}
