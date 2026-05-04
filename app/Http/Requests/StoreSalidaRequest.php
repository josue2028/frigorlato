<?php

namespace App\Http\Requests;

use App\Rules\SalidaNoExcedeStock;
use Illuminate\Foundation\Http\FormRequest;

class StoreSalidaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'cantidad_libras' => ['required', 'numeric', 'gt:0', new SalidaNoExcedeStock],
        ];
    }
}
