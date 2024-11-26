<?php
// Встановлення часової зони
date_default_timezone_set('Europe/Kyiv');

// Перевірка методу POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Збір даних із форми
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $question1 = htmlspecialchars($_POST['question1']);
    $question2 = htmlspecialchars($_POST['question2']);
    $question3 = htmlspecialchars($_POST['question3']);
    
    // Формат дати та часу
    $timestamp = date("Y-m-d_H-i-s");
    $formattedTime = date("Y-m-d H:i:s");

    // Папка для збереження файлів
    $folder = "survey";
    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // Дані для збереження у файл
    $data = [
        "Name" => $name,
        "Email" => $email,
        "Question 1" => $question1,
        "Question 2" => $question2,
        "Question 3" => $question3,
        "Submission Time" => $formattedTime,
    ];

    // Вибір формату файлу
    $saveAsJson = true; // Змінити на true для JSON формату

    if ($saveAsJson) {
        // Запис у JSON файл у вигляді стовпчика
        $fileName = $folder . "/survey_" . $timestamp . ".json";
        file_put_contents($fileName, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    } else {
        // Запис у TXT файл у вигляді стовпчика
        $fileName = $folder . "/survey_" . $timestamp . ".txt";
        $fileContent = "";
        foreach ($data as $key => $value) {
            $fileContent .= "{$key}: {$value}\n";
        }
        file_put_contents($fileName, $fileContent);
    }

    // Виведення повідомлення користувачу
    echo "<h1>Дякую за вашу відповідь!</h1>";
    echo "<p>Ваша відповідь була записана {$formattedTime}.</p>";
} else {
    echo "<h1>Invalid Request</h1>";
}
?>