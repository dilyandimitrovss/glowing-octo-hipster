<?php
/**
 * Examples of how to run this script:
 *
 * Output to stdout:
 * php generate.php
 *
 * Output to file
 * php generate.php -o data.xml
 */

require_once(__DIR__ . '/bootstrap.php');

// optional output param
// will default to stdout
$output = false;
$options = getopt('o::');
if(isset($options['o']) && !empty($options['o'])) {
    $output = $options['o'];
}

// Start from the unix epoch
$begin = new DateTime('2012-01-01 00:00:00');

// Up to today
$end = new DateTime();

// Interval is a full day
$interval = DateInterval::createFromDateString('1 day');

// Get the period, loop and build up the array
$period = new DatePeriod($begin, $interval, $end);

$data = array('dates' => array());
foreach ($period as $dateTime) {
    $data['dates'][] = array(
            'time' => $dateTime->getTimestamp(),
            'text' => $dateTime->format('Y-m-d H:i:s')
        );
}

try {
    $stream = new Xml\Writer\StreamBackend($output ?: "php://stdout");
} catch(\Xml\Writer\Exception $e) {
    // Stream not writable, echo and exit with error
    echo 'The specified stream is not writable';
    exit(2);
}

// Write the output
$xml = new Xml\Writer(
    $stream
);

$xml->write(
    new Xml\Writer\ArrayFrontend($data)
    );