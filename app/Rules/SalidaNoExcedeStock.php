<?php

namespace App\Rules;

use App\Services\InventarioService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use RuntimeException;

class SalidaNoExcedeStock implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            app(InventarioService::class)->validarSalida((float) $value);
        } catch (RuntimeException $exception) {
            $fail($exception->getMessage());
        }
    }
}
