<?php

namespace Drupal\hiphop\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\hiphop\Service\HipHopNewsService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'HipHopBlock' block.
 *
 * @Block(
 *   id = "hiphop_block",
 *   admin_label = @Translation("HipHop News Block"),
 *   category = @Translation("Custom")
 * )
 */
class HipHopBlock extends BlockBase implements ContainerFactoryPluginInterface
{
    /**
     * The HipHop News service.
     *
     * @var \Drupal\hiphop\Service\HipHopNewsService
     */
    protected $hiphopNewsService;

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
        HipHopNewsService $hiphop_news_service
    ) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->hiphopNewsService = $hiphop_news_service;
    }

    /**
     * {@inheritdoc}
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
            $container->get('hiphop.service')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function build()
    {
        // The service will automatically use the configured articles_per_page
        $articles = $this->hiphopNewsService->fetchLatestNews();

        // Convert articles to render arrays
        $article_elements = [];
        foreach ($articles as $article) {
            $article_elements[] = [
                '#theme' => 'hiphop_article',
                '#article' => $article,
            ];
        }

        return [
            '#theme' => 'hiphop_block',
            '#articles' => $article_elements,
            '#title' => $this->t('Latest HipHop News'),
            '#attached' => [
                'library' => ['hiphop/tailwind'],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheMaxAge()
    {
        // Get cache duration from config
        $config = \Drupal::config('hiphop.settings');
        return $config->get('cache_duration') ?: 3600;
    }
}
