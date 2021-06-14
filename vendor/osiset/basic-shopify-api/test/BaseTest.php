<?php

namespace Osiset\BasicShopifyAPI\Test;

use Closure;
use GuzzleHttp\Handler\MockHandler;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Osiset\BasicShopifyAPI\Options;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected function buildClient(array $responses = [], ?Closure $options = null): BasicShopifyAPI
    {
        // Build the options
        $opts = new Options();
        $opts->setGuzzleHandler(new MockHandler($responses));
        if ($options) {
            $opts = $options($opts);
        }

        // Build the client
        return new BasicShopifyAPI($opts);
    }
}
