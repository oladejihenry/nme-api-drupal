<?php

namespace Drupal\Tests\nme_news\Unit\Service;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\nme_news\Service\NmeNewsService;
use Drupal\Tests\UnitTestCase;
use GuzzleHttp\ClientInterface;

/**
 * Unit tests for NmeNewsService.
 *
 * @group nme_news
 */
class NmeNewsServiceTest extends UnitTestCase
{
    protected $nmeNewsService;

    protected function setUp(): void
    {
        parent::setUp();

        $httpClient = $this->createMock(ClientInterface::class);
        $cache = $this->createMock(CacheBackendInterface::class);
        $configFactory = $this->createMock(ConfigFactoryInterface::class);
        $config = $this->createMock(\Drupal\Core\Config\Config::class);
        $loggerFactory = $this->createMock(LoggerChannelFactoryInterface::class);
        $logger = $this->createMock(LoggerChannelInterface::class);

        // Setup config mock
        $config->method('get')->willReturn(12);
        $configFactory->method('get')->willReturn($config);
        $loggerFactory->method('get')->willReturn($logger);

        $this->nmeNewsService = new NmeNewsService(
            $httpClient,
            $cache,
            $configFactory,
            $loggerFactory
        );
    }

    /**
     * Tests that the service can be instantiated.
     */
    public function testServiceInstantiation(): void
    {
        $this->assertInstanceOf(NmeNewsService::class, $this->nmeNewsService);
    }

    /**
     * Tests fetchLatestNews returns array.
     */
    public function testFetchLatestNewsReturnsArray(): void
    {
        $result = $this->nmeNewsService->fetchLatestNews(12);
        $this->assertIsArray($result);
    }
}
