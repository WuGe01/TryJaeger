<?php

namespace App\Http\Controllers;

use App\Services\TracingService;

class TraceTestController extends Controller
{
    private $tracer;

    public function __construct(TracingService $tracingService)
    {
        $this->tracer = $tracingService->getTracer();
    }

    public function test()
    {
        return response()->json([
            'message' => 'Test trace completed',
        ]);
    }
}
