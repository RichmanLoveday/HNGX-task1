<?php

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Check if the request method is GET and the path starts with "/hng/task1/api"
if ($_SERVER['REQUEST_METHOD'] === 'GET' && strpos($_SERVER['REQUEST_URI'], '/hng/task1/api') === 0) {
    // Extract the query parameters
    $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($query, $params);

    // Check if required parameters are provided
    if (!isset($params['slack_name']) || !isset($params['track'])) {
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
    $githubUsername = 'username'; // Replace with your GitHub username
    $githubRepo = 'repo';         // Replace with your GitHub repository name
    $githubFile = 'file_name.ext'; // Replace with the file name or path
    $githubFileURL = "https://github.com/$githubUsername/$githubRepo/blob/main/$githubFile";
    $githubRepoURL = "https://github.com/$githubUsername/$githubRepo";

    $response = [
        "slack_name" => $params['slack_name'],
        "current_day" => $currentDay,
        "utc_time" => $currentUTC,
        "track" => $params['track'],
        "github_file_url" => $githubFileURL,
        "github_repo_url" => $githubRepoURL,
        "status_code" => 200
    ];

    // Send the JSON response without escape characters
    echo json_encode($response, JSON_UNESCAPED_SLASHES);
} else {
    // Return a 404 error for requests to other paths or methods
    http_response_code(404);
    echo json_encode(["error" => "Not Found"]);
}

?>
