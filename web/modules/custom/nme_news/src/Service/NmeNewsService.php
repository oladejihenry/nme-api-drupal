<?php

namespace Drupal\nme_news\Service;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class NmeNewsService
{

    protected $httpClient;

    protected $cache;

    protected $configFactory;

    protected $loggerFactory;

    public function __construct(ClientInterface $httpClient, CacheBackendInterface $cache, ConfigFactoryInterface $configFactory, LoggerChannelFactoryInterface $loggerFactory)
    {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->configFactory = $configFactory;
        $this->loggerFactory = $loggerFactory;
    }

    /**
     * Fetch latest news from NME
     * @param int $per_page
     * @return array
     */

    public function fetchLatestNews($per_page = null)
    {
        if ($per_page === null) {
            $config = $this->configFactory->get('nme_news.settings');
            $per_page = $config->get('articles_per_page') ?: 12;
        }

        $cache_key = 'nme_news_latest_' . $per_page;
        $cache = $this->cache->get($cache_key);
        if ($cache) {
            return $cache->data;
        }

        try {
            $url = 'https://www.nme.com/wp-json/wp/v2/posts/?per_page=' . $per_page;
            $response = $this->httpClient->request('GET', $url, [
                'timeout' => 30,
                'headers' => [
                    'User-Agent' => 'Drupal NME News Module',
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);

                //get cache duration from config
                $config = $this->configFactory->get('nme_news.settings');
                $cache_duration = $config->get('cache_duration') ?: 3600;

                //cahce for 1 hour
                $this->cache->set($cache_key, $data, time() + $cache_duration);
                return $data;
            }
        } catch (RequestException $e) {
            $this->loggerFactory->get('nme_news')->error('Failed to fetch NME news: @message', [
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
        $cache_key = 'nme_news_article_' . $id;
        $cache_data = $this->cache->get($cache_key);

        if ($cache_data) {
            return $cache_data->data;
        }

        try {
            $url = 'https://www.nme.com/wp-json/wp/v2/posts/' . $id;
            $response = $this->httpClient->request('GET', $url, [
                'timeout' => 30,
                'headers' => [
                    'User-Agent' => 'Drupal NME News Module',
                ],
            ]);
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);

                //get cache duration from config
                $config = $this->configFactory->get('nme_news.settings');
                $cache_duration = $config->get('cache_duration') ?: 3600;

                $this->cache->set($cache_key, $data, time() + $cache_duration);
                return $data;
            }
        } catch (RequestException $e) {
            $this->loggerFactory->get('nme_news')->error('Failed to fetch NME news article: @message', [
                '@message' => $e->getMessage(),
            ]);
        }
        return [];
    }

    /**
     * Clear cache when configuration changes
     */

    public function clearCache()
    {
        $cache_keys = [
            'nme_news_latest_6',
            'nme_news_latest_12',
            'nme_news_latest_18',
            'nme_news_latest_24',
            'nme_news_latest_30',
            'nme_news_latest_36',
            'nme_news_latest_42',
            'nme_news_latest_48',
        ];

        foreach ($cache_keys as $cache_key) {
            $this->cache->delete($cache_key);
        }
    }
}
