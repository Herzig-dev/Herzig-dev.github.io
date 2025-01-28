<?php
// pages/admin_messages.php
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

$stmt = $conn->query("SELECT id, name, email, message, attachment, created_at FROM feedback");
?>

<main>
    <div class="container">
        <h2>Управление сообщениями обратной связи</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Сообщение</th>
                    <th>Вложение</th>
                    <th>Дата</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['message']); ?></td>
                        <td>
                            <?php if ($row['attachment']): ?>
                                <a href="../uploads/<?php echo htmlspecialchars($row['attachment']); ?>" target="_blank">Скачать</a>
                            <?php else: ?>
                                Нет вложения
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <a href="admin_delete_message.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить это сообщение?');">Удалить</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
require_once '../includes/admin/footer_admin.php';
?>