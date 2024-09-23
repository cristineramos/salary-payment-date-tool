#!/bin/bash

# Attempt to find PHP in the system PATH
PHP_PATH=$(which php)

# Check if PHP_PATH was found
if [ -z "$PHP_PATH" ]; then
    echo "PHP executable not found in system PATH."
    exit 1
fi

# Define the PHP script path
SCRIPT_PATH="index.php"

# Prompt the user for the argument (CSV file name)
read -p "Enter the CSV file name (e.g., pay-dates-file): " ARGUMENT

# Check if the argument is empty
if [ -z "$ARGUMENT" ]; then
    echo "No file name provided. Exiting."
    exit 1
fi

# Display the detected PHP path (for verification purposes)
# echo "Using PHP from: $PHP_PATH"

# Execute the PHP script with the provided argument
"$PHP_PATH" "$SCRIPT_PATH" "$ARGUMENT"

# Pause to keep the terminal open
read -p "Press [Enter] to continue..."
