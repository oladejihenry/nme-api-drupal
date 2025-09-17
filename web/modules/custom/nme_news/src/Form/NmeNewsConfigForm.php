<?php

namespace Drupal\nme_news\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class NmeNewsConfigForm extends ConfigFormBase
{


    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames()
    {
        return ['nme_news.settings'];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'nme_news_config_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $config = $this->config('nme_news.settings');

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

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $this->config('nme_news.settings')
            ->set('articles_per_page', $form_state->getValue('articles_per_page'))
            ->set('cache_duration', $form_state->getValue('cache_duration'))
            ->save();

        parent::submitForm($form, $form_state);
    }
}
