<?php

namespace semsty\connect\base;

use semsty\connect\base\dict\Data;
use semsty\connect\base\dict\Dictionaries;
use semsty\connect\base\dict\Entities;
use semsty\connect\base\dict\Utm;
use semsty\connect\base\exception\Exception;
use semsty\connect\base\exception\InvalidConfiguration;
use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\base\query\Connection;
use semsty\connect\base\query\Query;
use semsty\connect\base\query\Response;
use semsty\connect\base\query\Schema;
use semsty\connect\base\traits\ProfiledModel;
use semsty\connect\base\traits\ReferenceReflection;
use yii\base\Component;

/**
 * Class Service
 * @property $url
 * @property $name
 * @property $connection
 * @property $session
 * @package connect\base
 */
class Service extends Component
{
    use ProfiledModel, ReferenceReflection;

    const ID = 0;
    const SERVICE_ID = self::ID;
    const NAME = 'base-service';
    public $with_session = true;
    public $formats = ['json'];
    protected $_path = 'service';
    /**
     * @var $_connection Connection
     */
    protected $_connection;
    /**
     * @var $_session Session
     */
    protected $_session;
    /**
     * @var $_schema Schema
     */
    protected $_schema;
    protected $_connection_class = Connection::class;
    /**
     * @var $_dictionaries Dictionaries
     */
    protected $_dictionaries;

    /**
     * Service constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->_dictionaries = new Dictionaries(static::getDictionariesList());
    }

    /**
     * @return array
     */
    public static function getDictionariesList(): array
    {
        return [
            Entities::class,
            Data::class,
            Utm::class
        ];
    }

    public static function getProfileClass()
    {
        return static::getReferenceClass('Profile', Profile::class);
    }

    public static function getSessionClass()
    {
        return static::getReferenceClass('Session', Session::class);
    }

    /**
     * @throws InvalidConfiguration
     */
    public function init()
    {
        parent::init();
        if ($this->with_session) {
            $this->createSession();
        }
    }

    /**
     * @throws InvalidConfiguration
     */
    public function createSession()
    {
        if (!$this->session->activate()) {
            throw new InvalidConfiguration($this->_session->errors);
        }
    }

    /**
     * @throws InvalidConfiguration
     */
    public function __destruct()
    {
        if ($this->with_session) {
            $this->destructSession();
        }
    }

    /**
     * @throws InvalidConfiguration
     */
    public function destructSession()
    {
        if (!$this->session->deactivate()) {
            throw new InvalidConfiguration($this->session->errors);
        }
    }

    public function getName(): string
    {
        return static::NAME;
    }

    public function getUrl(): string
    {
        return $this->_path;
    }

    /**
     * @return object|Schema
     * @throws \yii\base\InvalidConfigException
     */
    public function getSchema()
    {
        if (empty($this->_schema)) {
            $this->_schema = \Yii::createObject(['service' => &$this, 'class' => static::getSchemaClass()]);
        }
        return $this->_schema;
    }

    public static function getSchemaClass()
    {
        return static::getReferenceClass('query\Schema', Schema::class);
    }

    /**
     * @return Session
     * @throws InvalidConfiguration
     */
    public function getSession(): Session
    {
        if (empty($this->_session)) {
            $this->_session = new Session($this->getSessionAttributes());
            if ($this->_profile) {
                $this->_session->profile_id = $this->_profile->id;
            }
            if (!$this->_session->save()) {
                throw new InvalidConfiguration($this->_session->errors);
            }
        }
        return $this->_session;
    }

    public function setSession(Session $session)
    {
        $this->_session = $session;
    }

    public function getSessionAttributes(): array
    {
        return [
            'service' => &$this,
            'service_id' => static::ID
        ];
    }

    /**
     * @return Connection|object
     * @throws \yii\base\InvalidConfigException
     */
    public function getConnection(): Connection
    {
        if (!is_object($this->_connection)) {
            $class = $this->_connection_class;
            $this->_connection = \Yii::createObject(ArrayHelper::merge([
                'class' => $class,
                'service' => &$this
            ], $this->getConfig()));
        }
        return $this->_connection;
    }

    public function setConnection(Connection $client)
    {
        $this->_connection = $client;
    }

    public function getConfig(): array
    {
        return [
            'baseUrl' => $this->url,
            'requestConfig' => [
                'headers' => [
                    'Content-Type' => 'application/' . $this->formats[0]
                ],
                'class' => Query::class
            ],
            'responseConfig' => [
                'class' => Response::class
            ]
        ];
    }

    public function withProfile($profile): self
    {
        $profile = $this->getOrCreateProfile($profile);
        $this->setProfile($profile);
        $this->session->profile_id = $this->profile->id;
        return $this;
    }

    public function setProfile(Profile &$profile)
    {
        $profile->service = $this;
        $this->_profile = $profile;
        if (method_exists($this, 'setAuth')) {
            $this->setAuth($this->_profile->config);
        }
    }

    public function getProfileAttributes(): array
    {
        return [
            'service' => &$this
        ];
    }

    /**
     * @param $name
     * @param array $config
     * @return Action
     * @throws Exception
     */
    public function action($name, array $config = []): Action
    {
        return $this->getAction($name, $config);
    }

    /**
     * @param $name
     * @param array $config
     * @return mixed
     * @throws Exception
     */
    public function getAction($name, array $config = []): Action
    {
        $defaultConfig = [];
        $class = static::getActionClass($name);
        if (is_array($class)) {
            $defaultConfig = $class[1];
            $class = $class[0];
        }
        if (!$class) {
            throw new Exception("Action $name does not exists");
        }
        $attributes = ['service' => &$this];
        if (!empty($this->_profile)) {
            $attributes['profile'] = &$this->profile;
        }
        return new $class(ArrayHelper::merge($attributes, $defaultConfig, $config));
    }

    /**
     * @param mixed $name
     * @return string
     */
    public static function getActionClass($name): string
    {
        if (is_numeric($name)) {
            return ArrayHelper::getValue(static::getActionsById(), $name);
        } elseif (is_string($name)) {
            return ArrayHelper::getValue(static::getActions(true), $name);
        }
    }

    /**
     * @return array
     */
    public static function getActionsById(): array
    {
        $result = [];
        foreach (static::getActions(true, true) as $className) {
            if (is_array($className)) {
                $className = $className[0];
            }
            $result[$className::ID] = $className;
        }
        ksort($result);
        return $result;
    }

    /**
     * @param bool $merge
     * @param bool $collapse
     * @return array
     */
    public static function getActions($merge = false, $collapse = false): array
    {
        if ($merge) {
            $actions = ArrayHelper::merge(static::getDataProviderActions(), static::getDataRecipientActions());
        } else {
            $actions = [
                Constants::DATA_PROVIDER => static::getDataProviderActions(),
                Constants::DATA_RECIPIENT => static::getDataRecipientActions()
            ];
        }
        if ($collapse) {
            $actions = ArrayHelper::implodeKeysRecursive($actions);
        }
        return $actions;
    }

    public static function getDataProviderActions(): array
    {
        return [
            Action::NAME => Action::class
        ];
    }

    public static function getDataRecipientActions(): array
    {
        return [
            Action::NAME => Action::class
        ];
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getDict($name)
    {
        return $this->getDictionaries()->get($name);
    }

    /**
     * @return mixed
     */
    public function getDictionaries()
    {
        return $this->_dictionaries;
    }
}
