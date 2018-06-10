<?php

namespace App\Infrastructure\Interfaces\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class IndexGetController
{
    public function __invoke()
    {
        return new JsonResponse();
    }
}
