<?php
date_default_timezone_set('America/Los_Angeles');

$script_tz = date_default_timezone_get();
echo $script_tz;
echo ini_get('date.timezone');
if (strcmp($script_tz, ini_get('date.timezone'))){
    echo ' Script timezone differs from ini-set timezone.<br>';
} else {
    echo ' Script timezone and ini-set timezone match.<br>';
}
?>
<?php
$time1 = strtotime('2014-04-19 09:00:59');
//$time2 = strtotime('2014-04-19 09:05:00');
//$time2 = strtotime('2014-04-19 12:05:00');
$time2 = strtotime('2014-04-20 09:05:00');
$diff = $time2 - $time1;
echo $time1.'<br>';
echo 'Time 1: '.date('Y-m-d H:i:s', $time1).'<br>';
echo 'Time 2: '.date('H:i:s', $time2).'<br>';

if($diff){
    echo 'Diff: '.gmdate('H:i:s', $diff).'<br>'; //not good
	echo 'Diff: hour '.date('H', $diff).'<br>'; //not good
	echo 'Diff: calculated hour '. ($diff/3600).'<br>'; //good
	echo 'Diff: minutes '.$diff/60; //good
}else{
    echo 'No Diff.';
}

?>