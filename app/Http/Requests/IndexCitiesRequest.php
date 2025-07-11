<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Requests\Request;

class IndexCitiesRequest extends Request
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'uf'        => ['required', 'string', 'size:2'],
            'page'      => ['required', 'integer', 'min:1'],
            'per_page'  => ['required', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'uf.required'     => 'O parâmetro UF é obrigatório.',
            'uf.size'         => 'O parâmetro UF deve conter exatamente 2 letras.',
            'page.required'   => 'O parâmetro page é obrigatório.',
            'page.integer'    => 'O parâmetro page deve ser um número inteiro.',
            'per_page.required' => 'O parâmetro per_page é obrigatório.',
            'per_page.integer'  => 'O parâmetro per_page deve ser um número inteiro.',
            'per_page.max'      => 'O per_page não pode ser maior que 100.',
        ];
    }
}
