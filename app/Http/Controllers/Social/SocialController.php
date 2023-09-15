<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\HomeController;
use App\Libraries\Utilities\Encryption;
use App\Libraries\Utilities\RequestValidation;
use App\Models\Credentials;
use App\Models\Scheduler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SocialController extends HomeController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadCredentials(Request $request)
    {
        //Request Validation
        $Validation = (new RequestValidation($request))->requestValidator();

        // Throw errors when validation fails
        if ($Validation->fails()) {
            return $this->returnValidationErrors($Validation, __('warnings.invalid_inputs') . "[ERROR-001]");
        }

        try {
            $data = [
                Credentials::TYPE => $request['socialType'],
                Credentials::EMAIL => $request['email'],
                Credentials::CLIENT_ID => $this->encryptString($request['socialType'], $request['id']),
                Credentials::CLIENT_SECRET => $this->encryptString($request['socialType'], $request['secret']),
                Credentials::BASE_URL => $this->encryptString($request['socialType'], $request['baseUrl']),
                Credentials::REDIRECT_URL => $this->encryptString($request['socialType'], $request['redirect']),
                Credentials::OAUTH_URL => $request['oauthUrl'] ?? '',
                Credentials::OAUTH_KEY => $request['oauthKey'] ?? '',
                Credentials::USERNAME => $this->encryptString($request['socialType'], $request['username']),
            ];

            $uploadCredentials = Credentials::insertAndUpdate($data);

            if ($uploadCredentials) {
                $response = $this->returnSuccess('', Response::HTTP_OK, $uploadCredentials, Response::HTTP_OK);
            } else {
                $response = $this->returnError('Something went wrong!!', Response::HTTP_BAD_REQUEST);
            }
            return $response;
        } catch (\Exception $ex) {
            throw new BadRequestHttpException($ex->getMessage());
        }
    }

    /**
     * @param $key
     * @param $value
     * @return void
     */
    public function encryptString($key, $value)
    {
        $key = hash('sha256', $key);
        return (new Encryption($key))->encrypt($value);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function scheduler()
    {
        return view('Scheduler.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addScheduler(Request $request)
    {
        //Request Validation
        $Validation = (new RequestValidation($request))->schedulerValidation();

        // Throw errors when validation fails
        if ($Validation->fails()) {
            return $this->returnValidationErrors($Validation, __('warnings.invalid_inputs') . "[ERROR-002]");
        }

        try {
            $data = [
                Scheduler::TYPE => $request['type'],
                Scheduler::EXECUTION_PERIOD => $request['period'],
                Scheduler::CONTENT_TYPE => $request['contentType'],
                Scheduler::TIME_PERIOD => implode(',', $request['timeSlot']),
            ];

            $upload = Scheduler::insertAndUpdate($data);

            if ($upload) {
                $response = $this->returnSuccess(
                    'Data Uploaded successfully!',
                    Response::HTTP_OK,
                    $upload,
                    Response::HTTP_OK
                );
            } else {
                $response = $this->returnError(
                    'Something went wrong!!',
                    Response::HTTP_BAD_REQUEST
                );
            }
            return $response;
        } catch (\Exception $ex) {
            throw new BadRequestHttpException($ex->getMessage());
        }
    }


}
