<?php

namespace App\Http\Controllers;

use App\Services\UserService\UserServiceInterface;
use App\Utilities\PayloadRequest\PayloadRequestInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @var PayloadRequestInterface
     */
    private $payloadRequest;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(
        PayloadRequestInterface $payloadRequest,
        UserServiceInterface $userService
    )
    {
        $this->payloadRequest = $payloadRequest;
        $this->userService = $userService;
    }

    /**
     * Importer action
     * @param Request $request
     * @return JsonResponse
     */
    public function importer(Request $request): JsonResponse
    {
        $this->payloadRequest->blockInvalidContent($request);

        $validator = \Validator::make($request->all(),[
            'csv' => 'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()
                ->toArray();

            return response()->json(
                $errors,
                Response::HTTP_BAD_REQUEST
            );
        }

        if (!$request->hasFile('csv') || !$request->file('csv') || $request->file('csv')->getClientMimeType() != 'text/csv') {
            return response()->json(
                Response::$statusTexts[Response::HTTP_BAD_REQUEST],
                Response::HTTP_BAD_REQUEST
            );
        }

        $csv = $request->file('csv');

        $this->userService->importer(
            $csv
        );

        return response()->json(
            Response::$statusTexts[Response::HTTP_OK],
            Response::HTTP_OK
        );
    }
}
