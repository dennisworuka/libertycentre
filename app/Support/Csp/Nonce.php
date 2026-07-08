<?php

namespace App\Support\Csp;

class Nonce
{
    protected ?string $value = null;

    public function value(): string
    {
        return $this->value ??= base64_encode(random_bytes(16));
    }
}
