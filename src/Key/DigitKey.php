<?php

namespace BinaryTree\Key;

class DigitKey implements KeyInterface
{
    public const START_KEY = 0;

    private int $rawKey;

    public function __construct()
    {
        $this->rawKey = 0;
    }

    public function getStartKey() {
        return self::START_KEY;
    }

    public function getRaw()
    {
        return $this->rawKey;
    }

    public function setRaw($key)
    {
        if (!is_int($key))
            throw new \InvalidArgumentException("You can have only int keys");

        $this->rawKey  = $key;
    }
}