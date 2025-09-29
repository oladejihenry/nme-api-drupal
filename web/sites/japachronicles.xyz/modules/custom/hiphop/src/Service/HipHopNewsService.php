<?php

namespace Drupal\hiphop\Service;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class HipHopNewsService
{
    protected $httpClient;

    protected $cache;

    protected $configFactory;

    protected $loggerFactory;

    public function __construct(
        ClientInterface $httpClient,
        CacheBackendInterface $cache,
        ConfigFactoryInterface $configFactory,
        LoggerChannelFactoryInterface $loggerFactory
    ) {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->configFactory = $configFactory;
        $this->loggerFactory = $loggerFactory;
    }

    /**
     * Fetch latest news from HipHopNMore
     * @param int $per_page
     * @return array
     */

    public function fetchLatestNews($per_page = null)
    {
        if ($per_page === null) {
            $config = $this->configFactory->get('hiphop.settings');
            $per_page = $config->get('articles_per_page') ?: 12;
        }

        $cache_key = 'hiphop_news_latest_' . $per_page;
        $cache = $this->cache->get($cache_key);
        if ($cache) {
            return $cache->data;
        }

        try {
            $url = $this->configFactory->get('hiphop.settings')->get('hiphop_api_url') . '/?per_page=' . $per_page;
            $response = $this->httpClient->request('GET', $url, [
                'timeout' => 30,
                'headers' => [
                    'User-Agent' => 'Drupal HipHop News Module',
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);

                $config = $this->configFactory->get('hiphop.settings');
                $cache_duration = $config->get('cache_duration') ?: 3600;

                $this->cache->set($cache_key, $data, time() + $cache_duration);
                return $data;
            }
        } catch (RequestException $e) {
            $this->loggerFactory->get('hiphop')->error('Failed to fetch HipHop news: @message', [
                '@message' => $e->getMessage(),
            ]);
        }
        return [];
    }

    /**
     * Fetch news article by ID
     * @param int $id
     * @return array
     */

    public function getArticle($id)
    {
        $cache_key = 'hiphop_news_article_' . $id;
        $cache_data = $this->cache->get($cache_key);

        if ($cache_data) {
            return $cache_data->data;
        }

        try {
            $url = $this->configFactory->get('hiphop.settings')->get('hiphop_api_url') . '/' . $id;
            $response = $this->httpClient->request('GET', $url, [
                'timeout' => 30,
                'headers' => [
                    'User-Agent' => 'Drupal HipHop News Module',
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);

                $config = $this->configFactory->get('hiphop.settings');
                $cache_duration = $config->get('cache_duration') ?: 3600;

                $this->cache->set($cache_key, $data, time() + $cache_duration);
                return $data;
            }
        } catch (RequestException $e) {
            $this->loggerFactory->get('hiphop')->error('Failed to fetch HipHop news article: @message', [
                '@message' => $e->getMessage(),
            ]);
        }
        return [];
    }
}
