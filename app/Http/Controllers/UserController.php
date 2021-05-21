<?php

namespace App\Http\Controllers;

use App\Services\UserService\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * UserController constructor.
     * @param UserServiceInterface $userService
     */
    public function __construct(
        UserServiceInterface $userService
    )
    {
        $this->userService = $userService;
    }

    /**
     * Importer action
     * @param Request $request
     * @return JsonResponse
     */
    public function importer(Request $request): JsonResponse
    {
        $validator = \Validator::make($request->all(),[
            'csv.*.file' => 'required|file|mimes:csv|max:512'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()
                ->toArray();

            return response()->json(
                $errors,
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
