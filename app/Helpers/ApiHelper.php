<?php

namespace App\Helpers;

class ApiHelper
{
    static public function apiResponse($responseCode, $responseMessage, $data = null)
    {
        return response()->json([
            'status' => $responseCode,
            'message' => $responseMessage,
            'data' => $data,
        ], $responseCode);
    }

    static public function removeDomainFromlink($url)
    {
        return str_replace(config('filesystems.disks.public.url'), '', $url);
    }
}