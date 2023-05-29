<?php

namespace BinaryTree\Key;

interface KeyInterface
{
    public const START_KEY = null;

    public function getRaw();
    public function setRaw($key);
    public function getStartKey();
}