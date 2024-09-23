# Salary Payment Dates Utility
This utility helps determine the dates when salaries and bonuses should be paid to the sales department based on specific rules.

## Prerequisites
- Ensure you have PHP installed on your system and that it is included in your system PATH.

## Project Structure
  - `index.php` : Entry point for the application, handles CLI arguments and invokes the CSV generation
  - `src/PaymentDateGenerator.php` : Main class containing business logic
  - `csv-files` : Directory where generated CSV files are saved.
  - `run-script.bat` : The batch file that executes the PHP script on Windows.
  - `run-script.sh` :  The shell script that executes the PHP script on Linux.

## How to Use

## Method 1: Run .bat or .sh script

1. **Double-click** on the `run-script.bat` or `run-script.sh` file to start the script.
2. You will be prompted to enter a CSV filename where the file will be saved.
3. Follow the on-screen instructions to proceed.

## Method 2: Run from Command Line
1. Open Command Prompt (`cmd`) and navigate to the directory where the files are located.
2. Paste: php index.php <output_filename>
   e.g.  php index.php salary-payment-date


## Author
Name: Cristine Ramos
Email: cristinevramos@gmail.com

## References
For handling dates and times, this project utilizes methods from the PHP DateTime class.
Link: https://www.php.net/manual/en/class.datetime.php

For handling file and directory operations, this project utilizes methods from PHP Filesystem
Link: https://www.php.net/manual/en/ref.filesystem.php