<?php

namespace BinaryTree\Comparator;

use BinaryTree\Node\NodeInterface;

interface ComparatorInterface
{
    public static function isGreater($currentValue, $insertedValue): bool;
    public static function isLess($currentValue, $insertedValue): bool;
}