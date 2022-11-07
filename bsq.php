<?php

class MaxSquareInfo
{
    public $lineIndex;
    public $columnIndex;
    public $squareSize;
}

function parseFile($filename)
{
    $opendFile = fopen($filename, 'r') or die("Cannot open filename\n");
    $nbOfLine = fgets($opendFile);
    $grid = array();

    for ($i = 0; $i < $nbOfLine; $i++) {
        $line = fgets($opendFile);
        $board = array();
        for ($j = 0; $j < strlen($line); $j++) {
            if ($line[$j] == '.') {
                array_push($board, 0);
            } else if ($line[$j] == 'o') {
                array_push($board, 1);
            }
        }
        array_push($grid, $board);
    }

    fclose($opendFile);

    // Save original array info
    $originalArray = $grid;

    // Find Max Size of square and its coordinate
    $squareInfo = FindMaxSquare($grid);

    $originalArray = addSquare($originalArray, $squareInfo->lineIndex, $squareInfo->columnIndex, $squareInfo->squareSize);

    printBoardFromIntegerArray($originalArray);
}

// algorithm starts here
function FindMaxSquare($array)
{
    $squareInfo = new MaxSquareInfo();

    for ($i = 0; $i < count($array); $i++) {
        for ($j = 0; $j < count($array[$i]); $j++) {

            $topLeft = 0;
            $top = 0;
            $left = 0;

            if ($j != 0) {
                $left = $array[$i][$j - 1];
            }
            if ($i != 0 && $j != 0) {
                $topLeft = $array[$i - 1][$j - 1];
            }
            if ($i != 0) {
                $top = $array[$i - 1][$j];
            }
            $array[$i][$j] = $left + $top - $topLeft + $array[$i][$j];
        }
    }

    $maxSquareSize = 0;
    $lineIndex = 0;
    $columnIndex = 0;

    for ($i = 0; $i < count($array); $i++) {
        for ($j = 0; $j < count($array[$i]); $j++) {
            while (true) {

                $testMaxSquareSize = $maxSquareSize + 1;

                if ($i + $testMaxSquareSize > (count($array)) or $j + $testMaxSquareSize > (count($array[$i]))) {
                    break;
                }

                $topLeft = 0;
                $botLeft = 0;
                $topRight = 0;
                $botRight = 0;

                if ($i > 0 && $j > 0) {
                    $topLeft = $array[$i - 1][$j - 1];
                }

                if ($i + $testMaxSquareSize != 0 && $j != 0) {
                    $botLeft = $array[$i - 1 + $testMaxSquareSize][$j - 1];
                }

                if ($i + $testMaxSquareSize != 0 && $j + $testMaxSquareSize != 0) {
                    $botRight = $array[$i - 1 + $testMaxSquareSize][$j - 1 + $testMaxSquareSize];
                }

                if ($j + $testMaxSquareSize != 0 && $i != 0) {
                    $topRight = $array[$i - 1][$j - 1 + $testMaxSquareSize];
                }

                $res = $botRight - $botLeft - $topRight + $topLeft;
                if ($res > 0) {
                    break;
                }
                $maxSquareSize += 1;
                $lineIndex = $i;
                $columnIndex = $j;
            }
        }
    }

    $squareInfo->squareSize = $maxSquareSize;
    $squareInfo->lineIndex = $lineIndex;
    $squareInfo->columnIndex = $columnIndex;
    return $squareInfo;
}

function printBoardFromIntegerArray($array)
{
    // From integer array print board
    // 0 => ' . '
    // 1 => ' o '
    // 2 => ' x '

    for ($i = 0; $i < count($array); $i++) {
        for ($j = 0; $j < count($array[$i]); $j++) {
            if ($array[$i][$j] == 0) {
                print(" . ");
            } else if ($array[$i][$j] == 1) {
                print(" o ");
            } else if ($array[$i][$j] == 2) {
                print(" x ");
            }
        }
        print("\n");
    }
}

function addSquare($array, $lineIndex, $columnIndex, $squareSize)
{
    // Write a square in integer array from $lineIndex and $columnIndex of size $squareSize
    // the 2 will be replace by 'x' when printing the board

    for ($i = 0; $i < $squareSize; $i++) {
        for ($j = 0; $j < $squareSize; $j++) {
            $array[$i + $lineIndex][$j + $columnIndex] = 2;
        }
    }
    return $array;
}

// Used for debugging
function print2DimArray($array)
{
    for ($i = 0; $i < count($array); $i++) {
        for ($j = 0; $j < count($array[$i]); $j++) {
            print($array[$i][$j]);
            print(" ");
        }
        print("\n");
    }
}

if ($argc < 2) {
    print("Need a file\n");
    exit(-1);
}

parseFile($argv[1]);
