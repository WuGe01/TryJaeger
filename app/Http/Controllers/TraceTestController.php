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
        $span = $this->tracer->startSpan('test-span');

        // 設置標籤
        $span->setTag('endpoint', 'index');
        $span->log(['event' => 'start-span']);

        // 模擬業務邏輯
        sleep(1);

        $span->log(['event' => 'end-span']);
        $span->finish();

        // 刷新數據
        $this->flush();

        // 返回測試 JSON 數據
        return response()->json([
            'message' => 'Test trace completed',
        ]);
    }
}
