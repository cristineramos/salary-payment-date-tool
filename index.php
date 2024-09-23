<?php

require_once 'src/PaymentDateGenerator.php';

// Check if an output filename is provided via CLI arguments
if ($argc < 2) {
    echo "Usage: php index.php <output_filename>\n";
    exit(1);
}

// Retrieve the output CSV filename from CLI arguments
$outputFileName = trim($argv[1]);

// Check if the filename is empty or consists only of spaces
if (empty($outputFileName)) {
    echo "Error: The output filename cannot be empty or just spaces. Please provide a valid filename.\n";
    exit(1);
}

// Instantiate the PaymentDateGenerator class
$paymentDateGenerator = new PaymentDateGenerator();

// Get the current year and month
$currentYear = (int) date('Y');
$currentMonth = (int) date('n');

// Generate payment dates data for the current year and month
$paymentDatesData = $paymentDateGenerator->getPaymentDatesData($currentYear, $currentMonth);

// Retrieve CSV headers
$csvHeaders = $paymentDateGenerator->getCSVHeaders();

// Generate the CSV file with payment dates and retrieve the file path if successful
$csvFilePath = $paymentDateGenerator->generateSalaryPaymentDatesToCSV($csvHeaders, $paymentDatesData, $outputFileName);

if ($csvFilePath) {
    echo "CSV file generated successfully: $csvFilePath\n";
} else {
    echo "Error: Failed to generate the CSV file. Please check your permissions, ensure the directory exists, and try again.\n";
}

