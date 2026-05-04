<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContratoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'lote_id' => ['nullable', 'exists:lotes,id'],
            'archivo' => ['required', 'file', 'mimes:pdf,docx', 'max:5120'],
        ];
    }
}
