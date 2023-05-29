<?php

namespace BinaryTree;

use BinaryTree\Node\NodeInterface;

class Painter
{
    public static function paintTree(BinaryTree $tree): void
    {
        $spacesCount = pow(2, $tree->getDepth());
        $depthLevel = 0;

        $root = $tree->getRoot();
        if ($root === null)
            return;

        $firstRow = array_merge(
            array_fill(0, $spacesCount + 1, '-'),
            [$root->getValue() . "\n"]
        );

        Painter::printRow($firstRow);
//        echo $root->getValue() . "\n";

        $nodesBuffer = [$root];
        while (!empty($nodesBuffer)) {
            $currentNodes = $nodesBuffer;
            $nodesBuffer = [];
            $outputRow = array_fill(0, $spacesCount, '-');

            /**
             * @var NodeInterface $node
             */
            foreach ($currentNodes as $node) {
                if (($leftNode = $node->getLeft()) !== null) {
                    $nodesBuffer[] = $leftNode;

                    $outputRow[] = $leftNode->getValue() . ' ';

//                    echo $leftNode->getValue() . ' ';
                }

                if (($rightNode = $node->getRight()) !== null) {
                    $nodesBuffer[] = $rightNode;

                    $outputRow[] = $rightNode->getValue() . ' ';

//                    echo $rightNode->getValue() . ' ';
                }

                if (!$leftNode && !$rightNode)
                    $outputRow = array_merge($outputRow, ["*", "*"]);
            }

            $outputRow[] = "\n";
            Painter::printRow($outputRow);
            $spacesCount = pow(2, $tree->getDepth()) - pow(2, $depthLevel - 1);

//            echo "\n";
            $depthLevel++;
        }
    }

    private static function printRow(array $row)
    {
        foreach ($row as $element) {
            echo $element;
        }
    }
}