<?php
define('URL', 'http://localhost:8080'); // URL текущей страницы
define('UPLOAD_DIR', 'uploads');
define('COMMENT_DIR', 'comments');

$errors = [];

$imageFileName = $_GET['name'];
$commentFilePath = COMMENT_DIR . '/' . $imageFileName . '.txt';

// Если была отправлена форма
if(!empty($_POST['comment'])) {

    $comment = trim($_POST['comment']);

    // Валидация коммента
    if(!$comment) {
        $errors[] = 'Вы не ввели текст комментария';
    }

    // Если нет ошибок записываем коммент
    if(empty($errors)) {
        file_put_contents($commentFilePath, $comment, FILE_APPEND);
    }
}

// Получаем список коммантов
$comments = file_exists($commentFilePath)
    ? file($commentFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)
    : [];

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Галерея изображений | Файл <?php echo $imageFileName; ?></title>
</head>
<body>


<div class="container pt-4">

    <div class="row">
        <div class="col-12 col-sm-6 offset-sm-3">
            <a href="<?php echo URL;  ?>">&larr; Главная</a>
            <h1 class="mb-4">Файл <?php echo $imageFileName; ?></h1>

            <!-- Вывод сообщений об успехе/ошибке -->
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!empty($_POST['comment']) && empty($errors)): ?>
                <div class="alert alert-success">Комментарий успешно добавлен</div>
            <?php endif; ?>

            <img src="<?php echo URL . '/' . UPLOAD_DIR . '/' . $imageFileName ?>" class="img-thumbnail mb-4"
                 alt="<?php echo $imageFileName ?>">

            <h3>Комментарии</h3>

            <?php if(!empty($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                    <p><?php echo $comment; ?></p>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">Пока ни одного коммантария, будте первым!</p>
            <?php endif; ?>



            <!-- Форма добавления комментария -->
            <form method="post">
                <div class="form-group">
                    <label for="comment">Ваш комментарий</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>

        </div>
    </div>


</div><!-- /.container -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
</body>
</html>
