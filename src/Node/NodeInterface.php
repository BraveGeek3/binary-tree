<?php

namespace BinaryTree\Node;

use BinaryTree\Key\KeyInterface;

interface NodeInterface
{
    public function getKey(): KeyInterface;
    public function setKey(KeyInterface $key): void;
    public function getValue();
    public function setValue($value): void;
    public function getParent(): ?NodeInterface;
    public function setParent(?NodeInterface $parent): void;
    public function getLeft(): ?NodeInterface;
    public function setLeft(?NodeInterface $left): void;
    public function getRight(): ?NodeInterface;
    public function setRight(?NodeInterface $right): void;
}