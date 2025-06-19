<?php

namespace App\Exceptions;

use Exception;

class BookNotFoundException extends Exception
{
    /**
     * Report the exception
     *
     * @return bool|null
     */
    public function report()
    {
        return false;
    }
    
    /**
     * Render the exception into an HTTP response
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
            'error' => 'Book Not Found'
        ], 404);
    }
}