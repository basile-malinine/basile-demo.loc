//Класс описывает контейнер для вывода комментария
class Comment {
    constructor() {
        this.divContainer = document.createElement('div');
        this.divContainer.classList.add('comment');
        this.divHeader = document.createElement('div');
        this.divHeader.classList.add('comment-header');
        this.divUser = document.createElement('div');
        this.divUser.classList.add('comment-user');
        this.divTime = document.createElement('div');
        this.divTime.classList.add('comment-time');
        this.divBody = document.createElement('div');
        this.divBody.classList.add('comment-body');
        this.divHeader.appendChild(this.divUser);
        this.divHeader.appendChild(this.divTime);
        this.divContainer.appendChild(this.divHeader);
        this.divContainer.appendChild(this.divBody);
    }

    // Свойства класса. Устанавливают текст для Автора, Времени и Контента

    set id(str) {
        this.divContainer.setAttribute('id', str);
    }

    set user(str) {
        this.divUser.innerText = str;
    }

    set time(str) {
        this.divTime.innerText = str;
    }

    set content(str) {
        this.divBody.innerText = str;
    }
}

// Вывод в броузер нового комментария (по кнопке <Добавить>)
function outNewComment(id, user, time, content) {
    let comm = new Comment();
    comm.id = id;
    comm.content = content;
    comm.user = user;
    comm.time = time;
    $('#formComment').after(comm.divContainer);
}

// Вывод в броузер очередного комментария (по кнопке <Показать ещё>)
function outMoreComment(id, user, time, content) {
    let comm = new Comment();
    comm.id = id;
    comm.content = content;
    comm.user = user;
    comm.time = time;
    $('#moreContainer').before(comm.divContainer);
}

// Обновление интерфейса
function updateInterface(info) {
    // Проверка пользователя
    if (info.user.id) {
        $('#spanHello').text('Привет, ' + info.user.login + '!');
        $('#linkRegistration').hide();
        $('#linkLogin').hide();
        $('#linkLogout').show();
        $('#textComment')
            .attr('disabled', false)
            .attr('placeholder', 'Оставьте комментарий.');
        $('#btnAddComment').attr('disabled', false);
    } else {
        $('#spanHello').text('Привет, Гость!');
        $('#linkRegistration').show();
        $('#linkLogin').show();
        $('#linkLogout').hide();
        $('#textComment')
            .attr('disabled', true)
            .attr('placeholder', 'Авторизуйтесь, чтобы оставить комментарий.');
        $('#btnAddComment').attr('disabled', true);
    }

    // Инфо-строка о показанных записях (типа 13/74)
    cnt = info.db.count;
    offset = info.db.offset;
    $('#labelInfo').text(offset + '/' + cnt);

    // Проверка базы данных
    if (cnt && offset < cnt) {
        $('#labelInfo').show();
        $('#btnMoreComment').show();
    } else if (cnt == 0) {
        $('#labelInfo').hide();
        $('#btnMoreComment').hide();
    } else if (cnt == offset) {
        $('#labelInfo').show();
        $('#btnMoreComment').hide();
    }
}

// Отправляет новый комментарий в базу
function sendComment() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: '/comment/add',
        type: 'POST',
        data: {
            textComment: $('#textComment').val(),
        },
        success: function (response) {
            // Выводим в браузер новый комментарий и обновляем info
            response.records.map(rec => {
                outNewComment(rec.id, rec.user, rec.time, rec.content);
            })

            // Очищаем TextArea
            $('#textComment').val('');

            updateInterface(response.info);
        },
    });
}

// Получает очередную порцию записей из базы
function getComments(noScroll = false) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: '/comment/more',
        type: 'POST',
        success: function (response) {
            if (noScroll)
                $('.comment').remove();

            // Выводим в браузер комментарии и обновляем info
            response.records.map(rec => {
                outMoreComment(rec.id, rec.user, rec.time, rec.content);
            })

            updateInterface(response.info);

            if (noScroll)
                return;

            let id = '#' + response.records[0].id;
            $('html, body').animate({
                scrollTop: $(id).offset().top
            }, 100);
        },
        error: function (response) {
            console.log(response);
            console.log(response.info);
        },
    });
}

// Отправка данных из формы регистрации
function sendRegData() {
    let _token = $('meta[name="csrf-token"]').attr('content');
    $('#loginRegError').text('');
    $('#passwordRegError').text('');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': _token,
        },
        url: '/user/register',
        type: 'POST',
        data: {
            login: $('#loginReg').val(),
            password: $('#passwordReg').val(),
            password_confirmation: $('#passwordReg_confirmation').val(),
            _token: _token,
        },
        success: function (response) {
            $('#modalRegForm').modal('hide');
            $('#loginReg').val('');
            $('#passwordReg').val('');
            $('#passwordReg_confirmation').val('');

            getComments(true);
        },
        error: function (response) {
            $('#loginRegError').text(response.responseJSON.errors.login);
            $('#passwordRegError').text(response.responseJSON.errors.password);
            $('#passwordReg').val('');
            $('#passwordReg_confirmation').val('');
        }
    });
}

// Выполнение авторизации
function login() {
    let _token = $('meta[name="csrf-token"]').attr('content');
    $('#authError').text('');
    $('#loginAuthError').text('');
    $('#passwordAuthError').text('');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: '/user/login',
        type: 'POST',
        data: {
            login: $('#loginAuth').val(),
            password: $('#passwordAuth').val(),
            _token: _token,
        },
        success: function (response) {
            if (response.info.user.id === 0) {
                $('#passwordAuth').val('');
                $('#authError').text('Не верный Логин или Пароль!');
                return;
            }
            $('#modalAuthForm').modal('hide');
            $('#loginAuth').val('');
            $('#passwordAuth').val('');

            getComments(true);
        },
        error: function (response) {
            $('#authError').text('Все поля обязательны к заполнению!');
            $('#passwordAuth').text('');
        }
    });
}

// Выход из системы
function logout() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        url: '/user/logout',
        type: 'POST',
        success: function (response) {
            getComments(true);
        },
    });
}
    window.addEventListener('pageshow', function () {
        getComments(true);
    });

$(document).ready(function () {

    // Первые три комментария при загрузке страницы

    // Обработчик кнопки <Добавить>
    $('#btnAddComment').on('click', function (e) {
        e.preventDefault();
        // Проверка на пустой комментарий
        if ($('#textComment').val().trim() === '')
            return;
        sendComment();
    });

    // Обработчик кнопки <Показать ещё>
    $('#btnMoreComment').on('click', function (e) {
        e.preventDefault();
        getComments();
    });

    // Обработчик кнопки <Подтвердить> (форма Регистрация)
    $('#btnSubmitRegForm').on('click', function (e) {
        e.preventDefault();
        sendRegData();
    });

    // Обработчик ссылки <Войти>
    $('#btnSubmitAuthForm').on('click', function (e) {
        e.preventDefault();
        login();
    });

    // Обработчик ссылки <Выйти>
    $('#linkLogout').on('click', function (e) {
        e.preventDefault();
        logout();
    });


});

