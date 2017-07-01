<?php

// Validate Path Argument
if(!isset($argv[1])) { die("no output path specified\n"); }
$outputPath = $_SERVER['PWD'] . '/' . $argv[1];
if(!file_exists(dirname($outputPath))) { die("output directory doesn't exists\n"); }

// Compile Library PHP
$classes = require('vendor/composer/autoload_classmap.php');
$result = array();
foreach($classes as $name => $path) {
  echo "-- $path\n";
  $contents = file_get_contents($path);
  $contents = preg_replace('/^<\?php\n/', '', $contents);
  $result[] = $contents;
}

// Write to Output File
$outputFile = fopen($outputPath, "w");
fwrite($outputFile, "<?php\n" . implode("\n\n", $result));
fclose($outputFile);
die("> saved to $outputPath\n");
