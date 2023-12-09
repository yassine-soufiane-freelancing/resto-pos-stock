<?php

namespace App\Service;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse;

class CustomLoginResponse implements LoginResponse
{
    public function toResponse($request) {
        $result = Auth::user();
        $msg = __('success.auth');
        $status = 200;
        return response()->json([
            'result' => $result,
            'msg' => $msg,
            'status' => $status,
        ], $status);
    }
}
