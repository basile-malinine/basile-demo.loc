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
{{-- Модальное окно с формой регистрации --}}
<div id="modalRegForm" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Регистрация</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="loginReg" class="form-label">Логин</label>
                    <input id="loginReg" type="text" class="form-control" name="login" value="{{ old('login')  }}">
                    <span id="loginRegError" class="alert-message text-danger" style="font-size: 12px"></span>
                </div>
                <div class="mb-3">
                    <label for="passwordReg" class="form-label">Пароль</label>
                    <input id="passwordReg" type="password" class="form-control" name="password">
                </div>
                <div class="mb-3">
                    <label for="passwordReg_confirmation" class="form-label">Подтверждение пароля</label>
                    <input id="passwordReg_confirmation" type="password" class="form-control"
                           name="password_confirmation">
                    <span id="passwordRegError" class="alert-message text-danger" style="font-size: 12px"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnSubmitRegForm" type="button" class="btn btn-primary">Подтвердить</button>
            </div>
        </div>
    </div>
</div>

{{-- Модальное окно с формой авторизации --}}
<div id="modalAuthForm" class="modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Авторизация</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="authError" class="alert-message text-danger" style="font-size: 12px"></span>
                <div class="mb-3">
                    <label for="loginAuth" class="form-label">Логин</label>
                    <input id="loginAuth" type="text" class="form-control" name="login" value="{{ old('login')  }}">
                    <span id="loginAuthError" class="alert-message text-danger" style="font-size: 12px"></span>

                </div>
                <div class="mb-3">
                    <label for="passwordAuth" class="form-label">Пароль</label>
                    <input id="passwordAuth" type="password" class="form-control" name="password">
                    <span id="passwordAuthError" class="alert-message text-danger" style="font-size: 12px"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnSubmitAuthForm" type="button" class="btn btn-primary">Войти</button>
            </div>
        </div>
    </div>
</div>

<header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Демо-проект на должность PHP-разработчик</span>
        </div>
        <div class="container-fluid justify-content-center">
            <span id="spanHello" class="navbar-brand d-inline"></span>
        </div>
        <div class="container-fluid justify-content-end">
            <div id="linkRegistration"><a class="navbar-brand d-inline" data-bs-toggle="modal" href="#modalRegForm">Регистрация</a>
            </div>
            <div id="linkLogin"><a class="navbar-brand d-inline" data-bs-toggle="modal" href="#modalAuthForm">Войти</a>
            </div>
            <div id="linkLogout"><a class="navbar-brand d-inline" data-bs-toggle="modal" href="">Выйти</a></div>
        </div>
    </nav>
</header>

<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container">

        <div class="static-text">
            <p>Вопрос о выборе муки для выпечки волнует всех, кто любит собственноручно готовить всякие вкусности.
                Многие считают, что должна быть универсальная мука, подходящая для всех блюд. Муку высшего сорта можно
                считать таковой, но с оговоркой. Ведь диапазон выпекаемых блюд столь широк, что для некоторых видов
                выпечки лучше подходят другие сорта. И если вы хотите, чтобы получалось идеально, то к каждому виду
                выпечки нужен индивидуальный подход.</p>
            <p>На Масленицу всех в первую очередь интересуют, конечно, блины. Это любимое народом блюдо удачно
                получается из многих сортов муки. Но есть такие, из которых блины будут особенно хороши.</p>
        </div>
        <div id="formComment" class="mb-3">
            <textarea id="textComment" placeholder="Оставьте свой комментарий" class="form-control mb-2"
                      rows="3"></textarea>
            <button id="btnAddComment" type="button" class="btn btn-primary">Добавить</button>
        </div>

        <div id="moreContainer" class="row g-2">
            <div class="col-auto">
                <label id="labelInfo" class="col-form-label"></label>
            </div>
            <div class="col-auto">
                <button id="btnMoreComment" type="button" class="btn btn-primary">Показать ещё</button>
            </div>
        </div>
    </div>
</main>


<script src="public/bootstrap-5.1.3-dist/js/bootstrap.min.js"></script>
<script src="public/jquery-3/jquery-3.0.0.min.js"></script>
<script src="public/js/main.js"></script>

</body>
</html>
