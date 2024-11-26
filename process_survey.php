<?php
date_default_timezone_set('Europe/Kyiv');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $question1 = htmlspecialchars($_POST['question1']);
    $question2 = htmlspecialchars($_POST['question2']);
    $question3 = htmlspecialchars($_POST['question3']);
    
    $timestamp = date("Y-m-d_H-i-s");
    $formattedTime = date("Y-m-d H:i:s");
    
    $folder = "survey";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $data = [
        "Name" => $name,
        "Email" => $email,
        "Question 1" => $question1,
        "Question 2" => $question2,
        "Question 3" => $question3,
        "Submission Time" => $formattedTime,
    ];

    $saveAsJson = true;

    if ($saveAsJson) {
        $fileName = $folder . "/survey_" . $timestamp . ".json";
        file_put_contents($fileName, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    } else {
        $fileName = $folder . "/survey_" . $timestamp . ".txt";
        $fileContent = "";
        foreach ($data as $key => $value) {
            $fileContent .= "{$key}: {$value}\n";
        }
        file_put_contents($fileName, $fileContent);
    }

    echo "<h1>Дякую за вашу відповідь!</h1>";
    echo "<p>Ваша відповідь була записана {$formattedTime}.</p>";
} else {
    echo "<h1>Invalid Request</h1>";
}
?>
