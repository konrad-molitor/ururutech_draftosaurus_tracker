<?php

namespace App\Http;

class RedirectResponse extends Response
{
    public static function to(string $location, int $status = 302): self
    {
        return new self('', $status, ['Location' => $location]);
    }
}
