<?php
// pages/admin_login.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db_connect.php';
require_once '../includes/header.php'; // Исправлено: добавлена точка с запятой

// Проверка, что форма была отправлена
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Получение данных администратора
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // Установка сессии
            session_start(); // Исправлено: перемещено внутрь условия
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_username'] = $username;
            header("Location: admin_users.php");
            exit;
        } else {
            echo "Неверный пароль.";
        }
    } else {
        echo "Администратор не найден.";
    }

    $stmt->close();
}
?>

<main>
    <div class="container">
        <h2>Вход для администратора</h2>
        <form action="admin_login.php" method="post">
            <div class="form-group">
                <label for="username">Имя пользователя:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
</main>

<?php
require_once '../includes/footer.php';
?>