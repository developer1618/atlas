<h2 class="container m-auto text-white py-5">Основные блюда</h2>
<div class="m-auto d-block d-lg-flex justify-content-between pb-5 position-static h-auto" style="height:auto;">
    <shortcode>[food-list limit="64"][/food-list]</shortcode>
    <div class="fitcontent flex-column justify-content-between px-4 position-static">
        <div>
            <h3 class="text-white py-4">Корзина</h3>
            <div id="basket">

            </div>
        </div>
        <div class="pb-4 pt-5">
            <button class="add-btn px-4 py-3 w-100 border-0 text-white fw-medium" onclick="modalOrderWindow()">Заказать
                <span id="totalFoodPrice" name="totalPrice"></span> сомон</button>
        </div>
    </div>
</div>
<div class="backgroundModal">
    <div id="orderModal">
        <div id="form">
            <div class="" onclick="">
                <button class="flex float-end btn-close btn-close-white" onclick="closeFoodBlock()"></button>
            </div>
            <h2>Форма</h2>
            <label for="firstName">Имя</label>
            <input type="text" id="firstName">
            <label for="lastName" class="mt-3">Фамилия</label>
            <input type="text" id="lastName">
            <label for="room" class="mt-3">Номер комнаты</label>
            <input type="number" id="room">
            <input type="submit" class="add-btn px-4 py-2 mt-5 w-100 border-0 text-white fw-medium"
                onclick="sendFormData()" value="Отправить">
        </div>
    </div>
    <div id="orderAccepted" class="text-center">
        <img src="http://atlashoteldushanbe.com/storage/atlas-logo.png" alt="Logo" class="mb-5">
        <h3 class="mb-2" style="color: #C09B5A;">Ваш заказ принят!</h3>
        <p class="mb-5">
            Ваш заказ успешно оформлен.
            <br>В ближайшее время мы свяжемся с вами
            <br>для подтверждения заказа
        </p>
        <a href="/" class="text-white mt-5"
            style="background-color: #C09B5A; hover:background-color: #C09B5A; padding: 16px 32px; margin-top: 16px;">Вернуться на главную</a>
    </div>
</div>

<script>
    let cart = document.getElementById('basket');
    let storageItem = JSON.parse(localStorage.getItem('saved'));

    if (storageItem && storageItem.length > 0) {
        let basketItem = storageItem.map(item => {
            return `<div class="d-flex justify-content-between pb-3 food-block" data-id="${item.id}">
            <div class="w-25" style="margin-right:1rem;">
                <img src="${item.imageUrl}" alt="IMG">
            </div>
            <div class="w-75">
                <div class="d-flex justify-content-between">
                    <h5 class="text-white">${item.foodName}</h5>
                    <button class="btn-close btn-close-white" onclick="removeFoodBlock(this)"></button>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white">${item.foodPrice} сомон</h6>
                    </div>
                    <div class="d-flex">
                        <div class="value-button" id="decrease" onclick="decreaseValue(${item.id})" value="Decrease Value">-</div>
                        <input type="number" id="number" value="${item.foodCount}" min="1" data-foodcount="${item.id}"/>
                        <div class="value-button" id="increase" onclick="increaseValue(${item.id})" value="Increase Value">+</div>
                    </div>
                </div>
            </div>
        </div>`;
        });

        cart.innerHTML = basketItem.join('\n');
    } else {
        cart.innerHTML = '<p>Ваша корзина пуста</p>';
    }

    function changeFoodCount(foodId, value) {
        let storageItem = JSON.parse(localStorage.getItem('saved'));

        if (storageItem && storageItem.length > 0) {
            let changedCart = storageItem.map(item => {
                if (item.id == foodId) {
                    item.foodCount = value;
                }
                return item;
            });
            console.log(changedCart);
            localStorage.setItem('saved', JSON.stringify(changedCart));
        }
    }

    function increaseValue(foodId) {
        var el = document.querySelector(`[data-foodcount="${foodId}"]`);
        var value = parseInt(el.value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        el.value = value;

        changeFoodCount(foodId, value);
    }

    function decreaseValue(foodId) {
        var el = document.querySelector(`[data-foodcount="${foodId}"]`);
        var value = parseInt(el.value, 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        el.value = value;

        changeFoodCount(foodId, value);
    }


    function removeFoodBlock(element) {
        var foodBlock = element.closest('.food-block');
        if (foodBlock) {
            removeCartItem(foodBlock.dataset.id);
            foodBlock.remove();
            location.reload();
        }
    }

    function removeCartItem(id) {
        let storageItem = JSON.parse(localStorage.getItem('saved'));
        if (storageItem && storageItem.length > 0) {
            let filteredCart = storageItem.filter(item => item.id != id);
            localStorage.setItem('saved', JSON.stringify(filteredCart));
        }
    }

    function sendFormData() {
        var firstName = document.getElementById('firstName').value;
        var lastName = document.getElementById('lastName').value;
        var room = document.getElementById('room').value;

        var foodItem = JSON.parse(localStorage.getItem('saved') ?? []);
        var foodItem = foodItem.map(item => ({
            foodName: item.foodName,
            foodPrice: parseFloat(item.foodPrice),
            foodCount: item.foodCount
        }));

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "send", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        var data = {
            firstName: firstName,
            lastName: lastName,
            room: room,
            food: foodItem,
        };
        var jsonData = JSON.stringify(data);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                console.log("Request successful", xhr.responseText);
                document.getElementById('orderModal').style.display = 'none';
                document.getElementById('orderAccepted').style.display = 'block';
            } else {
                console.error("Request failed", xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error("Network error");
        };
        xhr.send(jsonData);
        localStorage.removeItem('saved');

    }

    function modalOrderWindow() {
        $('.backgroundModal').css('display', 'block');
        $('#orderModal').css('display', 'block');
        document.querySelector(".backgroundModal").style.display = "flex";
        document.querySelector(".backgroundModal").classList.add("active-animation");
        document.querySelector(".backgroundModal").classList.remove("disactive-animation");
    }

    function closeFoodBlock() {
        $('#orderModal').css('display', 'none');
        $('.backgroundModal').css('display', 'none');
    }

    function totalFoodPrice() {
        let storageItem = JSON.parse(localStorage.getItem('saved'));
        let totalPrice = 0;

        if (storageItem && storageItem.length > 0) {
            totalPrice = storageItem.reduce((acc, item) => {
                return acc + (parseFloat(item.foodPrice) * parseInt(item.foodCount));
            }, 0);
        }

        document.getElementById('totalFoodPrice').textContent = totalPrice;
    }
    totalFoodPrice();

</script>

{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>

<style>
    .row-cols-3>* {
        width: 31%;
    }

    #orderModal {
        background-color: #222;
        color: #DADADA;
        max-width: 512px;
        display: none;
        justify-content: center;
    }

    #orderAccepted {
        background-color: #222;
        color: #DADADA;
        max-width: 512px;
        padding: 48px 32px;
        display: none;
        justify-content: center;
    }

    #orderModal #form {
        padding: 24px;
        width: 100%;
    }

    #orderModal #form input {
        width: 100%;
        font-size: 18px;
    }

    #orderModal #form label {
        display: flex;
        color: #DADADA;
    }

    #sendForm {
        height: auto !important;
    }


    .backgroundModal {
        justify-content: center;
        align-items: center;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 10000;
        background: red;
        width: 100vw;
        height: 100vh;
        background: #a8a8a8a8;
        transition: 1000ms;
        display: none;
    }

    button {
        background-color: #C09B5A;
    }

    .pointer {
        cursor: pointer;
    }

    form {
        width: 300px;
        margin: 0 auto;
        text-align: center;
        padding-top: 50px;
    }

    .fitcontent {
        min-width: 28rem;
    }

    .value-button {
        display: inline-block;
        border: 1px solid #ddd;
        margin: 0px;
        width: 40px;
        height: 40px;
        text-align: center;
        vertical-align: middle;
        padding: 8px 0;
        background: #DADADA;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .value-button:hover {
        cursor: pointer;
    }

    form #decrease {
        margin-right: -4px;
        border-radius: 8px 0 0 8px;
    }

    form #increase {
        margin-left: -4px;
        border-radius: 0 8px 8px 0;
    }

    form #input-wrap {
        margin: 0px;
        padding: 0px;
    }

    input#number {
        text-align: center;
        border: none;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        margin: 0px;
        width: 40px;
        height: 40px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
