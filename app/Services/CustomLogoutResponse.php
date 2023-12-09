<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LogoutResponse;

class CustomLogoutResponse implements LogoutResponse
{
    public function toResponse($request) {
        $result = $request->total_gain;
        $msg = __('success.logout');
        $status = 200;
        return response()->json([
            'result' => $result,
            'msg' => $msg,
            'status' => $status,
        ], $status);
    }
}
