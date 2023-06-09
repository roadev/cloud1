<?php
// Define an array to store error messages
$errors = [];

// Read input values
$value = readNumericPostValue("value");
$type = readPostValue("type");
$from = readPostValue("from");
$to = readPostValue("to");

// Validate data. If any of the values is invalid, then add an appropriate error message to the $errors array
if (!$value){
    // Invalid value
    $errors[] = "<p>Invalid value</p>";
}
if (!$type || !in_array($type, ["distance", "temperature", "mass", "volume"])){
    // Invalid type
    $errors[] = "<p>Invalid conversion type</p>";
}
if (!$from || !$to){
    // Invalid units
    $errors[] = "<p>Invalid units</p>";
}

/* If there are errors then display error messages. Otherwise, calculate and display the result. */
if (count($errors) > 0) {
    displayErrors($errors);
} else {
    // calculate the conversion
    $result = convert($value, $type, $from, $to);
    // Display the output
    displayOutput($value, $from, $to, $result);
}

// Define functions
function convert($value, $type, $from, $to) {
    switch ($type) {
        case "distance":
            return convertDistance($value, $from, $to);
        case "temperature":
            return convertTemperature($value, $from, $to);
        case "mass":
            return convertMass($value, $from, $to);
        case "volume":
            return convertVolume($value, $from, $to);
        default:
            return false;
    }
}

function convertDistance($value, $from, $to) {
    if ($from == "km" && $to == "miles") {
        return $value * 0.621371;
    }
    if ($from == "miles" && $to == "km") {
        return $value * 1.60934;
    }
    return false;
}

function convertTemperature($value, $from, $to) {
    if ($from == "celsius" && $to == "fahrenheit") {
        return ($value * 9/5) + 32;
    }
    if ($from == "fahrenheit" && $to == "celsius") {
        return ($value - 32) * 5/9;
    }
    // Add more conversions as needed...
    return false;
}

function convertVolume($value, $from, $to) {
    if ($from == "liters" && $to == "gallons") {
        return $value * 0.264172;
    }
    if ($from == "gallons" && $to == "liters") {
        return $value / 0.264172;
    }
    // Add more conversions as needed...
    return false;
}


function displayOutput($value, $from, $to, $result) {
    // Display output
    echo "{$value} {$from} are {$result} {$to}";
}

function displayErrors($errors) {
    if (count($errors) === 0 ) {
        return;
    }
    foreach($errors as $e) {
        echo $e;
    }
}

function readNumericPostValue($key) {
    // Validate numeric input
    if (isset($_POST[$key]) && is_numeric($_POST[$key]) && $_POST[$key] >= 0){
        return $_POST[$key];
    }
    return false;
}

function readPostValue($key) {
    // Validate string input
    if (isset($_POST[$key]) && is_string($_POST[$key])){
        return $_POST[$key];
    }
    return false;
}
?>
