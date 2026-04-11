<?php

namespace Aternos\Mclogs\Api\Action;

use Aternos\Mclogs\Api\ContentParser;
use Aternos\Mclogs\Api\Response\ApiResponse;
use Aternos\Mclogs\Router\Action;

abstract class ApiAction extends Action
{
    public function run(): bool
    {
        header('Access-Control-Allow-Origin: ' . $this->getAllowedOrigin());
        header('Access-Control-Allow-Headers: *');
        if ($this->shouldAllowCredentials()) {
            header('Access-Control-Allow-Credentials: true');
        }
        header("Accept-Encoding: " . implode(",", ContentParser::getSupportedEncodings()));

        $response = $this->runApi();
        $response->output();

        return true;
    }

    protected function getAllowedOrigin(): string
    {
        return '*';
    }

    protected function shouldAllowCredentials(): bool
    {
        return false;
    }

    abstract protected function runApi(): ApiResponse;
}