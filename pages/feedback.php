<?php
// pages/feedback.php
require_once '../includes/header.php';
?>
<main>
    <h2>Форма обратной связи</h2>
    <form action="feedback_process.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Имя:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">Сообщение:</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="attachment">Прикрепить файл:</label>
            <input type="file" class="form-control-file" id="attachment" name="attachment">
        </div>
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
</main>
<?php
require_once '../includes/footer.php';
?>