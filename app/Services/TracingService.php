<?php

namespace App\Services;

use Jaeger\Config;

class TracingService
{
    private $tracer;

    public function __construct()
    {
        // $config = new Config(
        //     [
        //         'service_name' => 'laravel_app',
        //         'dispatch_mode' => Config::JAEGER_OVER_BINARY_UDP, // 選擇 UDP 模式
        //         'sampler' => [
        //             'type' => \Jaeger\SAMPLER_TYPE_CONST,
        //             'param' => true,
        //         ],
        //         'local_agent' => [
        //             'reporting_host' => '10.0.0.21',
        //             'reporting_port' => 6831, // UDP 端口
        //         ],
        //     ]
        // );

        $config = new Config(
            [
                'service_name' => 'laravel_app',
                'dispatch_mode' => Config::JAEGER_OVER_BINARY_HTTP, // 選擇 HTTP 模式
                'sampler' => [
                    'type' => \Jaeger\SAMPLER_TYPE_CONST, // 固定取樣
                    'param' => true, // 打開追蹤取樣
                ],
                'local_agent' => [
                    'reporting_host' => '10.0.0.21',
                    'reporting_port' => 14268, // HTTP Collector 端口
                ],
            ]
        );

        $this->tracer = $config->initializeTracer();
    }

    public function getTracer()
    {
        return $this->tracer;
    }
}
