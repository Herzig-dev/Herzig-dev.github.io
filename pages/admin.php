<?php
// admin.php
require_once '../includes/db_connect.php';
require_once '../includes/header.php';

if ($_SESSION['role'] != 'admin') {
    echo "У вас нет доступа к этой странице.";
    exit;
}

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

?>

<main>
    <h2>Админка</h2>
    <h3>Пользователи</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Дата регистрации</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Сообщения</h3>
    <?php
    $sql = "SELECT messages.id, users.username, messages.message, messages.file_path, messages.created_at FROM messages JOIN users ON messages.user_id = users.id";
    $result = $conn->query($sql);
    ?>

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
</main>

<?php
require_once '../includes/footer.php';
?>