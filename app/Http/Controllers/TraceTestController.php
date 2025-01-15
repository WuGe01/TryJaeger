<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        // 創建自訂 Span，模擬一個測試操作
        $span = $this->tracer->startSpan('custom-test-api');
        
        $span->setTag('api.name', '/api/test-trace');

        // 模擬邏輯處理
        sleep(2); // 停頓 2 秒，模擬處理時間
        $span->log(['event' => 'test-span-completed']);


        $span->finish(); // 結束 Span

        // 返回測試 JSON 數據
        return response()->json([
            'message' => 'Test trace completed',
        ]);
    }
}
