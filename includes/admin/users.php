<?php
// includes/admin/users.php
require_once '../includes/admin/header_admin.php';
require_once '../includes/db_connect.php';

$stmt = $conn->query("SELECT id, username, email FROM users");
?>
<main>
    <h2>Пользователи</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя пользователя</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
<?php
require_once '../includes/admin/footer_admin.php';
?>