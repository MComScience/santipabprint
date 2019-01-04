<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 4/1/2562
 * Time: 13:39
 */
namespace common\components;

use Yii;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;
use yii\base\Component;
use Monolog\Logger as BaseLogger;

class Logger extends Component
{
    const LOG_NAME = 'bot-app';

    private $_logger;

    /**
     * @return mixed
     */
    public function getLogger()
    {
        return $this->_logger;
    }

    /**
     * @param mixed $logger
     */
    public function setLogger($logger)
    {
        $this->_logger = $logger;
    }

    public function init()
    {
        parent::init();
        $logger = new BaseLogger(self::LOG_NAME);
        $logger->pushProcessor(new UidProcessor());
        $logger->pushHandler(new StreamHandler(Yii::getAlias('@runtime').'/logs/bot-app.log', BaseLogger::DEBUG));
        $this->setLogger($logger);
    }
}