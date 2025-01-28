<?php
// pages/admin_users.php
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

// Пагинация
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// Получаем общее количество пользователей
$stmtCount = $conn->prepare("SELECT COUNT(*) FROM users");
if ($stmtCount === false) {
    die("Prepare failed: " . $conn->error);
}
$stmtCount->execute();
$stmtCount->bind_result($total);
$stmtCount->fetch();
$total_pages = ceil($total / $limit);
$stmtCount->close(); // Освобождаем ресурсы

// Получаем список пользователей с пагинацией
$stmt = $conn->prepare("SELECT id, username, email, created_at FROM users LIMIT ? OFFSET ?");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();

// Получаем результат
$result = $stmt->get_result();
?>
<main>
    <div class="container">
        <h2>Управление пользователями</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя пользователя</th>
                    <th>Email</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                        <td>
                            <a href="admin_edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Редактировать</a>
                            <a href="admin_delete_user.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="page-item"><a class="page-link" href="admin_users.php?page=<?php echo $page - 1; ?>">Предыдущая</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="admin_users.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item"><a class="page-link" href="admin_users.php?page=<?php echo $page + 1; ?>">Следующая</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</main>

<?php
$stmt->close(); // Освобождаем ресурсы
require_once '../includes/admin/footer_admin.php';
?>