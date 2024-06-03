<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Безымянный' ?></title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<div class="flex">
<div class="glass">
<h1><?= isset($page_title) ? $page_title : 'Безымянный' ?></h1>
<div id="errors"><?= isset($page_errors) ? $page_errors : '' ?></div>
<?= isset($page_content) ? $page_content : '' ?>
</div>
</div>
</body>
</html>