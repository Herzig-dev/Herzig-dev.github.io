<?php
// includes/admin/messages.php
require_once '../includes/admin/header_admin.php';
require_once '../includes/db_connect.php';

$stmt = $conn->query("SELECT id, name, email, message, attachment FROM feedback");
?>
<main>
    <h2>Сообщения пользователей</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Email</th>
                <th>Сообщение</th>
                <th>Вложение</th>
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
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
<?php
require_once '../includes/admin/footer_admin.php';
?>