<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TestServices;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    protected $testService;

    /**
     * Constructor to inject the service
     *
     * @param TestServices $testService
     */
    public function __construct(TestServices $testService)
    {
        $this->testService = $testService;
    }

    /**
     * Get a test message from the service
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $message = $this->testService->getMessage();
        
        return response()->json(['message' => $message]);
    }
}