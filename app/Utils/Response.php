<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;

trait Response
{
    public function responseWithData($data, $message = null) {
        if ($message != null) {
            return new JsonResponse([
                'result' => true,
                'message' => $message,
                'data' => $data,
            ], 200);
        }

        return new JsonResponse([
            'result' => true,
            'data' => $data,
        ], 200);
    }

    public function responseWithError($message = null, $status = 500) {
        if ($message != null) {
            return new JsonResponse([
                'result' => false,
                'message' => $message,
            ], $status);
        }

        return new JsonResponse([
            'result' => false,
            'mesage' => $message,
        ], $status);
    }


    public function responseWithDataCount($data, $count = null) {
        if ($count == null) {
            return new JsonResponse([
                'result' => true,
                'count' => count($data),
                'data' => $data
            ], 200);
        } else {
            return new JsonResponse([
                'result' => true,
                'count' => $count-1,
                'data' => $data
            ], 200);
        }
    }

    public function responseWithValidation($validation, $data = null) {
        return new JsonResponse([
            'result' => false,
            'data' => $data,
            'message' => $validation,
        ], 422);
    }

    public function responseDataNotFound($customMessage = "", $detail = "", $lang ="") {
        $statusCode = 400;

        if ($customMessage == "") {
            $message = "Data not found";
        } else {
            $message = $customMessage;
        }

        if ($detail == "") {
            return new JsonResponse([
                'message' => $message,
            ], $statusCode);
        } else {
            return new JsonResponse([
                'message' => $message,
                'detail' => $detail,
            ], $statusCode);
        }
    }
}
