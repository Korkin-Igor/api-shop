<h3>REST API для интернет магазина "Просто купить"</h3>
___
<br>
Этот проект представляет собой REST API на Laravel 11 с использованием PostgreSQL, Docker и Nginx.  
Всё окружение запускается через `docker-compose`.
<br><br>
<h4>Инструкция по запуску</h4>
<ol>
    <li>
        Скачайте репозиторий
    </li>
    <li>
        Убедитесь, что на вашем компьютере установлен Docker и запустите его.
    </li>
    <li>
        Создайте в <i>api-shop/deploy</i> и в <i>api-shop/project</i> файл <i>.env</i>,
        заполните эти файлы по шаблону из <i>.env.example</i> в тех же папках.
    </li>
    <li>
        Перейдите в терминале в папку <i>deploy</i> через команду <b><i>cd deploy</i></b>.
    </li>
    <li>
        Введите в терминал <b><i>docker login -u "ваш_юзернейм" -p "ваш_пароль"</i></b> и 
        авторизуйтесь на docker hub (для установки базовых образов). При успешной авторизации
        в терминале высветится "Login Successed".
    </li>
    <li>
        Через команду <b><i>docker-compose up -d --build</i></b> запустите docker-compose.
    </li>
    <li>
        Далее нужно накатить миграции, используя в терминале команду
        <b><i>docker exec -it laravel-shop-app php artisan migrate:fresh --seed</i></b>.
    </li>
    <li>
        Готово! Теперь проект доступен по адресу <i>http://localhost</i> <br>
        Adminer доступен по адресу <i>http://localhost:8080</i>
    </li>
    <li>
        Чтобы остановить и удалить контейнеры введите команду <i><b>docker-compose down</b></i>
    </li>
</ol>