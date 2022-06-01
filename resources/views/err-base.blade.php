<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PHP - Тестовое задание</title>

    <link href="public/bootstrap-5.1.3-dist/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/main.css">

</head>
<body class="d-flex flex-column h-100">
<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container">

        <div class="static-text">
            <h2 class="text-center">Демо-проект на вакансию PHP-разработчик</h2>
            <br>
            <h5>Суть задачи:</h5>
            <p>Реализовать страницу с комментариями к произвольному статичному тексту.</p>
            <h5>Детали:</h5>
            <ul>
                <li>Реализовать добавление комментария, оно должно происходить без перезагрузки страницы. Новый комментарий должен быть отображён на странице сразу после добавления.</li>
                <li>Изначально показывать 3 комментария, остальные должны подгружаться (3 за один раз) по нажатию на кнопку “Показать ещё”.</li>
                <li>Страница должна быть защищена авторизацией. Неавторизованному пользователю доступен только просмотр. Логин и пароль должны храниться в БД</li>
            </ul>
        </div>

        <div class="static-text">
            <h5>Для реализации использовал:</h5>
            <ul>
                <li>PHP 8</li>
                <li>Laravel 9</li>
                <li>Bootstrap 5</li>
                <li>JavaScript + jQuery 3</li>
                <li>MySQL 8</li>
                <li>WEB-сервер Apache 2.4</li>
            </ul>
            <h5>Корневой WEB-каталог:</h5>
            <p class="fw-bold">basile-demo.loc/</p>
        </div>

        <div class="static-text">
            <h5 class="text-danger">Для запуска приложения необходимо:</h5>
            <ul>
                <li>Создать на сервере MySQL БД с произвольным названием</li>
                <li>Отредактироваь файл <span class="fw-bold">basile-demo.loc/.env</span> на предмет настроек MySQL</li>
                <ul>
                    <li>DB_DATABASE=</li>
                    <li>DB_USERNAME=</li>
                    <li>DB_PASSWORD=</li>
                </ul>
                <li>Применить миграции <span class="fw-bold">php artisan migrate</span></li>
            </ul>
        </div>

    </div>
</main>


<script src="public/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
<script src="public/jquery-3/jquery-3.0.0.min.js"></script>
<script src="public/js/main.js"></script>

</body>
</html>
