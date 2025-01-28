<?php
// index.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '/whitesoft/includes/config.php';
require_once '/whitesoft/includes/db_connect.php';
require_once '/whitesoft/includes/header.php';


// Обработка отправки формы (оставьте без изменений)
$feedbackSuccess = false;
$feedbackError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feedback_submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $attachment = $_FILES['attachment'] ?? null;

    // Валидация данных
    if (empty($name) || empty($email) || empty($message)) {
        $feedbackError = "Пожалуйста, заполните все поля.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $feedbackError = "Пожалуйста, введите корректный email.";
    } else {
        // Обработка файла
        if ($attachment && $attachment['error'] == 0) {
            $allowed = ['image/jpeg', 'image/png', 'application/pdf'];
            if (in_array($attachment['type'], $allowed)) {
                $uploadDir = ROOT_DIR . 'uploads/';
                $uploadFile = $uploadDir . basename($attachment['name']);
                if (move_uploaded_file($attachment['tmp_name'], $uploadFile)) {
                    // Сохранение в базу данных
                    $stmt = $conn->prepare("INSERT INTO feedback (name, email, message, attachment) VALUES (?, ?, ?, ?)");
                    if ($stmt === false) {
                        die("Prepare failed: " . $conn->error);
                    }

                    $stmt->bind_param("ssss", $name, $email, $message, $attachment['name']);
                    if ($stmt->execute()) {
                        $feedbackSuccess = true;
                    } else {
                        $feedbackError = "Ошибка: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    $feedbackError = "Ошибка при загрузке файла.";
                }
            } else {
                $feedbackError = "Неподдерживаемый формат файла.";
            }
        } else {
            // Если файл не прикреплен
            $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
            if ($stmt === false) {
                die("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param("sss", $name, $email, $message);
            if ($stmt->execute()) {
                $feedbackSuccess = true;
            } else {
                $feedbackError = "Ошибка: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feedback_submit'])) {
    // Логика обработки формы (оставьте без изменений)
}


// Данные для новостей
$news = [
    [
        'title' => 'Новая версия продукта',
        'description' => 'Мы рады сообщить о выпуске новой версии нашего флагманского продукта. В этой версии добавлены новые функции и улучшена производительность.',
        'date' => '2025-01-15'
    ],
    [
        'title' => 'Партнерство с ведущими компаниями',
        'description' => 'WhiteSoft заключила партнерские соглашения с несколькими ведущими компаниями в области технологий. Это позволит нам расширить наши возможности и предложить более широкий спектр услуг.',
        'date' => '2024-09-20'
    ],
    [
        'title' => 'Курсы и тренинги',
        'description' => 'Мы запускаем серию курсов и тренингов для наших клиентов и партнеров. Эти курсы помогут вам лучше понять наши продукты и использовать их максимально эффективно.',
        'date' => '2024-08-10'
    ],
];
?>

<main>
    <div class="container">
        <!-- Основной контент -->
        <h2>О компании WhiteSoft</h2>
        <p>WhiteSoft — это динамично развивающаяся компания, специализирующаяся на разработке программного обеспечения для различных отраслей. Мы предоставляем инновационные решения, которые помогают нашим клиентам достигать их бизнес-целей.</p>

        <h3>Наши последние новости</h3>
        <div class="row">
            <?php foreach ($news as $item): ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($item['description']); ?></p>
                            <p class="card-text"><small class="text-muted">Дата: <?php echo htmlspecialchars($item['date']); ?></small></p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newsModal<?php echo $item['title']; ?>">
                                Подробнее
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Модальное окно для каждой новости -->
                <div class="modal fade" id="newsModal<?php echo $item['title']; ?>" tabindex="-1" aria-labelledby="newsModalLabel<?php echo $item['title']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="newsModalLabel<?php echo $item['title']; ?>"><?php echo htmlspecialchars($item['title']); ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><?php echo htmlspecialchars($item['description']); ?></p>
                                <p><small class="text-muted">Дата: <?php echo htmlspecialchars($item['date']); ?></small></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        

      <!-- Форма обратной связи -->
      <section class="feedback-section">
            <h3>Форма обратной связи</h3>
            <?php if ($feedbackSuccess): ?>
                <div class="alert alert-success" role="alert">
                    Ваше сообщение успешно отправлено!
                </div>
            <?php elseif ($feedbackError): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($feedbackError); ?>
                </div>
            <?php endif; ?>
            <form action="index.php" method="post" enctype="multipart/form-data">
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
                <button type="submit" name="feedback_submit" class="btn btn-primary">Отправить</button>
            </form>
        </section>
    </div>
</main>

<?php
require_once ROOT_DIR . 'includes/footer.php';
?>
