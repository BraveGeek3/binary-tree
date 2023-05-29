<?php

namespace BinaryTree;

use BinaryTree\Node\NodeInterface;

interface TreeInterface
{
    public function insert($value, $key = null): ?NodeInterface;
    public function find($value): ?NodeInterface;
    public function findMin(): NodeInterface;
    public function findMax(): NodeInterface;
    public function delete($value): bool;
}