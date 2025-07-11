<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCitiesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function prepareForValidation(): void
    {

            $this->merge([
                'uf' => strtoupper($this->input('uf'))
            ]);
    }
    public function rules(): array
    {
        return [
            'uf'        => ['required', 'string', 'size:2'],
            'page'      => ['sometimes', 'integer', 'min:1'],
            'per_page'  => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'uf.required' => 'O parâmetro UF é obrigatório.',
            'uf.size'     => 'O parâmetro UF deve conter exatamente 2 letras.',
            'page.integer' => 'O parâmetro page deve ser um número inteiro.',
            'per_page.integer' => 'O parâmetro per_page deve ser um número inteiro.',
            'per_page.max' => 'O per_page não pode ser maior que 100.',
        ];
    }
}
