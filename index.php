<?php

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Check if required parameters are provided
if (!isset($_GET['slack_name']) || !isset($_GET['track'])) {
    http_response_code(400);
    echo json_encode(["error" => "slack_name and track are required query parameters"]);
    exit;
}

// Get the current day
$daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
$currentDate = new DateTime('now', new DateTimeZone('UTC'));
$currentDay = $daysOfWeek[$currentDate->format('w')];

// Get the current UTC time and format it
$currentUTC = $currentDate->format('Y-m-d\TH:i:s\Z');

// GitHub repository information
$githubUsername = 'RichmanLoveday';
$githubRepo = 'HNGX-task1';
$githubFile = 'index.php';
$githubFileURL = "https://github.com/$githubUsername/$githubRepo/$githubFile";
$githubRepoURL = "https://github.com/$githubUsername/$githubRepo";

$response = [
    "slack_name" => $_GET['slack_name'],
    "current_day" => $currentDay,
    "utc_time" => $currentUTC,
    "track" => $_GET['track'],
    "github_file_url" => $githubFileURL,
    "github_repo_url" => $githubRepoURL,
    "status_code" => 200
];

// Send the JSON response
echo json_encode($response);

?>
