<!-- resources/views/simple-form.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Простая форма</title>
</head>
<body>
<h2>Простая форма для отправки данных</h2>

<form action="{{ route('send') }}" method="POST">
    @csrf <!-- Добавляем CSRF-токен для защиты от CSRF-атак -->

    <label for="lastName">Фамилия:</label><br>
    <input type="text" id="lastName" name="lastName"><br>

    <label for="firstName">Имя:</label><br>
    <input type="text" id="firstName" name="firstName"><br>

    <label for="room">Номер комнаты:</label><br>
    <input type="text" id="room" name="room"><br>

    <!-- Поля для еды -->
    <label for="food">Еда:</label><br>
    <input type="text" id="foodName" name="food[0][foodName]" placeholder="Название еды">
    <input type="text" id="foodPrice" name="food[0][foodPrice]" placeholder="Цена">
    <input type="text" id="foodCount" name="food[0][foodCount]" placeholder="Количество"><br>
    <label for="totalPrice">Общая стоимость:</label><br>
    <input type="text" id="totalPrice" name="totalPrice" readonly><br><br>

    <input type="submit" value="Отправить">
</form>

<!-- Скрипт для вычисления общей стоимости -->
<script>
    document.addEventListener('input', function(event) {
        if (event.target.id === 'foodPrice' || event.target.id === 'foodCount') {
            const foodPrice = document.getElementById('foodPrice').value;
            const foodCount = document.getElementById('foodCount').value;
            document.getElementById('totalPrice').value = foodPrice * foodCount;
        }
    });
</script>
</body>
</html>