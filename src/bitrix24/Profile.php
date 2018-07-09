<?php

namespace semsty\connect\bitrix24;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public static function getRequiredKeys(): array
    {
        return ArrayHelper::merge(parent::getRequiredKeys(), [
            'auth' => 'access_token', 'refresh_token', 'domain', 'expires_in', 'scope'
        ]);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            if (!ArrayHelper::keyExists('expires_in', $this->config) || $this->config['expires_in'] <= 3600) {
                $this->setConfigPartially(
                    'expires_in',
                    $this->config['expires_in'] + strtotime('now')
                );
            }
        }
        return parent::beforeSave($insert);
    }
}
