<?php
# Victor Sobrado 2018
# Open CSV -> Create an Array -> Sort Ascending -> Cut data that falls between two dates -> Print result

#Open sample_data.csv, separate by line, get headers
$lines = explode( "\n", file_get_contents('sample_data.csv'));
$headers = str_getcsv(array_shift($lines));
$data = array();
foreach ($lines as $line) {
	$row = array();
	foreach (str_getcsv($line) as $key => $field )
		$row[$headers[$key]] = $field;
	$row = array_filter($row);
	$data[] = $row;
}

#Function to sort the array by the 'created_at' column
function array_sort_by_column(&$array, $column, $direction = SORT_ASC) {
    $sort_column = array();
    foreach ($array as $key=> $row) {
        $sort_column[$key] = $row[$column];
    }

    array_multisort($sort_column, $direction, $array);
}

#Sort 'em
array_sort_by_column($data, 'created_at');

#Make sure our data falls between June 22 2014 12:00:01 AM and July 22 2014 12:00:01 AM in Unix Epoch Time.
#1403395201 = June 22 2014 12:00:01 AM
#1405987201 = July 22 2014 12:00:01 AM
$i = 1;
do {
if ($data[$i]['created_at'] >= '1403395201' && $data[$i]['created_at'] <= '1405987201') {
#Add a space after each word for clarity.
	echo $data[$i]['word'] . "&nbsp;";
}
$i++;
#Check fields 1-5001 only
} while ($i >= 1 && $i <= 5001);

?>
