<?php

namespace Drupal\nme_news\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\nme_news\Service\NmeNewsService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'NmeNewsBlock' block.
 *
 * @Block(
 *   id = "nme_news_block",
 *   admin_label = @Translation("NME News Block"),
 *   category = @Translation("Custom")
 * )
 */
class NmeNewsBlock extends BlockBase implements ContainerFactoryPluginInterface
{

    /**
     * The NME News service.
     *
     * @var \Drupal\nme_news\Service\NmeNewsService
     */
    protected $nmeNewsService;

    /**
     * Constructs the plugin instance.
     *
     * @param array $configuration
     *   A configuration array containing information about the plugin instance.
     * @param string $plugin_id
     *   The plugin ID for the plugin instance.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     */
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        NmeNewsService $nme_news_service
    ) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->nmeNewsService = $nme_news_service;
    }

    /**
     * {@inheritdoc}
     * This function creates a new instance of the NME News block.
     * avoids using global calls like \Drupal::service() or \Drupal::getContainer()
     */
    public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition
    ) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('nme_news.service')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        // The service will automatically use the configured articles_per_page
        $articles = $this->nmeNewsService->fetchLatestNews();

        // Convert articles to render arrays
        $article_elements = [];
        foreach ($articles as $article) {
            $article_elements[] = [
                '#theme' => 'nme_news_article',
                '#article' => $article,
            ];
        }

        return [
            '#theme' => 'nme_news_block',
            '#articles' => $article_elements,
            '#title' => $this->t('Latest News from NME'),
            '#attached' => [
                'library' => ['nme_news/tailwind'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheMaxAge()
    {
        // Get cache duration from config
        $config = \Drupal::config('nme_news.settings');
        return $config->get('cache_duration') ?: 3600;
    }
}
