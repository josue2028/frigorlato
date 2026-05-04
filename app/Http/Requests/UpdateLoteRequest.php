<?php

namespace App\Http\Requests;

use App\Models\Lote;
use App\Rules\UniqueLoteNumber;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        /** @var Lote|null $lote */
        $lote = $this->route('lote');

        return [
            'numero_lote' => ['required', 'string', 'max:255', new UniqueLoteNumber($lote?->id)],
            'cantidad_entrada' => ['required', 'numeric', 'gt:0'],
            'fecha_entrada' => ['required', 'date'],
        ];
    }
}
