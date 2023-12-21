<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Новый заказ</title>
</head>
<body>
<h2>Новый заказ от {{ $orderDetails['lastName'] }} {{ $orderDetails['firstName'] }}</h2>

<p>Детали заказа:</p>

<p><strong>Имя:</strong> {{ $orderDetails['firstName'] }}</p>
<p><strong>Фамилия:</strong> {{ $orderDetails['lastName'] }}</p>
<p><strong>Номер комнаты:</strong> {{ $orderDetails['room'] }}</p>

<p>Заказанные блюда:</p>
<ul>
    @foreach($orderDetails['food'] as $foodItem)
        <li>
            {{ $foodItem['foodName'] }} - {{ $foodItem['foodPrice'] }} x {{ $foodItem['foodCount'] }}
        </li>
    @endforeach
</ul>

<p><strong>Итоговая стоимость:</strong> {{ $orderDetails['totalPrice'] }}</p>

<p>С уважением,<br> Ваше приложение</p>
</body>
</html>