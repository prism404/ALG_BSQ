<?php

function parseFile($filename)
{
    // open filename
    $opendFile = fopen($filename, 'r');
    // read file
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
    print("\n");
    // close file
    fclose($opendFile);

    // Save original array info
    $originalArray = $grid;

    // Find Max Size of square and its coordonate
    $topLeftMaxLineIndex = 0;
    $topLeftMaxColIndex = 0;
    $maxSize = 1; // Minimum is one Cell so start with size == 1

    // TODO: FindMaxSquare()

    $originalArray = addSquare($originalArray, $topLeftMaxLineIndex, $topLeftMaxColIndex, $maxSize);

    printBoardFromIntegerArray($originalArray);
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
    // Write a square of 2 in integer array from $lineIndex and $columnIndex of size $squareSize
    // the 2 will be replace by 'x' when printing the board.

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

// use argv etc 
parseFile("test");
