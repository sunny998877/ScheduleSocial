<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }
    public function about() {
        return view('without');
    }

    /**
     * @param Validator $validator
     * @param $errorMessage
     * @param $HTTPStatus
     * @param $errorCode
     * @return JsonResponse
     */
    protected function returnValidationErrors(Validator $validator, $errorMessage = 'Invalid inputs', $HTTPStatus = Response::HTTP_BAD_REQUEST, $errorCode = ''): JsonResponse
    {
        $errors = [
            'status'            => $HTTPStatus,
            'error_message'     => $errorMessage,
            'error_code'        => $errorCode,
            'validation_errors' => $validator->errors()];

        return response()->json($errors, $HTTPStatus, [], JSON_PRETTY_PRINT);
    }

    /**
     * @param $errorMessage
     * @param $HTTPStatus
     * @return JsonResponse
     */
    protected function returnError($errorMessage, $HTTPStatus = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $errors = [
            'status'            => $HTTPStatus,
            'error_message'     => $errorMessage,
            'validation_errors' => null
        ];

        return response()->json($errors, $HTTPStatus, [], JSON_PRETTY_PRINT);
    }

    /**
     * @param $successMessage
     * @param $HTTPStatus
     * @param $data
     * @param $successCode
     * @return JsonResponse
     */
    protected function returnSuccess($successMessage, $HTTPStatus = Response::HTTP_OK, $data = null, $successCode = null): JsonResponse
    {
        $success = ['status' => $HTTPStatus, 'message' => $successMessage, 'data' => $data,];

        return response()->json($success, $HTTPStatus, [], JSON_PRETTY_PRINT);
    }
}
