<?php
// pages/feedback_process.php
require_once '../includes/db_connect.php';
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Валидация данных
    if (empty($name) || empty($email) || empty($message)) {
        echo "Пожалуйста, заполните все поля.";
        exit;
    }

    // Обработка файла
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $allowed = ['image/jpeg', 'image/png', 'application/pdf'];
        if (in_array($_FILES['attachment']['type'], $allowed)) {
            $uploadDir = '../uploads/';
            $uploadFile = $uploadDir . basename($_FILES['attachment']['name']);
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                // Сохранение в базу данных
                $stmt = $conn->prepare("INSERT INTO feedback (name, email, message, attachment) VALUES (?, ?, ?, ?)");
                if ($stmt === false) {
                    die("Prepare failed: " . $conn->error);
                }

                $stmt->bind_param("ssss", $name, $email, $message, $_FILES['attachment']['name']);
                if ($stmt->execute()) {
                    echo "Сообщение отправлено успешно!";
                } else {
                    echo "Ошибка: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Ошибка при загрузке файла.";
            }
        } else {
            echo "Неподдерживаемый формат файла.";
        }
    } else {
        // Если файл не прикреплен
        $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            echo "Сообщение отправлено успешно!";
        } else {
            echo "Ошибка: " . $stmt->error;
        }

        $stmt->close();
    }
}

require_once '../includes/footer.php';
?>