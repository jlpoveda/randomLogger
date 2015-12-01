<?php
namespace RandomLogger\ValueObject;

class LogType {
    public static $validValues = ['backoffice', 'frontend', 'negocio', 'nice2'];

    private $logType;

    public function __construct($logType)
    {
        if (!in_array($logType, self::$validValues)) {
            throw new \InvalidArgumentException($logType . ' is not a valid value');
        }

        $this->logType = $logType;
    }

    public function __toString()
    {
        return $this->logType;
    }

    public function logType()
    {
        return $this->logType;
    }

    public static function getRandomValue()
    {
        return self::$validValues[rand(0, count(self::$validValues) - 1)];
    }
}
