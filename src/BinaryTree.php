<?php

namespace BinaryTree;

use BinaryTree\Comparator\ComparatorInterface;
use BinaryTree\Comparator\DigitsComparator;
use BinaryTree\Key\DigitKey;
use BinaryTree\Key\KeyInterface;
use BinaryTree\Node\Node;
use BinaryTree\Node\NodeInterface;

//TODO: сделать каждую ноду бинарным деревом
//TODO: избавиться от массива
class BinaryTree implements TreeInterface
{
    private array $data = [];
    private ComparatorInterface $comparator;

    public function __construct($value = null, KeyInterface $key = null)
    {
        if (isset($value))
            $this->insert($value, $key);

        $this->comparator = new DigitsComparator();
    }

    public function getElementsCount(): int
    {
        return \count($this->data);
    }

    public function getDepth(): int
    {
        return ceil(log(\count($this->data), 2));
    }

    public function getRoot(): ?NodeInterface
    {
        return $this->data[DigitKey::START_KEY] ?? null;
    }

    /**
     * @param $value
     * @param $key
     * @return bool
     */
    public function insert($value, $key = null): ?NodeInterface
    {
        $newNode = new Node($value, $key);

        return $this->insertNode($newNode);
    }

    /**
     * @param NodeInterface $node
     * @return bool
     */
    private function insertNode(NodeInterface $node): ?NodeInterface
    {
        $root = $this->getRoot();

        if ($root === null) {
            $this->data[$node->getKey()->getRaw()] = $node;

            return $node;
        }

        $currentNode = $root;
        while($currentNode !== null) {
            $currentValue = $currentNode->getValue();
            $currentKey = $currentNode->getKey();
            $previousNode = $currentNode;

            if ($this->comparator::isGreater($node->getValue(), $currentValue)) {
                if ($currentNode->getRight() === null) {
                    $newNodeKey = ($currentKey->getRaw() * 2) + 2;
                    $node->getKey()->setRaw($newNodeKey);

                    $this->data[$newNodeKey] = $node;

                    $previousNode->setRight($node);
                    $node->setParent($previousNode);

                    return $node;
                }

                $currentNode = $currentNode->getRight();
                continue;
            }

            if ($this->comparator::isLess($node->getValue(), $currentValue)) {
                if ($currentNode->getLeft() === null) {
                    $newNodeKey = ($currentKey->getRaw() * 2) + 1;
                    $node->getKey()->setRaw($newNodeKey);

                    $this->data[$newNodeKey] = $node;

                    $previousNode->setLeft($node);
                    $node->setParent($previousNode);

                    return $node;
                }

                $currentNode = $currentNode->getLeft();
                continue;
            }

            break;
        }

        return null;
    }

    /**
     * @param $value
     * @return NodeInterface
     */
    public function find($value): ?NodeInterface
    {
        $root = $this->getRoot();

        if ($root === null) {
            throw new \InvalidArgumentException("Tree is empty");
        }

        /**
         * @var NodeInterface $currentNode
         */
        $currentNode = $root;
        while($currentNode !== null || $value !== $currentNode->getValue()) {
            $currentValue = $currentNode->getValue();

            if ($this->comparator::isGreater($value, $currentValue)) {
                $currentNode = $currentNode->getRight();
                continue;
            }

            if ($this->comparator::isLess($value, $currentValue)) {
                $currentNode = $currentNode->getLeft();
                continue;
            }

            break;
        }

        if ($value !== $currentNode->getValue())
            return null;

        return $currentNode;
    }

    /**
     * @return NodeInterface
     */
    public function findMin(): NodeInterface
    {
        $root = $this->getRoot();

        if ($root === null)
            throw new \InvalidArgumentException("Tree is empty");


        $currentNode = $previousNode = $root;
        while ($currentNode !== null) {
            $previousNode = $currentNode;
            $currentNode = $currentNode->getLeft();
        }

        return $previousNode;
    }

    /**
     * @return NodeInterface
     */
    public function findMax(): NodeInterface
    {
        $root = $this->getRoot();

        if ($root === null) {
            throw new \InvalidArgumentException("Tree is empty");
        }

        $currentNode = $previousNode = $root;
        while ($currentNode !== null) {
            $previousNode = $currentNode;
            $currentNode = $currentNode->getRight();
        }

        return $previousNode;
    }

    /**
     * @param $value
     * @return bool
     */
    public function delete($value): bool
    {
        $root = $this->getRoot();

        if ($root === null) {
            throw new \InvalidArgumentException("Tree is empty");
        }

        $neededNode = $this->find($value);
        $parent = $neededNode->getParent();
        $leftChild = $neededNode->getLeft();
        $rightChild = $neededNode->getRight();

        if ($leftChild === null && $rightChild === null) {


            //Unsetting child with value $value
            $this->removeFromParentAndUnset($parent, $value);

            return true;
        }

        if (isset($leftChild, $rightChild)) {
            $currentNode = $rightChild;
            while ($currentNode !== null) {
                $switchingNode = $currentNode;
                $currentNode = $currentNode->getLeft();
            }

            $this->removeFromParentAndUnset($parent, $value);
            $this->addChild($parent, $switchingNode);

            $rightChild = $rightChild->getRight();
            $leftChild->setParent($switchingNode);

            if ($rightChild !== null)
                $rightChild->setParent($switchingNode);


            $switchingNode->setLeft($leftChild);
            $switchingNode->setRight($rightChild);

            return true;
        }

        if (($childNode = $leftChild ?? $rightChild)) {
            $childNode->setParent($parent);

            $this->removeFromParentAndUnset($parent, $value);
            $this->addChild($parent, $childNode);

            return true;
        }

        return false;

    }

    /**
     * @param NodeInterface $parent
     * @param NodeInterface $child
     * @return void
     */
    private function addChild(NodeInterface $parent, NodeInterface $child): void {
        $childValue = $child->getValue();
        $parentValue = $parent->getValue();

        if ($this->comparator::isGreater($childValue, $parentValue)) {
            $parent->setRight($child);

            return;
        }

        if ($this->comparator::isLess($childValue, $parentValue)) {
            $parent->setLeft($child);

            return;
        }

        throw new \InvalidArgumentException("You can't add a child with same value as parent");
    }

    /**
     * @param NodeInterface $parent
     * @param $value
     * @return void
     */
    private function removeFromParentAndUnset(NodeInterface $parent, $value): void {
        //TODO: упростить
        ($parent->getLeft() !== null && $parent->getLeft()->getValue() === $value) ? $parent->setLeft(null) : $parent->setRight(null) ;
//        unset($neededNode);
    }

}