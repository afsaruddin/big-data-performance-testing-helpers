<?php
/**
 * insert-into-database-from-file.php
 *
 * @author: onirudda.odikare@widespace.com
 * @created on: 6/10/18
 */
require_once "vendor/autoload.php";
require_once "database.php";

use Illuminate\Database\Capsule\Manager as Database;


if (count($argv) < 2) {
	print "Argument missing: " . PHP_EOL;
	print "Example: php insert-into-database-from-file.php [fileName]" . PHP_EOL;
	exit();
}

$filename = $argv[1];

echo "Writing records in students table from file ... " . PHP_EOL;


try {
	$timeFrom = new DateTime('now');

	$query = 'LOAD DATA LOCAL INFILE \'' . $filename . '\' 
		INTO TABLE students 
		CHARACTER SET UTF8 
		FIELDS TERMINATED BY \'\t\' 
		ENCLOSED BY \'\\"\' 
		LINES TERMINATED BY \'\n\'';
	Database::connection()->getPdo()->exec(Database::raw($query));
	$timeTo = new DateTime('now');
	$diff = $timeFrom->diff($timeTo);
	echo PHP_EOL . "DONE in " . $diff->s . ' seconds (' . $diff->i . ' minutes)';

} catch (Exception $e) {
	echo $e->getMessage();
}