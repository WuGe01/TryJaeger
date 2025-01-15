<?php

namespace App\Services;

use Jaeger\Config;

class TracingService
{
    private $tracer;

    public function __construct()
    {
       
        // 初始化 Jaeger
        $config = new Config(
            [
                'service_name' => 'laravel-app', // Jaeger 中顯示的服務名稱
                'sampler' => [
                    'type' => \Jaeger\SAMPLER_TYPE_CONST, // 設定取樣策略
                    'param' => true, // 開啟追蹤（true: 取樣所有請求）
                ],
            ],
            'localhost:6831'
        );

        // 初始化 Tracer
        $this->tracer = $config->initializeTracer();
    }

    public function getTracer()
    {
        return $this->tracer;
    }

    public function flush()
    {
        $this->tracer->flush();
    }
}
