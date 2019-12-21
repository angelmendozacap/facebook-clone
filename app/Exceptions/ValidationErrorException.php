<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ValidationErrorException extends Exception
{
    /**
     * Render the exception as an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'errors' => [
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'title' => 'Validation Error',
                'detail' => 'Your request is malformed or missing fields.',
                'meta' => json_decode($this->getMessage())
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
