<?php
namespace RandomLogger\Request;

use RandomLogger\ValueObject\LogType;

class RandomLoggerRequest
{
    private $type;

    public function __construct($type)
    {
        if (!$type) {
            $type = LogType::getRandomValue();
        }

        $this->type = new LogType($type);
    }

    public function type()
    {
        return $this->type;
    }
}