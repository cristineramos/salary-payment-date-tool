<?php

class PaymentDateGenerator
{
    /**
     * Calculates the last working day of a given month and year for salary payment.
     *
     * @param int $year
     * @param int $month
     *
     * @return string Returns the last weekday date of the given month and year.
     * Returns this date in the format 'Y-m-d'.
     */
    public function getSalaryPaymentDate(int $year, int $month): string
    {
        $lastDay = new DateTime("last day of $year-$month");

        // Check if the last day is a weekend
        if ($lastDay->format('N') >= 6) {
            // If it's a weekend, adjust to the last weekday (Friday)
            $lastDay->modify('last Friday');
        }

        return $lastDay->format('Y-m-d');
    }

    /**
     * Calculates the bonus payment date for a given year and month, adjusting to the next Wednesday
     * if the 15th falls on a weekend.
     *
     * @param int $year
     * @param int $month
     *
     * @return string Returns a string representing the bonus payment date based on the input year and month. 
     * Returns the date in the format 'Y-m-d'.
     */
    public function getBonusPaymentDate(int $year, int $month): string
    {
        $bonusDay = new DateTime("$year-$month-15");

        // Check if the 15th is a weekday
        if ($bonusDay->format('N') <= 5) {
            // 15th is already a weekday
            return $bonusDay->format('Y-m-d');
        } else {
            // If the 15th is a weekend, adjust to the next Wednesday
            $bonusDay->modify('next Wednesday');
            return $bonusDay->format('Y-m-d');
        }
    }

    /**
     * Returns an array of CSV headers for month, salary payment date, and bonus payment date.
     * 
     * @return array An array containing the CSV headers 'Month', 'Salary Payment Date', and 'Bonus Payment Date' is being returned.
     */
    public function getCSVHeaders(): array 
    {
        return [
            'Month', 
            'Salary Payment Date', 
            'Bonus Payment Date'
        ];
    }

    /**
     * Retrieves payment dates data for each month starting from a specified month in a given year.
     * 
     * @param int year
     * @param int startMonth 
     * 
     * @return array An array of payment dates data is being returned. Each element in the array
     * contains the month name, salary payment date, and bonus payment date for the corresponding month
     * starting from the specified start month and year until December.
     */
    public function getPaymentDatesData(int $year, int $startMonth): array 
    {
        $paymentDatesData = [];

        // Loop through each month from the specified month to December (12)
        for ($month = $startMonth; $month <= 12; $month++) {
            $date = new DateTime("$year-$month-01");
            $monthName = $date->format('F');
            $salaryPaymentDate = $this->getSalaryPaymentDate($year, $month);
            $bonusPaymentDate = $this->getBonusPaymentDate($year, $month);
            $paymentDatesData[] = [$monthName, $salaryPaymentDate, $bonusPaymentDate];
        }

        return $paymentDatesData;
    }

    /**
     * Generates a CSV file with specified headers and payment data, handling file creation and potential errors.
     * 
     * @param array csvHeaders 
     * @param array paymentData 
     * @param string outputFileName 
     * 
     * @return ?string Returns the path of the generated CSV file if the CSV generation process is successful. If an exception occurs during the process,
     * it throws a `RuntimeException` with an error message.
     */
    public function generateSalaryPaymentDatesToCSV(array $csvHeaders, array $paymentData, string $outputFileName): ?string
    {
        // Define the directory where CSV files will be saved
        $csvDirectory = dirname(__DIR__) . '/csv-files';

        try {
            // Check if the directory exists; if not, create it
            if (!is_dir($csvDirectory)) {
                if (!mkdir($csvDirectory, 0777, true) && !is_dir($csvDirectory)) {
                    throw new RuntimeException('Failed to create directory for CSV files.');
                }
            }

            // Define the full path to the output CSV file
            $csvFilePath = $csvDirectory . '/' . $outputFileName . '.csv';

            // If the file already exists, append a timestamp to the filename to avoid overwriting existing files
            if (file_exists($csvFilePath)) {
                $timestamp = date('YmdHis');
                $pathInfo = pathinfo($csvFilePath);
                $csvFilePath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . $timestamp . '.' . $pathInfo['extension'];
            }

            // Open the CSV file for writing
            $fileHandle = fopen($csvFilePath, 'w');
            if ($fileHandle === false) {
                throw new RuntimeException('Failed to open the CSV file for writing.');
            }

            // Write the CSV headers
            fputcsv($fileHandle, $csvHeaders);

            // Write the data rows to the CSV file
            foreach ($paymentData as $row) {
                fputcsv($fileHandle, $row);
            }

            // Close the CSV file
            fclose($fileHandle);

            // Return the path of the generated CSV file
            return $csvFilePath;

        } catch (RuntimeException $e) {
            // Handle any exceptions that occur during CSV generation
            throw new RuntimeException("Error: " . $e->getMessage());
        }
    }

}


