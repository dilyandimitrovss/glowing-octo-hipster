<?php
/**
 * Examples of how to run this script:
 *
 * Output to stdout, reading from stdin:
 * php parse.php
 *
 * Output to file, reading from file
 * php generate.php -i data.xml -o parsed.xml
 */

require_once(__DIR__ . '/bootstrap.php');

// Initialize with stream reader
// Especially useful if script used on CLI with piped input
if(php_sapi_name() != 'cli') {
    echo 'This script is meant to be run on the command line';
    exit;
}

// will default to stdin & stdout if evaluates to false
$input = $output = false;

// optional input / output params
$options = getopt('i::o::');
if(isset($options['i']) && !empty($options['i'])) {
    $input = $options['i'];
}

if(isset($options['o']) && !empty($options['o'])) {
    $output = $options['o'];
}

$xml = new Xml\Reader(
    new Xml\Reader\StreamBackend($input ?: 'php://stdin')
);

// Xml\Reader calls this callback on each item it reads
// Return either the an altered item or false to skip item
$xml->setItemValidator(function($item) {
    // $item should have a 'text' key
    if(!isset($item['text'])) {
        return false;
    }
    
    $dateTime = new DateTime((string) $item['text']);
    // Make sure we convert to PST if valid item
    $dateTime->setTimezone(new DateTimeZone('PST'));

    // Ensure it meets all requirements
    if(
        !\Helper\Integer::isPrime($dateTime->format('Y'))
        && $dateTime->format('m') == '6'
        && $dateTime->format('d') == '30'
    ) {
        // Looks fine, return a new item, this ends up in the Xml\Reader return
        return array(
            'time' => $dateTime->getTimestamp(),
            'text' => $dateTime->format('Y-m-d H:i:s')
        );
    }
});

// All validation's already been done
$validDates = $xml->read();

// reverse sort as required
foreach($validDates['dates'] as $k => $date) {
  unset($validDates['dates'][$k]);
  $validDates['dates'][$date['time']] = $date;
}
rsort($validDates['dates']);

// output to file if specified
// stdout otherwise
try {
    $stream = new Xml\Writer\StreamBackend($output ?: "php://stdout");
} catch(\Xml\Writer\Exception $e) {
    // Stream not writable, echo and exit with error
    echo 'The specified stream is not writable';
    exit(2);
}

// Write the resulting xml :)
$xml = new Xml\Writer($stream);
$xml->write(new Xml\Writer\ArrayFrontend($validDates));