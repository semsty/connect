<?php

namespace connect\crm\bitrix24\action\base;

use connect\crm\base\Action as BaseAction;
use connect\crm\bitrix24\action\Auth;
use connect\crm\bitrix24\action\Fields;
use connect\crm\bitrix24\dict\Entities;
use yii\helpers\ArrayHelper;

class Action extends BaseAction
{
    const TMP_BASE_PATH = '@log/bitrix24';
    const MAX_LIMIT = 50;
    const REQUEST_LIMIT = 1; #instead 1 request per second

    public $auth;
    public $with_auth = true;
    public $with_info = false;
    public $domain = 'subdomain.bitrix24.ru';
    protected $entity;

    public function rules(): array
    {
        $rules = [
            [['auth'], 'string'],
            [['entity'], 'default', 'value' => array_values(Entities::dictEntityTypes())[0]],
            [['path'], 'safe']
        ];
        if (!$this->service->isWebhooks()) {
            $rules[] = [['auth'], 'required'];
        }
        return $rules;
    }

    public function getName(): string
    {
        return $this->entity . '.' . parent::getName();
    }

    public function getConfig(): array
    {
        $parent = parent::getConfig();
        return ArrayHelper::merge($parent, [
            'requestConfig' => [
                'url' => [
                    'auth' => $this->auth,
                    'domain' => $this->domain
                ],
                'options' => [
                    'referer' => ArrayHelper::getValue(\Yii::$app->params, 'hostname'),
                ]
            ]
        ]);
    }

    public function getAuthKeys(): array
    {
        $keys = ['domain'];
        if (!$this->service->isWebhooks()) {
            $keys['auth'] = 'access_token';
        }
        return $keys;
    }

    public function run()
    {
        if ($this->checkAuth()) {
            $this->auth();
        }
        if ($this->with_info) {
            $this->info();
        }
        return parent::run();
    }

    public function checkAuth()
    {
        if (!$this->service->isWebhooks()) {
            $this->with_auth = $this->profile->config['expires_in'] < strtotime('now');
            return $this->with_auth;
        }
    }

    public function auth()
    {
        $auth = new Auth();
        $auth->setProfile($this->profile);
        $auth->run();
        $this->setAuth($this->profile->config);
    }

    public function info()
    {
        if (empty($this->service->schema->info[$this->entity])) {
            $info = new Fields([
                'service' => $this->service,
                'entity' => $this->entity
            ]);
            $info->setProfile($this->profile);
            $info->run();
        }
    }

    public function runBatch()
    {
        if ($this->checkAuth()) {
            $this->auth();
        }
        return parent::runBatch();
    }

    protected function getUrl(): string
    {
        $path = $this->getPath();
        if ($this->service->isWebhooks()) {
            $path = str_replace('rest/', '', $this->getPath()) . '/';
        }
        return $this->service->url . $path;
    }
}
