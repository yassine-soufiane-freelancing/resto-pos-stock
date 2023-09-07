<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse;

class CustomRegisterResponse implements RegisterResponse
{
    public function toResponse($request) {
        $result = Auth::user();
        $msg = __('success.register');
        $status = 200;
        return response()->json([
            'result' => $result,
            'msg' => $msg,
            'status' => $status,
        ], $status);
    }
}
