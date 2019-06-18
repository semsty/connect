<?php

namespace connect\crm\amocrm\action\base;

use connect\crm\amocrm\action\Auth;
use connect\crm\amocrm\action\Info;
use connect\crm\amocrm\dict\Entities;
use connect\crm\amocrm\Profile;
use connect\crm\base\Action as BaseAction;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\helpers\FileHelper;

/**
 * Class Action
 * @property $version
 * @property $subdomain
 * @property $apiKey
 * @property $login
 * @property $with_auth
 * @property $with_info
 * @property-read  $entity
 * @package connect\crm\amocrm\action\base
 */
class Action extends BaseAction
{
    const MAX_LIMIT = 500;
    const REQUEST_LIMIT = 5;
    const MODIFIED_SINCE_FORMAT = 'php:D, d M Y H:i:s O';
    public $version = 'v2';
    public $subdomain;
    public $apiKey;
    public $login;
    public $with_auth = true;
    public $auth;
    public $with_info = false;
    protected $entity;

    public function rules(): array
    {
        return ArrayHelper::merge(parent::rules(), [
            [['subdomain', 'apiKey', 'login', 'version'], 'required'],
            [['subdomain', 'apiKey', 'login', 'version'], 'string'],
        ]);
    }

    public function getConfig(): array
    {
        $cookie = \Yii::getAlias($this->getLogPath() . '/' . $this->apiKey . '/cookie.txt');
        FileHelper::fileCreate($cookie);
        return ArrayHelper::merge(parent::getConfig(), [
            'transport' => 'yii\httpclient\CurlTransport',
            'requestConfig' => [
                'url' => [
                    'version' => $this->version,
                    'subdomain' => $this->subdomain
                ],
                'options' => [
                    'referer' => ArrayHelper::getValue(\Yii::$app->params, 'hostname'),
                    'cookiejar' => $cookie,
                    'cookiefile' => $cookie,
                    'useragent' => 'amoCRM-API-client/1.0',
                    'ssl_verifyhost' => false,
                    'ssl_verifypeer' => false
                ]
            ]
        ]);
    }

    public function getEntityPluralizeName(): string
    {
        return Entities::getEntityTypePluralize($this->entity);
    }

    public function getAuthKeys(): array
    {
        return Profile::getRequiredKeys();
    }

    public function run()
    {
        if ($this->with_auth) {
            $this->auth();
        }
        if ($this->with_info) {
            $this->info();
        }
        return parent::run();
    }

    public function auth()
    {
        $auth = $this->service->getAction(Auth::ID);
        $this->auth = $auth->run();
    }

    public function info()
    {
        if (empty($this->service->schema->info)) {
            $info = $this->service->getAction(Info::ID);
            $info->run();
        }
    }

    public function setIsBatch(bool $value)
    {
        if ($this->with_auth && empty($this->auth)) {
            $this->auth();
        }
        parent::setIsBatch($value);
    }
}
