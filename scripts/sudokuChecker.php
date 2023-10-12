<?php
/* Sudoku checker  
	What is Sudoku:

Sudoku is a game played on a 9x9 grid. The goal of the game is to fill all cells of the grid with digits from 1 to 9, so that each column, each row, and each of the nine 3x3 sub-grids (also known as blocks) contain all of the digits from 1 to 9. 

Sudoku Solution Validator

Write a function that accepts a 2D array representing a Sudoku board, and returns true if it is a valid solution, or false otherwise. The cells of the sudoku board may also contain 0's, which will represent empty cells. Boards containing one or more zeroes are considered to be invalid solutions.

The board is always 9 cells by 9 cells, and every cell only contains integers from 0 to 9. */

/* Returning the string 'true' and 'false' instead of boolean to make it easier to see the test results. The assumption is that the parameter passed in is always going to be 9x9 */
function sudokuChecker($arr) {

  /* check that argument is an array */
  if (!is_array($arr)) {
    return 'false';
  }

  /* array to store columns, for processing after doing the row validation. */
  $columnArr = [];
	
	foreach ($arr as $rowKey => $rowVal) {

    /* validate values in each row */
		if (!validateRowColumn($rowVal)) {
      return 'false';
    }    

    /* build $columnArr for validating values vertically */
    $column = array_column($arr, $rowKey);
    array_push($columnArr, $column);
	}

  /* loop through columnArr to carry out 'vertical' check of the sudoku values. */
  foreach ($columnArr as $colVal) {
    if (!validateRowColumn($colVal)) {
      return 'false';
    }
  }

  /* outer 3x3 check loop, the for loops increments by 3 up to the entire length of the row and column, and calls validateInnerThreeByThree  */
  for ($row = 0; $row < 9; $row += 3) {
    for ($column = 0; $column < 9; $column += 3) {
      if (!validateInnerThreeByThree($arr, $row, $column)) {
        return 'false';
      }
    }
  }

  /* all the test passed, return true */
  return 'true';
}

/* function for checking each rows and columns passed through */
function validateRowColumn($val) {

	/* array here to store values and for checking against whether the current value in already exists in row/column */
	$valuesArr = [];
  foreach ($val as $v) {
    
		/* call validateValue and pass in value and array for checks */
    if (!validateValue($v, $valuesArr)) {
      return false;
    }
		array_push($valuesArr, $v);
	}
  return true;
}

/* inner 3x3 check function */
function validateInnerThreeByThree($arr, $row, $column) {
  $validateArr = [];

  /* for loop for row and column up to the third index */
  for ($i = $row; $i < $row + 3; $i++) {
    for ($j = $column; $j < $column + 3; $j++) {
      if (!validateValue($arr[$i][$j], $validateArr)) {
        return false;
      }
      array_push($validateArr, $arr[$i][$j]);
    }
  }
  return true;
}

/* function to check each individual value, and also whether the value exists in the array of already existing values */
function validateValue($value, $arr) {
  if (in_array($value, $arr) || !is_numeric($value) || !($value >= 1 && $value <= 9 ) || $value == '') {
    return false;
  }
  return true;
}


/* test cases */

print_r(sudokuChecker([

  [5, 3, 4, 6, 7, 8, 9, 1, 2],

  [6, 7, 2, 1, 9, 5, 3, 4, 8],

  [1, 9, 0, 3, 4, 2, 5, 6, 7], // one 0, should return false

  [8, 5, 9, 7, 6, 1, 4, 2, 3], 

  [4, 2, 6, 8, 5, 3, 7, 9, 1],

  [7, 1, 3, 9, 2, 4, 8, 5, 6],

  [9, 6, 1, 5, 3, 7, 2, 8, 4],

  [2, 8, 7, 4, 1, 9, 6, 3, 5],

  [3, 4, 5, 2, 8, 6, 1, 7, 9]

]));

print_r('<br><br>');

print_r(sudokuChecker([

  [5, 3, 4, 6, 7, 8, 9, 1, 2],

  [6, 7, 2, 1, 9, 5, 3, 4, 8],

  [1, 9, 8, 3, 4, 2, 5, 6, 7],

  [8, 5, 9, 7, 6, 1, 4, 2, 3], // this should be valid, return true

  [4, 2, 6, 8, 5, 3, 7, 9, 1],

  [7, 1, 3, 9, 2, 4, 8, 5, 6],

  [9, 6, 1, 5, 3, 7, 2, 8, 4],

  [2, 8, 7, 4, 1, 9, 6, 3, 5],

  [3, 4, 5, 2, 8, 6, 1, 7, 9]

]));

print_r('<br><br>');

print_r(sudokuChecker([

  [5, 3, 4, 6, 7, 8, 9, 1, 2], 

  [6, 7, 2, 1, 9, 0, 3, 4, 8],

  [1, 0, 0, 3, 4, 2, 5, 6, 0], // zeros, should return false

  [8, 5, 9, 7, 6, 1, 0, 2, 0],

  [4, 2, 6, 8, 5, 3, 7, 9, 1],

  [7, 1, 3, 9, 2, 4, 8, 5, 6],

  [9, 0, 1, 5, 3, 7, 2, 1, 4],

  [2, 8, 7, 4, 1, 9, 6, 3, 5],

  [3, 0, 0, 4, 8, 1, 1, 7, 9]

]));

print_r('<br><br>');

print_r(sudokuChecker([

  [5, 3, 4, 6, 7, 8, 9, 1, 2],

  [6, 7, 2, 1, 9, 5, 3, 4, 8],

  [1, 9, 8, 3, 4, 2, 5, 6, 7],

  [8, 5, 9, 7, 6, 1, 4, 2, 3],

  [4, 2, 1, 8, 1, 3, 7, 9, 1], // repeating 1s, should be false

  [7, 1, 3, 9, 2, 4, 8, 5, 6],

  [9, 6, 1, 5, 3, 7, 2, 8, 4],

  [2, 8, 7, 4, 1, 9, 6, 3, 5],

  [3, 4, 5, 2, 8, 6, 1, 7, 9]

]));

print_r('<br><br>');

print_r(sudokuChecker([

  [2, 4, 8, 3, 9, 5, 7, 1, 6],

  [5, 7, 1, 6, 2, 8, 3, 4, 9],

  [9, 3, 6, 7, 4, 1, 5, 8, 2],

  [6, 8, 2, 5, 3, 9, 1, 7, 4],

  [3, 5, 9, 1, 7, 4, 6, 2, 8], // should be valid

  [7, 1, 4, 8, 6, 2, 9, 5, 3],

  [8, 6, 3, 4, 1, 7, 2, 9, 5],

  [1, 9, 5, 2, 8, 6, 4, 3, 7],

  [4, 2, 7, 9, 5, 3, 8, 6, 1]

]));


print_r('<br><br>');

print_r(sudokuChecker([

  [5, 3, 4, 6, 7, 8, 9, 1, 2],

  [6, 7, 2, 1, 9, 5, 3, 4, 8],

  [1, 9, 8, 3, 4, 2, 5, 6, 7],

  [8, 5, 9, 7, 6, 1, 4, 2, 3], 

  [4, 2, 6, 8, 5, 3, 7, 9, 1], 

  [7, 1, 3, 9, 2, 4, 8, 10, 6], //invalid sudoku number

  [9, 6, 1, 5, 3, 7, 2, 8, 4], 

  [2, 8, 7, 4, 1, 9, 6, 3, 5],

  [3, 4, 5, 2, 8, 6, 1, 7, 9]

]));

print_r('<br><br>');

print_r(sudokuChecker([

  [5, 3, 4, 6, 7, 8, 9, 1, 2],

  [6, 7, 2, 1, 9, 5, 3, 4, 8],

  [1, 9, 8, 3, 4, 2, 5, 6, 7],

  [8, 5, 9, '', 6, 1, 4, 2, 3], // empty number

  [4, 2, 6, 8, 5, 3, 7, 9, 1], 

  [7, 1, 3, 9, 2, 4, 8, 5, 6], 

  [9, 6, 1, 5, 3, 7, 2, 8, 4], 

  [2, 8, 7, 4, 1, 9, 6, 3, 5],

  [3, 4, 5, 2, 8, 6, 1, 7, 9]

]));

print_r('<br><br>');

print_r(sudokuChecker([

  [6, 3, 9, 5, 7, 4, 1, 8, 2],

  [5, 4, 1, 8, 2, 9, 3, 7, 6], //valid solution

  [7, 8, 2, 6, 1, 3, 9, 5, 4],

  [1, 9, 8, 4, 6, 7, 5, 2, 3],

  [3, 6, 5, 9, 8, 2, 4, 1, 7], 

  [4, 2, 7, 1, 3, 5, 8, 6, 9], 

  [9, 5, 6, 7, 4, 8, 2, 3, 1], 

  [8, 1, 3, 2, 9, 6, 7, 4, 5],

  [2, 7, 4, 3, 5, 1, 6, 9, 8]

]));


print_r('<br><br>');

print_r(sudokuChecker([

  [6, 3, 9, 5, 7, 4, 1, 8, 2],

  [5, 4, 1, 8, 2, 9, 3, 7, 6], 

  [7, 8, 2, 6, 1, 3, 9, 5, 4],

  [1, 9, 8, 4, 6, 7, 5, 2, 3],

  [3, 6, 5, 9, 8, 2, 4, 1, 7], 

  [9, 5, 6, 7, 4, 8, 2, 3, 1], //attempt to check 3x3 validation, this should return false

  [4, 2, 7, 1, 3, 5, 8, 6, 9],

  [8, 1, 3, 2, 9, 6, 7, 4, 5],

  [2, 7, 4, 3, 5, 1, 6, 9, 8]

]));

print_r('<br><br>');

print_r(sudokuChecker([

  [5, 3, 4, 6, 7, 8, 9, 1, 2],

  [6, 7, 2, 1, 9, 'test', 3, 4, 8], //non numberic

  [1, 9, 8, 3, 4, 2, 5, 6, 7],

  [8, 5, 9, 7, 6, 1, 4, 2, 3],

  [4, 2, 6, 8, 5, 3, 7, 9, 1], 

  [7, 1, 3, 9, 2, 4, 8, 5, 6], 

  [9, 6, 1, 5, 3, 7, 2, 8, 4], 

  [2, 8, 7, 4, 1, 9, 6, 3, 5],

  [3, 4, 5, 2, 8, 6, 1, 7, 9]

]));

print_r('<br><br>');

print_r(sudokuChecker([

  [5, 6, 4, 9, 1, 8, 3, 2, 7],

  [2, 3, 1, 4, 7, 5, 8, 9, 6], //this should be valid

  [7, 8, 9, 3, 2, 6, 1, 4, 5],

  [9, 4, 2, 5, 3, 7, 6, 8, 1],

  [3, 1, 8, 6, 4, 9, 5, 7, 2], 

  [6, 7, 5, 1, 8, 2, 9, 3, 4], 

  [4, 5, 3, 2, 9, 1, 7, 6, 8], 

  [1, 2, 7, 8, 6, 3, 4, 5, 9],

  [8, 9, 6, 7, 5, 4, 2, 1, 3]

]));


