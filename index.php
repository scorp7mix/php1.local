<?php
// Запуск сессии, проверка ошибок и логов удачных добавлений
session_start();
$errors = !empty($_SESSION['errors']) ? $_SESSION['errors'] : [];
unset($_SESSION['errors']);
$logs = !empty($_SESSION['logs']) ? $_SESSION['logs'] : [];
unset($_SESSION['logs']);
// Переменные путей к папке с картинками, абсолютный и относительно сервера
$imgPath = __DIR__ . '/img/';
if (!file_exists($imgPath)) {
    echo "<h2>Critical error - can't read from gallery path!</h2>";
    exit;
}
$serverImgPath = '/img/';
// Массив расшифровок сообщений об ошибках
$fileUploadErrors = [
    1 => 'Загружаемый файл превысил размер, допустимый настройками PHP',
    2 => 'Загружаемый файл превысил размер, допустимый директивой формы HTML',
    3 => 'Загружаемый файл не был полностью загружен',
    4 => 'Нет файла для загрузки',
    6 => 'Временная папка для загрузки недоступна',
    7 => 'Ошибка при записи файла на диск',
    8 => 'Одно из расширений PHP остановило загрузку файла',
];
// Допустимые расширения файлов для галереи
$allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
// Функция для получения расширения файла
function getFileExt($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}

// Функция для получения имени файла
function getFileName($file)
{
    return pathinfo($file, PATHINFO_FILENAME);
}

// Функция проверки имени файла. Изменяет целевое имя, если такое уже есть.
function checkFileName($file)
{
    if (file_exists($file)) {
        $_SESSION['logs'][] = "Такой файл уже есть:" . basename($file);
        $add = 0;
        $path = dirname(realpath($file)) . '/';
        $fileName = getFileName($file);
        $fileExt = getFileExt($file);
        do {
            $file = $path . $fileName . '_' . (++$add) . '.' . $fileExt;
        } while (file_exists($file));
    }
    $_SESSION['logs'][] = "Скорректированное имя файла: " . basename($file);
    return $file;
}

// Функция создает массив имен картинок по заданной директории и массиву разрешенных расширений
function getImageNames($imgPath, $allowedExtensions)
{
    $workDir = scandir($imgPath);
    $imgFiles = [];
    foreach ($workDir as $el) {
        if (is_file($imgPath . $el) && in_array(getFileExt($el), $allowedExtensions)) {
            $imgFiles[] = $el;
        }
    }
    return $imgFiles;
}

// Обработка массива $_FILES при запросе добавления файлов через форму
if (isset($_POST['upload_form'])) {
    $files = $_FILES['upload'];
    foreach ($files['error'] as $key => $error) {
        $fileName = $files['name'][$key];
        $fileTmpName = $files['tmp_name'][$key];
        if (is_uploaded_file($fileTmpName) && (UPLOAD_ERR_OK == $error)) {
            $newFile = $imgPath . basename($fileName);
            if (in_array(getFileExt($newFile), $allowedExtensions)) {
                $newFile = checkFileName($newFile);
                if (move_uploaded_file($fileTmpName, $newFile)) {
                    $_SESSION['logs'][] = "Файл " . basename($newFile) . " загружен в галерею";
                } else {
                    $_SESSION['errors'][] = "Файл " . basename($newFile) . " загрузить в галерею не удалось";
                }
            } else {
                $_SESSION['errors'][] = "Формат файла " . basename($newFile) . " не подходит для загрузки";
            }
        } else {
            $fileError = isset($fileUploadErrors[$error]) ? $fileUploadErrors[$error] : "Загрузить не удалось по неизвестной причине";
            $_SESSION['errors'][] = 'Ошибка при загрузке файла ' . $fileName . ': ' . $fileError;
        }
    }
    header('location: /index.php');
}
?>
<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="/css/main.css">
</head>
<body>
<h3>Вы можете добавить свое изображение</h3>

<form action="/index.php" method="post" enctype="multipart/form-data">
    <label for="file">Имя файла для загрузки:</label>
    <input id="file" type="file" name="upload[]" multiple><br><br>
    <input type="submit" name="upload_form" value="Загрузить файл в галлерею">
</form>

<?php
if (!empty($errors)) {
    // Вывод найденных ошибок.
    echo "<p class=\"error\">Сообщения об ошибках:</p>";
    foreach ($errors as $e) {
        echo "<p class=\"error\"> - " . $e . "</p>";
    }
}
if (!empty($logs)) {
    // Вывод логов.
    echo "<p class=\"log\">Сообщения о выполненных операциях:</p>";
    foreach ($logs as $l) {
        echo "<p class=\"log\"> - " . $l . "</p>";
    }
}
?>

<h1>Галерея изображений</h1>
<?php

foreach (getImageNames($imgPath, $allowedExtensions) as $img) {
    ?>
    <div class="gallery_img">
        <img src="<?php echo $serverImgPath . $img; ?>" title="<?php echo basename($img); ?>">
    </div>
<?php
}

echo empty(getImageNames($imgPath, $allowedExtensions)) ? "<h2>Изображений пока нет</h2>" : '';
?>

</body>
</html>