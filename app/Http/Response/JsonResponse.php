<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse as SymfonyJsonResponse;

class JsonResponse extends SymfonyJsonResponse
{
    public function __construct(mixed $content, int $status = 200)
    {
        try {
            parent::__construct($content, $status);
        } catch (ResourceNotFoundException $exception) {
            return new SymfonyJsonResponse(
                ['error' => $exception->getMessage()], 
                Response::HTTP_NOT_FOUND
            );
        } catch (\Exception $exception) {
            return new SymfonyJsonResponse(
                ['error' => $exception->getMessage()], 
                Response::HTTP_BAD_REQUEST
            );
        }

        parent::__construct($content, $status);
    }
}