<?php 
/* Unique in Table 
	Implement the function which takes as argument a sequence and returns a list of items without any elements with the same value next to each other and preserving the original order of elements.

	For example:

	"AAAABBBCCDAABBB"  => {'A', 'B', 'C', 'D', 'A', 'B'}

	"ABBCcAD"         =>  {'A', 'B', 'C', 'c', 'A', 'D'}

	[1,2,2,3,3]       =>  {1,2,3}
*/

function uniqueInTable($sequence) {

	/* assumption here is that the 'only' two types of arguments are arrays and strings? Let's handle this */
	if (is_string($sequence)) {
		$sequenceArr = str_split($sequence);		
	} else if (is_array($sequence)) {
		$sequenceArr = $sequence;
	} else {
		return 'Invalid input';
	}

  /* first character can be added straight to the new array without processing */
  $newList[] = $sequenceArr[0];

  /* starting the for loop at the 1st index of the sequence */
  for ($i = 1; $i < count($sequenceArr); $i++) {

    /* matching current value with the previous value in the array, if there is no match then concatenate the character to the final array. */
    if ($sequenceArr[$i] !== $sequenceArr[$i-1]) {
			array_push($newList, $sequence[$i]);
    }
  }

	/* assumption here is that the return type is a list so let's json_encode the result */
	return json_encode($newList);
}

print_r(uniqueInTable(334)); print_r('<br><br>');
print_r(uniqueInTable('12345224321111444455525')); print_r('<br><br>');
print_r(uniqueInTable('AAAABBBCCDAABBB')); print_r('<br><br>');
print_r(uniqueInTable('ABBCcAD')); print_r('<br><br>');
print_r(uniqueInTable([1,2,2,3,3])); print_r('<br><br>');
print_r(uniqueInTable([1, 2, 4, 4, 5, 2, 2, 7, 3, 7, 7, 9, 0, 34, 22, 22, 6]));

