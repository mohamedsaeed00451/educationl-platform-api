<?php

namespace App\Http\Traits;

trait MessageTrait
{
    public function responseMessage($code, $Status, $Message = null, $data = null)
    {
        return response()->json([
            'code' => $code,
            'status' => $Status,
            'message' => $Message,
            'data' => $data
        ],$code);
    }
}
