<?php
// messages.php
require_once '../includes/db_connect.php';
require_once '../includes/header.php';

$sql = "SELECT messages.id, users.username, messages.message, messages.file_path, messages.created_at FROM messages JOIN users ON messages.user_id = users.id";
$result = $conn->query($sql);

?>

<main>
    <h2>Все сообщения</h2>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Сообщение</th>
                <th>Файл</th>
                <th>Дата</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
                    <td>
                        <?php if ($row['file_path']): ?>
                            <a href="<?php echo htmlspecialchars($row['file_path']); ?>" download>Скачать</a>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Нет сообщений.</p>
    <?php endif; ?>
</main>

<?php
require_once '../includes/footer.php';
?>