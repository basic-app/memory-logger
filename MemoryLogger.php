<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\MemoryLogger;

use Psr\Log\LogLevel;

class MemoryLogger extends \Psr\Log\AbstractLogger
{

    protected $_messages = [];

    public $levels = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG
    ];

    public function log($level, $message, array $context = [])
    {
        if (array_search($level, $this->levels) === false)
        {
            return;
        }
        
        $this->_messages[] = [
            'message' => $message,
            'level' => $level,
            'context' => $context
        ];
    }

    public function clear()
    {
        $this->_messages = [];
    }

    public function getMessages(?array $levels = null) : array
    {
        $return = [];

        foreach($this->_messages as $data)
        {
            if ($levels !== null)
            {
                $levels = (array) $levels;

                if (!array_search($data['level'], $levels))
                {
                    continue;
                }
            }

            $return[] = lang($data['message'], $data['context']);
        }

        return $return;
    }

    public function getEmergencyMessages() : array
    {
        return $this->getMessages(LogLevel::EMERGENCY);
    }

    public function getAlertMessages() : array
    {
        return $this->getMessages(LogLevel::ALERT);
    }

    public function getCriticalMessages() : array
    {
        return $this->getMessages(LogLevel::CRITICAL);
    }

    public function getErrorMessages() : array
    {
        return $this->getMessages(LogLevel::ERROR);
    }

    public function getWarningMessages() : array
    {
        return $this->getMessages(LogLevel::WARNING);
    }

    public function getNoticeMessages() : array
    {
        return $this->getMessages(LogLevel::NOTICE);
    }

    public function getInfoMessages() : array
    {
        return $this->getMessages(LogLevel::INFO);
    }

    public function getDebugMessages() : array
    {
        return $this->getMessages(LogLevel::DEBUG);
    }

}