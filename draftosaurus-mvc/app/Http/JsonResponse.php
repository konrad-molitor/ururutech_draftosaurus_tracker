<?php

namespace App\Http;

class JsonResponse extends Response
{
    public function __construct(array $data, int $status = 200, array $headers = [])
    {
        $headers = array_merge(['Content-Type' => 'application/json'], $headers);
        parent::__construct(json_encode($data, JSON_UNESCAPED_UNICODE), $status, $headers);
    }
}
