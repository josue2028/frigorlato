<?php

namespace App\Http\Requests;

use App\Rules\UniqueLoteNumber;
use Illuminate\Foundation\Http\FormRequest;

class StoreLoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'numero_lote' => ['required', 'string', 'max:255', new UniqueLoteNumber],
            'cantidad_entrada' => ['required', 'numeric', 'gt:0'],
            'fecha_entrada' => ['required', 'date'],
        ];
    }
}
