<?php

namespace BinaryTree\Node;

use BinaryTree\Comparator\ComparatorInterface;
use BinaryTree\Key\DigitKey;
use BinaryTree\Key\KeyInterface;
use BinaryTree\Value\ValueInterface;

class Node implements NodeInterface
{
    protected KeyInterface $key;
    protected $value;
    protected ?NodeInterface $parent;
    protected ?NodeInterface $left;
    protected ?NodeInterface $right;

    public function __construct($value, KeyInterface $key = null, ?NodeInterface $parent = null)
    {
        if ($key === null)
            $key = new DigitKey();

        $this->key = $key;
        $this->value = $value;

        $this->parent = $parent;
        $this->left = null;
        $this->right = null;
    }

    /**
     * @return KeyInterface
     */
    public function getKey(): KeyInterface
    {
        return $this->key;
    }

    /**
     * @param KeyInterface $key
     */
    public function setKey(KeyInterface $key): void
    {
        $this->key = $key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return void
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return NodeInterface|null
     */
    public function getParent(): ?NodeInterface
    {
        return $this->parent;
    }

    /**
     * @param NodeInterface|null $parent
     */
    public function setParent(?NodeInterface $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return NodeInterface|null
     */
    public function getLeft(): ?NodeInterface
    {
        return $this->left;
    }

    /**
     * @param NodeInterface|null $left
     */
    public function setLeft(?NodeInterface $left): void
    {
        $this->left = $left;
    }

    /**
     * @return NodeInterface|null
     */
    public function getRight(): ?NodeInterface
    {
        return $this->right;
    }

    /**
     * @param NodeInterface|null $right
     */
    public function setRight(?NodeInterface $right): void
    {
        $this->right = $right;
    }
}