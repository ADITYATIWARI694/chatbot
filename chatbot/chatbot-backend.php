<?php
header('Content-Type: application/json');

// Make sure to replace 'PASTE-YOUR-API-KEY' with your actual OpenAI API key
$apiKey = 'PASTE-YOUR-API-KEY';

// Validate and get user message from the frontend
$userMessage = isset($_POST['userMessage']) ? trim($_POST['userMessage']) : '';

if (empty($userMessage)) {
    echo json_encode(['error' => 'Invalid input']);
    exit();
}

// Set up the API request
$apiUrl = 'https://api.openai.com/v1/chat/completions';
$apiData = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [['role' => 'user', 'content' => $userMessage]],
];

$options = [
    'http' => [
        'header' => "Content-type: application/json\r\n" . "Authorization: Bearer $apiKey\r\n",
        'method' => 'POST',
        'content' => json_encode($apiData),
    ],
];

// Make the API request
$context = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);

if ($response === false) {
    echo json_encode(['error' => 'Failed to connect to the OpenAI API']);
    exit();
}

// Return the API response to the frontend
echo $response;
?>
