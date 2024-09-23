@echo off
REM Attempt to find PHP in the system PATH
for /f "usebackq tokens=*" %%i in (`where php 2^>nul`) do set PHP_PATH=%%i

REM Check if PHP_PATH was found
if "%PHP_PATH%"=="" (
    echo PHP executable not found in system PATH.
    pause
    exit /b 1
)

REM Define the PHP script path
SET SCRIPT_PATH=index.php

REM Prompt the user for the argument (CSV file name)
SET /P ARGUMENT=Enter the CSV file name (e.g., pay-dates-file): 

REM Check if the argument is empty
if "%ARGUMENT%"=="" (
    echo No file name provided. Exiting.
    pause
    exit /b 1
)

REM Display the detected PHP path (for verification purposes)
REM echo Using PHP from: %PHP_PATH%

REM Execute the PHP script with the provided argument
"%PHP_PATH%" "%SCRIPT_PATH%" "%ARGUMENT%"

REM Pause to keep the command prompt open after execution
pause
