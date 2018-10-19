<?php

namespace connect\crm\retailcrm\action\base;

use connect\crm\base\Action as BaseAction;
use connect\crm\base\helpers\Json;
use connect\crm\retailcrm\action\lists\Credentials;
use connect\crm\retailcrm\action\lists\CustomFields;
use connect\crm\retailcrm\action\lists\Dictionaries;
use connect\crm\retailcrm\Service;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

class Action extends BaseAction
{
    const MAX_LIMIT = 100;
    const REQUEST_LIMIT = 10;

    public $version = 'v5';
    public $apiKey;
    public $subdomain;
    public $with_info = false;
    public $entity;

    public static function getServiceClass()
    {
        return Service::class;
    }

    public function rules(): array
    {
        return [
            [['apiKey', 'subdomain'], 'required'],
            [['apiKey', 'subdomain', 'entity'], 'string']
        ];
    }

    public function getAuthKeys(): array
    {
        return [
            'apiKey', 'subdomain'
        ];
    }

    public function run()
    {
        if ($this->with_info) {
            $this->info();
        }
        return parent::run();
    }

    public function info()
    {
        if (empty($this->service->schema->info)) {
            $infoActions = [Credentials::class, CustomFields::class, Dictionaries::class];
            foreach (array_diff($infoActions, [static::class]) as $infoAction) {
                $action = new $infoAction([
                    'service' => $this->service,
                    'profile' => $this->profile
                ]);
                $action->run();
            }
        }
    }

    /**
     * @return array
     * @throws ErrorException
     * @throws \connect\crm\base\exception\ConnectException
     */
    public function getResponse(): array
    {
        $response = parent::getResponse();
        if ($response['success']) {
            return $response;
        } else {
            throw new ErrorException("Service return error: \r\n" . Json::encode($response));
        }
    }

    public function getEntityPluralizeName()
    {
        return $this->entity . 's';
    }

    public function getConfig(): array
    {
        return ArrayHelper::merge(parent::getConfig(), [
            'requestConfig' => [
                'url' => [
                    $this->getUrl(),
                    'subdomain' => $this->subdomain,
                    'apiKey' => $this->apiKey,
                    'version' => $this->version,
                    'entity' => $this->entity
                ]
            ]
        ]);
    }
}
