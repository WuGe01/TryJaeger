<?php

namespace App\Services;

use Jaeger\Config;

class TracingService
{
    private $tracer;

    public function __construct()
    {
        $config = new Config(
            [
                'service_name' => 'laravel_app', // Jaeger 中顯示的服務名稱
                'sampler' => [
                    'type' => \Jaeger\SAMPLER_TYPE_CONST, // 設定取樣策略
                    'param' => true, // 開啟追蹤（true: 取樣所有請求）
                ],
            ],
            'jaeger:6831'
        );
        $this->tracer = $config->initializeTracer();
    }

    public function getTracer()
    {
        return $this->tracer;
    }
}
