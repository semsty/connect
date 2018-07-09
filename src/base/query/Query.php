<?php

namespace semsty\connect\base\query;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\query\exception\InvalidConfiguration;
use yii\httpclient\Request;

class Query extends Request
{
    const LEFT_SEMANTIC_BRACKET = '{';
    const RIGHT_SEMANTIC_BRACKET = '}';
    const SEMANTIC_PATTERN = '([\w\_]+)';

    /**
     * @return Request
     * @throws InvalidConfiguration
     */
    public function prepare()
    {
        $this->setSemanticParams();
        return parent::prepare();
    }

    /**
     * @throws InvalidConfiguration
     */
    protected function setSemanticParams()
    {
        $url = $this->url;
        if (is_array($url)) {
            if ($params = $this->getSemanticParams($url[0])) {
                foreach ($params as $param) {
                    $value = ArrayHelper::getValue($url, $param);
                    if (empty($value)) {
                        throw new InvalidConfiguration("Param $param does not set");
                    }
                    $url[0] = str_replace(static::LEFT_SEMANTIC_BRACKET . $param . static::RIGHT_SEMANTIC_BRACKET, $value, $url[0]);
                    unset($url[$param]);
                }
            }
            $this->url = $url;
        }
    }

    protected function getSemanticParams($source)
    {
        preg_match_all('/' . static::LEFT_SEMANTIC_BRACKET . static::SEMANTIC_PATTERN . static::RIGHT_SEMANTIC_BRACKET . '/', $source, $matches);
        return $matches[1];
    }
}
