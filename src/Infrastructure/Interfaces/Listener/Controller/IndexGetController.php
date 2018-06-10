<?php

namespace App\Infrastructure\Interfaces\Listener\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class IndexGetController
{
    public function __invoke()
    {
        return new Response('OK');
    }
}
