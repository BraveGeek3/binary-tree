<?php

namespace BinaryTree\Comparator;

use BinaryTree\Node\NodeInterface;

class DigitsComparator implements ComparatorInterface
{
    public static function isGreater($insertedValue, $currentValue): bool
    {
        if (!is_int($currentValue) || !is_int($insertedValue))
            throw new \InvalidArgumentException("Values must be ints");

        return $insertedValue > $currentValue;
    }

    public static function isLess($insertedValue, $currentValue): bool
    {
        if (!is_int($currentValue) || !is_int($insertedValue))
            throw new \InvalidArgumentException("Values must be ints");

        return $insertedValue < $currentValue;
    }
}