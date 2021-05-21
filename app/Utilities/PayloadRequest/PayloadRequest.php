<?php

namespace App\Utilities\PayloadRequest;

use App\Enums\ResponseMessageEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PayloadRequest implements PayloadRequestInterface
{
    /**
     * Map request keys to camelCase styling
     * @param Request $request
     * @return void
     */
    public function convertToCamelCase(Request $request): void
    {
        $request->replace(
            $this->mapArrayKeys($request->all())
        );
    }

    /**
     * Validate if the request is null or empty
     * @notes handles invalid and empty request
     * @param Request $request
     * @return void
     * @throw HttpException
     */
    public function blockInvalidContent(Request $request) : void
    {
        if (empty($request->all())) {
            throw new HttpException(
                Response::HTTP_BAD_REQUEST,
                ResponseMessageEnum::INVALID_REQUEST
            );
        }
    }

    /**
     * Map array keys
     * @param array $request
     * @return array
     */
    private function mapArrayKeys(array $request): array
    {
        foreach ($request as $key => $value) {
            $previousValue = $value;
            unset($request[$key]);

            $request[Str::camel($key)] = is_array($previousValue) ? $this->mapArrayKeys($previousValue) : $previousValue;
        }

        return $request;
    }
}
