<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController {
    public function ping() {
        return JsonResponse::create(array('message' => 'pong'));
    }
}