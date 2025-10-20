<?php

namespace App\Http;

use App\Support\View;

class ViewResponse extends Response
{
    public static function make(string $view, array $data = [], int $status = 200, array $headers = []): self
    {
        $content = View::render($view, $data);
        $headers = ['Content-Type' => 'text/html; charset=UTF-8'] + $headers;

        return new self($content, $status, $headers);
    }
}
