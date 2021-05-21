<?php

namespace App\Utilities\PayloadRequest;

use Illuminate\Http\Request;

interface PayloadRequestInterface
{
    public function convertToCamelCase(Request $request): void;
    public function blockInvalidContent(Request $request) : void;
}
