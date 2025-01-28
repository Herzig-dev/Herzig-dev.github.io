<?php
// pages/login.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных
require_once '../includes/db_connect.php';

// Проверяем, не активна ли уже сессия
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Обработка отправки формы
$loginSuccess = false;
$loginError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Получение данных пользователя
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword, $role);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            // Установка сессии
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            $loginSuccess = true;

            // Перенаправление
            header("Location: /whitesoft/index.php");
            exit;
        } else {
            $loginError = "Неверный пароль.";
        }
    } else {
        $loginError = "Пользователь не найден.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - WhiteSoft</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Вход</h2>
        <?php if ($loginSuccess): ?>
            <div class="alert alert-success" role="alert">
                Вы успешно вошли в систему.
            </div>
        <?php elseif ($loginError): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($loginError); ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
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
</body>
</html>