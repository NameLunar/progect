<?php
require_once "php/session.php";
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Страница пользователя</title>
	<link href="src\output.css" rel="stylesheet">
    <link href="src\style.css" rel="stylesheet">
    <script src="loader.js"></script>
    <script src="script.js"></script>
</head>

<body class="bg-gray-100" style="overflow: hidden;">

    <!-- 🔹 Фиксированная шапка -->
    <header id="header" class="bg-white shadow-md py-4 fixed w-full top-0 z-50 opacity-0 invisible transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center px-6">
        <a href="index.php" class="text-2xl font-bold">Магазин</a>
        <ul class="flex space-x-6">
            <li><a href="index.php" class="hover:text-blue-500">Главная</a></li>
            <li><a href="contacts.html" class="hover:text-blue-500">Контакты</a></li>
        </ul>
    </div>
    </header>
    <div class="flex h-screen mt-20">
        <!-- Меню слева -->
        <div class="w-64 bg-white shadow-md p-6">
            <h2 class="text-2xl font-semibold text-center mb-6">Меню</h2>
            <ul class="space-y-4">
                <li class="hover:text-blue-500"><button id="ordersTab" class="w-full text-left text-lg cursor-pointer">История заказов</button></li>
                <li class="hover:text-blue-500"><button id="addressTab" class="w-full text-left text-lg cursor-pointer">Адрес доставки</button></li>
                <li class="hover:text-blue-500"><button id="contactTab" class="w-full text-left text-lg cursor-pointer">Контактные данные</button></li>
                <li class="hover:text-blue-500"><button id="logoutBtnMenu" class=" w-full text-left text-lg text-red-500 cursor-pointer" >Выход</button></li>
            </ul>
        </div>

        <!-- Основной контент -->
        <div class="flex-1 w-full p-6">

            <div id="ordersSection" class="hidden">
                <h2 class="text-2xl font-semibold mb-4">История заказов</h2>
                <ul id="ordersList" class="space-y-4 max-h-[400px] w-full overflow-y-auto border border-gray-300 p-2 rounded-md">
                    <!-- Сюда будут загружаться заказы -->
                </ul>
                <p id="noOrdersMessage" class="text-gray-500 text-center hidden">Заказы не найдены</p>
            </div>

            <!-- 🔹 Адрес доставки -->
            <div id="addressSection" class="hidden">
                <h2 class="text-2xl font-semibold mb-4">Адрес доставки</h2>
                <div class="space-y-4">
                    <div>
                        <label for="address" class="block text-lg">Адрес</label>
                        <input id="address" type="text" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Введите адрес" title="Начните ввод с 'г.' (например, г.Кемерово)" />
                        <ul id="citySuggestions" class="bg-white border border-gray-300 mt-2 rounded-md hidden absolute w-full z-10"></ul>
                    </div>
                    <button type="submit" id="" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                        Сохранить
                    </button>
                </div>
            </div>

            <!-- 🔹 Контактные данные -->
            <div id="contactSection" class="hidden">
                <h2 class="text-2xl font-semibold mb-4">Контактные данные</h2>
                <div class="space-y-4">
                    <div>
                        <label for="fullName" class="block text-lg">Имя</label>
                        <input id="fullName" type="text" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Введите ФИО" value="<?=$_SESSION["name"]?>"/>
                    </div>
                    <div>
                        <label for="phone" class="block text-lg">Номер телефона</label>
                        <input id="phone" type="text" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Введите номер телефона" value="<?=$_SESSION["phone_number"]?>" />
                    </div>
                    <div>
                        <label for="email" class="block text-lg">Email</label>
                        <input id="email" type="email" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Введите email" value="<?=$_SESSION["email"]?>" />
                    </div>
                    <button type="submit" id="" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                        Сохранить
                    </button>


                    <!-- ✅ Чекбокс для смены пароля -->
                    <div class="flex items-center space-x-2">
                        <input id="changePasswordCheckbox" type="checkbox" class="w-5 h-5">
                        <label for="changePasswordCheckbox" class="text-lg">Сменить пароль</label>
                    </div>

                    <!-- 🔹 Поля смены пароля (скрыты по умолчанию) -->
                    <div id="passwordFields" class="hidden space-y-4">
                        <form action="php/session/repass.php">
                            <div>
                                <label for="oldPassword" class="block text-lg">Текущий пароль</label>
                                <input id="oldPassword" name="oldPassword" type="password" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Введите текущий пароль" />
                            </div>
                            <div>
                                <label for="newPassword" class="block text-lg">Новый пароль</label>
                                <input id="newPassword" name="newPassword" type="password" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Введите новый пароль" />
                            </div>
                            <div>
                                <label for="confirmNewPassword" class="block text-lg">Подтвердите новый пароль</label>
                                <input id="confirmNewPassword" name="newPassword2" type="password" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Повторите новый пароль" />
                            </div>
                            <button type="submit" id="updatePasswordBtn" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                                Обновить пароль
                            </button>
					</form>
				</div>

				</div>
			</div>

        </div>
    </div>

    <script>
        // Функции для переключения вкладок
		document.addEventListener("DOMContentLoaded", () => {
            document.getElementById("ordersSection").classList.remove("hidden");
        });
        document.getElementById("ordersTab").addEventListener("click", () => {
            document.getElementById("ordersSection").classList.remove("hidden");
            document.getElementById("addressSection").classList.add("hidden");
            document.getElementById("contactSection").classList.add("hidden");
        });
        document.getElementById("addressTab").addEventListener("click", () => {
            document.getElementById("addressSection").classList.remove("hidden");
            document.getElementById("ordersSection").classList.add("hidden");
            document.getElementById("contactSection").classList.add("hidden");
        });
        document.getElementById("contactTab").addEventListener("click", () => {
            document.getElementById("contactSection").classList.remove("hidden");
            document.getElementById("ordersSection").classList.add("hidden");
            document.getElementById("addressSection").classList.add("hidden");
        });
        document.getElementById("logoutBtnMenu").addEventListener("click", () => {
            window.location.href = "php/session/logout.php";
        });


				// JS для пароля
			document.addEventListener("DOMContentLoaded", () => {
			const changePasswordCheckbox = document.getElementById("changePasswordCheckbox");
			const passwordFields = document.getElementById("passwordFields");
			const updatePasswordBtn = document.getElementById("updatePasswordBtn");

			// ✅ Показать/скрыть поля смены пароля при активации чекбокса
			changePasswordCheckbox.addEventListener("change", () => {
				if (changePasswordCheckbox.checked) {
					passwordFields.classList.remove("hidden");
				} else {
					passwordFields.classList.add("hidden");
				}
			});



            // ЗАКАЗЫ
            const ordersList = document.getElementById("ordersList");
    const noOrdersMessage = document.getElementById("noOrdersMessage");

    // 🔹 Функция генерации даты прибытия (+1–7 дней от даты заказа)
    function getDeliveryDate(orderDate) {
        const deliveryOffset = Math.floor(Math.random() * 7) + 1; // От 1 до 7 дней
        const deliveryDate = new Date(orderDate);
        deliveryDate.setDate(deliveryDate.getDate() + deliveryOffset);
        return deliveryDate;
    }

    // 🔹 Заглушка заказов (замените на API-запрос)
    const orders = [
        { id: 1, date: "2024-03-20 14:30", total: "5 990 ₽" },
        { id: 2, date: "2024-03-18 11:15", total: "12 990 ₽" },
        { id: 3, date: "2024-03-15 09:00", total: "7 490 ₽" },
        { id: 4, date: "2024-03-20 14:30", total: "5 990 ₽" },
        { id: 5, date: "2024-03-18 11:15", total: "12 990 ₽" },
        { id: 6, date: "2024-03-15 09:00", total: "7 490 ₽" },
        { id: 7, date: "2024-03-25 14:30", total: "5 990 ₽" },
        { id: 8, date: "2024-03-18 11:15", total: "12 990 ₽" },
        { id: 9, date: "2024-03-15 09:00", total: "7 490 ₽" }
    ].map(order => {
        const orderDate = new Date(order.date);
        const deliveryDate = getDeliveryDate(orderDate);
        const today = new Date();
        const status = today > deliveryDate ? "Доставлен" : "В обработке";

        return { ...order, deliveryDate, status };
    });

    // Если заказов нет, показываем заглушку
    if (orders.length === 0) {
        noOrdersMessage.classList.remove("hidden");
        return;
    }

    // 🔹 Генерация HTML для заказов
    ordersList.innerHTML = orders.map((order, index) => `
        <li class="bg-white p-4 rounded-lg shadow-md flex justify-between items-center border-l-4
            ${order.status === "Доставлен" ? "border-green-500" : "border-yellow-500"}"
            data-index="${index}">
            
            <div>
                <p class="text-lg font-semibold">Заказ #${order.id}</p>
                <p class="text-gray-500">Дата заказа: ${order.date}</p>
                <p class="text-gray-500">Дата прибытия: ${order.deliveryDate.toLocaleDateString()}</p>
                <p class="text-gray-700 font-bold">Сумма: ${order.total}</p>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    ${order.status === "Доставлен" ? "bg-green-100 text-green-600" : "bg-yellow-100 text-yellow-600"}">
                    ${order.status}
                </span>
            </div>

            <button class="cancel-order-btn bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600"
                ${order.status === "Доставлен" ? "disabled class='opacity-50 cursor-not-allowed'" : ""}>
                Отменить
            </button>
        </li>
    `).join("");

    // 🔹 Обработчик кнопки "Отменить"
    document.querySelectorAll(".cancel-order-btn").forEach((btn, index) => {
        btn.addEventListener("click", () => {
            orders[index].status = "Отменен";
            btn.parentElement.classList.replace("border-yellow-500", "border-red-500");
            btn.previousElementSibling.innerHTML = `<span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-600">Отменен</span>`;
            btn.disabled = true;
            btn.classList.add("opacity-50", "cursor-not-allowed");
        });
    });




    // АВТОЗАПОЛНЕНИЕ ГОРОДОВ
    const addressInput = document.getElementById("address");
    const citySuggestions = document.getElementById("citySuggestions");

    // Массив доступных городов
    const cities = ["г.Кемерово", "г.Москва", "г.Санкт-Петербург", "г.Новосибирск"];

    addressInput.addEventListener("input", function () {
        const value = addressInput.value.trim().toLowerCase();

        // Проверяем, начинается ли ввод с "г."
        if (value.startsWith("г.")) {
            citySuggestions.innerHTML = ""; // Очищаем прошлые подсказки
            citySuggestions.classList.remove("hidden");

            // Фильтруем города по введённому значению
            const filteredCities = cities.filter(city => city.toLowerCase().startsWith(value));

            if (filteredCities.length > 0) {
                filteredCities.forEach(city => {
                    const li = document.createElement("li");
                    li.textContent = city;
                    li.className = "p-2 cursor-pointer hover:bg-gray-200";
                    li.addEventListener("click", function () {
                        addressInput.value = city; // Выбираем город
                        citySuggestions.classList.add("hidden");
                    });
                    citySuggestions.appendChild(li);
                });
            } else {
                citySuggestions.classList.add("hidden");
            }
        } else {
            citySuggestions.classList.add("hidden");
        }
    });

    // Скрываем список при клике вне
    document.addEventListener("click", function (e) {
        if (!addressInput.contains(e.target) && !citySuggestions.contains(e.target)) {
            citySuggestions.classList.add("hidden");
        }
    });


    // ПОЯВЛЕНИЕ ШАПКИ САЙТА
    const header = document.getElementById("header");

    document.addEventListener("mousemove", function (e) {
        if (e.clientY < 50) { // Если курсор в верхних 50px экрана
            header.classList.remove("opacity-0", "invisible");
            header.classList.add("opacity-100", "visible");
        } else {
            header.classList.add("opacity-0", "invisible");
            header.classList.remove("opacity-100", "visible");
        }
    });

});

</script>
</body>
</html>
<style>
    #ordersList{
        overflow-y: scroll;
        width: 100%;
        height: 100%;
    }
    #ordersSection{
        width: 100%;
        height: calc(100% - 20px);
    }
</style>
