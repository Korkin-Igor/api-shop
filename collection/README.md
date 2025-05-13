<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Документация к Postman-коллекции</title>
    <meta charset="UTF-8">
    <style>
        li {
            font-size: 0.83em;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h3>Документация к Postman-коллекции</h3>
___
<br>
Здесь описана инструкция пользования приложением <b>api-shop</b>, которое
представляет собой REST API для интернет-магазина "Просто купить".

<br>
<h4>Инструкция по использованию</h4>

API доступно по адресу <i>http://localhost/api-shop</i>, 
ниже будет использоваться переменная {{host}}, обозначающая этот адрес;<br>

Все ответы возвращаются в формате JSON; <br>

Есть 3 типа пользователей:
<ol>
    <li>Гость</li>
    <li>Клиент</li>
    <li>Администратор</li>
</ol>

Авторизация пользователя происходит с помощью токена; <br>

Просмотр списка товаров доступен всем,
все остальные эндпоинты соответствуют только определённой группе лиц; <br>

<h5>Наиболее распространенные ошибки:</h5>
<ol>

<li>
При попытке доступа к защищенным авторизацией функциям системы
во всех запросах возвращается ответ вида: <br>
Статус: 403 <br>
Тело: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Login failed" <br>
} <br>
</li>

<li>
При попытке доступа авторизованным пользователем к функциям
недоступным для своей группы во всех запросах возвращается ответ вида: <br>
Статус: 403 <br>
Тело: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Forbidden for you" <br>
} <br>
</li>

<li>
При попытке получить несуществующий ресурс возвращается ответ вида: <br>
Статус: 404 <br>
Тело: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Not found" <br>
} <br>
</li>

<li>
В случае ошибок связанных с валидацией данных во всех запросах возвращается ответ вида: <br>
Статус: 422 <br>
Тело: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Validation error", <br>
    &nbsp&nbsp&nbsp&nbsp "field_1": "Validation error", <br>
    &nbsp&nbsp&nbsp&nbsp ... <br>
} <br>
</li>

</ol>

<h3>Эндпоинты</h3>

<h4>Для гостя</h4>
<ol>

<li><h5>Просмотр списка товаров (доступно всем):</h5>
Адрес: {{host}}/products <br>
Метод: GET <br>
Авторизация: - <br>
Тело запроса: пустое <br>
*Успех*: <br>
Статус ответа: 200 <br>
Тело ответа: двумерный массив с информацией о товарах (id, name, description, price) <br>
</li>

<li><h5>Аутентификация:</h5>
Адрес: {{host}}/login <br>
Метод: POST <br>
Авторизация: - <br>
Тело запроса: массив вида <br> 
{ <br>
    &nbsp&nbsp&nbsp&nbsp "email": "ваша_эл_почта", <br> 
    &nbsp&nbsp&nbsp&nbsp "password": "ваш_пароль"  <br> 
} <br>
*Успех*: <br>
Статус ответа: 200 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "user_token": "сгенерированный_токен" <br>
} <br>
*Неправильный логин или пароль*: <br>
Статус: 401 <br>
Тело: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "password": "Auth failed" <br>
} <br>
</li>

<li><h5>Регистрация:</h5>
Адрес: {{host}}/signup <br>
Метод: POST <br>
Авторизация: - <br>
Тело запроса: массив вида <br> 
{ <br>
    &nbsp&nbsp&nbsp&nbsp "fio": "ваше_ФИО", <br> 
    &nbsp&nbsp&nbsp&nbsp "email": "ваша_эл_почта", <br> 
    &nbsp&nbsp&nbsp&nbsp "password": "ваш_пароль"  <br> 
} <br>
*Успех*: <br>
Статус ответа: 201 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "user_token": "сгенерированный_токен" <br>
} <br>
*Ошибка валидации*: смотрите выше <br>
</li>

</ol>

<h4>Для клиента</h4>
<ol>

<li><h5>Добавление товара в корзину:</h5>
Адрес: {{host}}/cart/{product_id} <br>
Метод: POST <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: пустое <br>
*Успех*: <br>
Статус ответа: 201 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Product add to card" <br>
} <br>
*Товар не найден*: смотрите выше<br>
Примечание: вместо {product_id} идентификатор товара <br>
</li>

<li><h5>Просмотр своей корзины:</h5>
Адрес: {{host}}/cart <br>
Метод: GET <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: пустое <br>
*Успех*: <br>
Статус ответа: 200 <br>
Тело ответа: двумерный массив с информацией о товарах в корзине (id, product_id, name, description, price) <br>
Примечание: "id" - идентификатор товара в корзине, а "product_id" - идентификатор товара <br>
</li>

<li><h5>Удаление товара из корзины:</h5>
Адрес: {{host}}/cart/{id} <br>
Метод: DELETE <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: пустое <br>
*Успех*: <br>
Статус ответа: 200 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Item removed from cart" <br>
} <br>
*Попытка удалить товар не из своей корзины*: <br>
Статус ответа: 403 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Forbidden for you" <br>
} <br>
Примечание: вместо {id} идентификатор товара в корзине <br>
</li>

<li><h5>Оформления заказа:</h5>
Адрес: {{host}}/order <br>
Метод: POST <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: пустое <br>
*Успех*: <br>
Статус ответа: 201 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "order_id": "номер_заказа", <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Order is processed" <br>
} <br>
*Попытка оформить заказ с пустой корзиной*
Статус ответа: 422 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Cart is empty" <br>
} <br>
</li>

<li><h5>Просмотр своих оформленных заказов:</h5>
Адрес: {{host}}/order <br>
Метод: GET <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: пустое <br>
*Успех*: <br>
Статус ответа: 200 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp [ <br>
    &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp "id": "номер_заказа", <br>
    &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp "products": ["ид_товара", ...], <br>
    &nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp "order_price": "общая_стоимость_заказа" <br>
    &nbsp&nbsp&nbsp&nbsp ], <br>
    &nbsp&nbsp&nbsp&nbsp [ <br>
    &nbsp&nbsp&nbsp&nbsp ... <br>
    &nbsp&nbsp&nbsp&nbsp ], <br>
    &nbsp&nbsp&nbsp&nbsp ... <br>
} <br>
</li>

<li><h5>Выход:</h5>
Адрес: {{host}}/logout <br>
Метод: GET <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: пустое <br>
*Успех*: <br>
Статус ответа: 200 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "logout" <br>
} <br>
</li>

</ol>

<h4>Для админа</h4>
<ol>

<li><h5>Добавление нового товара:</h5>
Адрес: {{host}}/product <br>
Метод: POST <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "name": "Product name 3", <br>
    &nbsp&nbsp&nbsp&nbsp "description": "Product description 3", <br>
    &nbsp&nbsp&nbsp&nbsp "price": 300 <br>
} <br>
*Успех*: <br>
Статус ответа: 201 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "id": "ид_нового_товара", <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Product added" <br>
} <br>
*Ошибка валидации полей*: смотрите выше <br>
</li>

<li><h5>Удаление товара:</h5>
Адрес: {{host}}/product/{id} <br>
Метод: DELETE <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: пустое <br>
*Успех*: <br>
Статус ответа: 200 <br>
Тело ответа: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "message": "Product removed" <br>
} <br>
Примечание: вместо {id} пишите идентификатор товара, который нужно удалить
</li>

<li><h5>Редактирование товара:</h5>
Адрес: {{host}}/product/{id} <br>
Метод: PATCH <br>
Авторизация: Bearer Token: "сгенерированный_токен" <br>
Тело запроса: <br>
{ <br>
    &nbsp&nbsp&nbsp&nbsp "name": "новое_название", <br>
    &nbsp&nbsp&nbsp&nbsp "description": "новое_описание", <br>
    &nbsp&nbsp&nbsp&nbsp "price": "новая_цена" <br>
} <br>
*Успех*: <br>
Статус ответа: 200 <br>
Тело ответа: массив с обновлённой информацией о товаре (id, name, description, price) <br>
Примечание: Возможно частичное редактирование данных товара. При успешном
редактировании возвращается массив с измененными данными
</li>

</ol>

</body>
</html>