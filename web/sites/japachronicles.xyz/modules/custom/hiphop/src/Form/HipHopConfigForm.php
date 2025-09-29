<?php

namespace Drupal\hiphop\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HipHopConfigForm extends ConfigFormBase
{
    /**
     * The HipHop News service.
     *
     * @var \Drupal\hiphop\Service\HipHopNewsService
     */
    protected $hiphopNewsService;

    public static function create(ContainerInterface $container)
    {
        $instance = parent::create($container);
        $instance->hiphopNewsService = $container->get('hiphop.service');
        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return ['hiphop.settings'];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'hiphop_config_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('hiphop.settings');

        $form['articles_per_page'] = [
            '#type' => 'number',
            '#title' => $this->t('Articles per page'),
            '#default_value' => $config->get('articles_per_page') ?: 12,
            '#min' => 1,
            '#max' => 50,
            '#description' => $this->t('Number of articles to fetch and display.'),
        ];

        $form['cache_duration'] = [
            '#type' => 'select',
            '#title' => $this->t('Cache duration'),
            '#default_value' => $config->get('cache_duration') ?: 3600,
            '#options' => [
                900 => $this->t('15 minutes'),
                1800 => $this->t('30 minutes'),
                3600 => $this->t('1 hour'),
                7200 => $this->t('2 hours'),
                14400 => $this->t('4 hours'),
            ],
            '#description' => $this->t('How long to cache the news articles.'),
        ];

        $form['hiphop_api_url'] = [
            '#type' => 'url',
            '#title' => $this->t('HipHop API URL'),
            '#default_value' => $config->get('hiphop_api_url') ?: 'https://www.hiphopnmore.com/wp-json/wp/v2/posts',
            '#description' => $this->t('The API endpoint used to fetch news articles from HipHopNMore.'),
            '#required' => TRUE,
        ];

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $old_config = $this->config('hiphop.settings');
        $old_articles_per_page = $old_config->get('articles_per_page');
        $old_cache_duration = $old_config->get('cache_duration');
        $old_hiphop_api_url = $old_config->get('hiphop_api_url');

        $new_articles_per_page = $form_state->getValue('articles_per_page');
        $new_cache_duration = $form_state->getValue('cache_duration');
        $new_hiphop_api_url = $form_state->getValue('hiphop_api_url');

        $this->config('hiphop.settings')
            ->set('articles_per_page', $new_articles_per_page)
            ->set('cache_duration', $new_cache_duration)
            ->set('hiphop_api_url', $new_hiphop_api_url)
            ->save();

        // Clear cache if articles per page or cache duration changed
        if ($old_hiphop_api_url != $new_hiphop_api_url || $old_articles_per_page != $new_articles_per_page || $old_cache_duration != $new_cache_duration) {
            $this->messenger()->addMessage($this->t('Configuration saved and cache cleared.'));
        } else {
            $this->messenger()->addMessage($this->t('Configuration saved.'));
        }

        parent::submitForm($form, $form_state);
    }
}
