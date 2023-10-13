<?php

/* Seconds to Human readable string

Write a function which formats a duration, given as a number of seconds, in a human-friendly way.

The function must accept a non-negative integer. If it is zero, it just returns "now". Otherwise, the duration is expressed as a combination of years, days, hours, minutes and seconds.

It is much easier to understand with an example:

* For seconds = 62, your function should return 

    "1 minute and 2 seconds"

* For seconds = 3662, your function should return

    "1 hour, 1 minute and 2 seconds"

A year is always 365 days for this task.

Note that spaces are important.

Rules:

The resulting expression is made of components like 4 seconds, 1 year, etc. In general, a positive integer and one of the valid units of time, separated by a space. The unit of time is used in plural if the integer is greater than 1.

The components are separated by a comma and a space (", "). Except the last component, which is separated by " and ", just like it would be written in English.

A more significant units of time will occur before than a least significant one. Therefore, 1 second and 1 year is not correct, but 1 year and 1 second is.

Different components have different unit of times. So there is not repeated units like in 5 seconds and 1 second.

A component will not appear at all if its value happens to be zero. Hence, 1 minute and 0 seconds is not valid, but it should be just 1 minute.

A unit of time must be used "as much as possible". It means that the function should not return 61 seconds, but 1 minute and 1 second instead. Formally, the duration specified by of a component must not be greater than any valid more significant unit of time.

*/


function formatSeconds($seconds) {

  /* the assumption here is that $seconds is always to be passed in with an integer. But let's handle this just in case. Could use strict type function arguments but this is only available from PHP 7 */
  if (!is_numeric($seconds) || $seconds < 0) {
    return 'Invalid input';
  }

	/* if seconds is 0, return 'now' */
	if ($seconds == 0) {
		return 'now';
  }

  $formatString = '';

  /* convert begin and end to unix timestamp to be passed to date_diff */
	$begin = new DateTime('@0'); 
	$end = new DateTime('@'.$seconds); 

  /* return a DateInterval object with the data that we need */
	$difference = date_diff($begin, $end); 
  
  /* change the names of the object keys for y, d, h, i and s to the whole word representation, and assign them to a new array */ 
  $differenceArr['year'] = $difference->y;
  $differenceArr['day'] = $difference->d;
  $differenceArr['hour'] = $difference->h;
  $differenceArr['minute'] = $difference->i;
  $differenceArr['second'] = $difference->s;

  foreach ($differenceArr as $key => $val) {

    /* only process elements that are greater than zero */
    if ($val > 0) {

      /* processing the string of the key so that if it's more than 1 it adds 's' for plural. */
      $formatString .= ($val == 1) ? $val . ' ' . $key . ', ' : $val . ' ' . $key . 's' . ', ';
    }
  }

  /* trim off the last comma at the end */
  $formatString = rtrim($formatString, ', ');

  /* regex use negative lookahead to find the last occurrence of a comma and space, and replace it with the string ' and '  */
  $finalFormatString = preg_replace('/, (?!.*, )/', ' and ' , $formatString);
  return $finalFormatString;
}

print_r(formatSeconds(-1)); print_r('<br><br>');
print_r(formatSeconds(0)); print_r('<br><br>');
print_r(formatSeconds('ddnsmdbcs')); print_r('<br><br>');
print_r(formatSeconds('200')); print_r('<br><br>');
print_r(formatSeconds(60)); print_r('<br><br>');
print_r(formatSeconds(61)); print_r('<br><br>');
print_r(formatSeconds(62)); print_r('<br><br>');
print_r(formatSeconds(3662)); print_r('<br><br>');
print_r(formatSeconds(3600)); print_r('<br><br>');
print_r(formatSeconds(8000)); print_r('<br><br>');
print_r(formatSeconds(84600)); print_r('<br><br>');
print_r(formatSeconds(86400)); print_r('<br><br>');
print_r(formatSeconds(102587)); print_r('<br><br>');
print_r(formatSeconds(31536002)); print_r('<br><br>');
print_r(formatSeconds(387262893)); 
