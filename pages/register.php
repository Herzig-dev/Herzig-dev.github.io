<?php
// pages/register.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Определяем корневую директорию
$rootDir = __DIR__ . '/../';

// Подключаем остальные необходимые файлы
require_once $rootDir . 'includes/db_connect.php';
require_once $rootDir . 'includes/header.php';
?>

<main>
    <h2>Регистрация</h2>
    <form action="register_process.php" method="post">

        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Подтвердите пароль:</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>
        <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
    </form>
</main>

<?php
require_once ROOT_DIR . 'includes/footer.php';
?>