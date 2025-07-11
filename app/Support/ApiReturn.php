<?php

declare(strict_types=1);

namespace App\Support;

class ApiReturn
{
    public static function success(array $data, string $message = 'Success'): array
    {
        return [
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ];
    }

    public static function error(string $message = 'Internal Server Error', array $data = []): array
    {
        return [
            'success' => false,
            'message' => $message,
            'data'    => $data,
        ];
    }
}
