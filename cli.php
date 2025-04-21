#!/usr/bin/env php
<?php
include("./bcms/classes/clsProject_cli.php");

$cli = new clsProject_cli();

// Check if running from the CLI
if ($cli->is_cli()) {
    $cli->show_read_Menu();
    // Additional CLI-specific functionality can go here
} else {
    // Handle cases when the script is accessed via a web browser
    echo "This script is only available from the CLI.\n";
}