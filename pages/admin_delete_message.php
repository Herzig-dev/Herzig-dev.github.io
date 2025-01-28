<?php
// pages/admin_delete_message.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db_connect.php';
require_once '../includes/admin/header_admin.php';

// Проверка авторизации
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

// Проверка наличия параметра id
if (!isset($_GET['id'])) {
    echo "Неверный запрос.";
    exit;
}

$message_id = intval($_GET['id']);

// Удаление сообщения
$stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $message_id);

if ($stmt->execute()) {
    echo "Сообщение успешно удалено.";
} else {
    echo "Ошибка при удалении сообщения: " . $stmt->error;
}

$stmt->close();
require_once '../includes/admin/footer_admin.php';
?>