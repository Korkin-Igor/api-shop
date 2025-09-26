<h3>REST API для интернет магазина "Просто купить"</h3>
___
<br>
Этот проект представляет собой REST API на Laravel 11, PostgreSQL, Docker и Nginx.  
Всё окружение запускается через `docker compose`.
<br><br>
<h4>Инструкция по запуску</h4>
<ol>
    <li>
        Скачайте репозиторий <code>git clone -b dev --single-branch git@github.com:Korkin-Igor/api-shop.git</code>
    </li>
    <li>
        Убедитесь, что на вашем компьютере установлен Docker и запустите его.
    </li>
    <li>
        Убедитесь, что в терминале вы в папке проекта /api-shop/ <br>
        Создайте файлы с переменными окружения (.env) командами <br>
        <code>cp project/.env.example project/.env</code> <br>
        <code>cp deploy/.env.example deploy/.env</code> <br>
        Заполните их.
    </li>
    <li>
        Перейдите в терминале в папку <i>deploy</i> командой <code>cd deploy</code>.
    </li>
    <li>
        Убедитесь, что вы авторизованы в DockerHub. Если нет, тогда сделайте это командой <br> <code>docker login -u "ваш_юзернейм" -p "ваш_пароль"</code> и 
        авторизуйтесь на DockerHub (для установки базовых образов). При успешной авторизации
        в терминале высветится "Login Successed".
    </li>
    <li>
        Через команду <code>docker compose up -d --build</code> запустите <i>docker compose</i>.
    </li>
    <li>
        Создайте структуру БД, заполненную тестовыми данными командой <code>docker compose exec app php artisan migrate --seed</code>.
    </li>
    <li>
        Сгенерируйте ключ приложения командой <code>docker compose exec app php artisan key:generate</code>.
    </li>
    <li>
        Готово! Теперь проект доступен по адресу <a link="http://localhost:8000">localhost:8000</a> <br>
        Adminer доступен по адресу <a link="http://localhost:8080">localhost:8080</a>.
    </li>
    <li>
        Чтобы остановить контейнеры введите команду <code>docker compose down</code>.
    </li>
</ol>