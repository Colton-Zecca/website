<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthenticationController {
    public function login(Request $request) {
        $username = $request->query->get('username');
        $password = $request->query->get('password');
        JsonResponse::create(array(
            'username' => $username
        ));
    }
}