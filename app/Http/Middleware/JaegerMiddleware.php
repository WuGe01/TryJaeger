<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\TracingService;

class JaegerMiddleware
{

    private $tracer;

    public function __construct(TracingService $tracingService)
    {
        $this->tracer = $tracingService->getTracer();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        if ( $response->getStatusCode() != 200) {
            // 創建 Span
            $span = $this->tracer->startSpan($request->method() . ' ' . $request->path());
            $span->setTag('http.method', $request->method());
            $span->setTag('http.url', $request->fullUrl());
    
            // 設置返回代碼
            $span->setTag('http.status_code', $response->getStatusCode());
            $span->finish();
    
            // 刷新追蹤數據
            $this->tracer->flush();
        }
        return $next($request);
    }
}
