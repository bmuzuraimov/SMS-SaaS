<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" conternt="ie=edge">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="https://fonts.googleapis.com/css2?family=Lora:wght@500&family=Merriweather:wght@300&family=Sansita+Swashed:wght@300;400&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="/public/css/dashboard.css">
		<link rel="stylesheet" href="/public/css/customer.css">
		<link rel="stylesheet" href="/public/css/prism.css" />
		<link rel="icon" href="/public/images/icons/quickstart.ico" type="image/icon">
		<title>Быстрый старт</title>
	</head>
	<body>
		<header>
			<div class="logo">
				<h1 class="logo-text"><a href="/">SanaripKat</a></h1>
			</div>
			<i class="fa fa-bars menu-toggle"></i>
			<ul class="nav">
				<li>
					<?php
					if (isset($_SESSION['name'])) { ?>
					<a href="/customer"><?=$_SESSION['name'];?><i class="fa fa-chevron-down"></i></a>
					<?php } else { ?>
					<a href="/customer/editprofile">Настройка профиля<i class="fa fa-chevron-down"></i></a>
					<?php }
					?>
					<ul>
						<li><a href="/customer/logout" class="logout">Выйти</a></li>
					</ul>
				</li>
			</ul>
		</header>
		<!-- Page Wrapper -->
		<div class="customer-wrapper">
			<!--Left Sidebar-->
			<div class="left-sidebar">
				<?php include('application/include/customer_sidebar.php'); ?>
			</div>
			<!--//Left Sidebar-->
			<!--customer Content-->
			<div class="customer-content">
				<div class="content">
					<h2 class="page-title">Трехэтапное руководство по быстрому запуску</h2>
					<p>Добро пожаловать в SanaripKat API, <?=$customer['fname'];?></p>
					<p>Это руководство должно помочь вам начать работу за несколько секунд - давайте сразу начнем с:</p>
				</div>
				<div class="content">
					<h3>Шаг 1. Ваш ключ доступа к API</h3>
					<p>Это ваш ключ доступа к API, ваш личный ключ, необходимый для аутентификации с помощью SanaripKat API.</p>
					<p>Держите его в безопасности! Вы можете сбросить его в любое время в <a href="/customer" class="blue">Панеле управлений</a>.</p>
					<div class="content-info">
						<h4><i class="fas fa-key"></i>&nbsp;<?=$customer['api_key'];?></h4>					
					</div>
				</div>
				<div class="content">
					<h3>Шаг 2. Конечные точки API</h3>
					<p>В целом существует 3 различных метода использования SanaripKat API:</p>
					<ul>
						<li><strong>Стандартный отправка смс:</strong> одному вашему контакту в меню <a href="/customer/contacts" class="blue">Контакты</a>.</li>
						<li><strong>Массовая отправка смс:</strong> сразу нескольким контактам создав группу в меню <a href="/customer/contacts" class="blue">Контакты</a>.</li>
						<li><strong>Отправка смс с запросом:</strong> используя ваш ключ API c вашего сайта.</li>
					</ul>
					<p><strong>Базовый URL:</strong> какой бы метод API вы ни выбрали, все запросы API к SanaripKat API начинаются со следующего базового URL:</p>
					<h4><mark>http://sanarip.biz.kg/send_sms</mark></h4>
					<p><strong>API запрос:</strong> давайте попробуем сделать запрос API, чтобы отправить сообщение "Привет <?=$customer['fname'];?>" на ваш собственный номер телефона, то есть <?=$customer['phone'];?>. Просто прикрепите его вместе со своим ключом доступа к API к URL-адресу:</p>
					<div class="content-info">
						<a href="http://sanarip.biz.kg/send_sms?access_key=<?=$customer['api_key'];?>&phone=<?=$customer['phone'];?>&message=Привет <?=$customer['fname'];?>" title="Кликните чтобы отправить смс на свой номер" target="_blank">http://sanarip.biz.kg/<strong>send_sms?access_key=<?=$customer['api_key'];?>&phone=<?=$customer['phone'];?>&message=Привет <?=$customer['fname'];?></strong></a>
					</div>
				</div>
				<div class="content">
					<h3>URL-адреса конечных точек</h3>
					<pre><code class="language-javascript">
// Стандартная отправка СМС 

http://sanarip.biz.kg/send_sms?access_key = Ваш API ключ & phone = Номер телефона & message = Сообщение
    
// необязательные параметры: 

    & datetime = 2022-02-4 16:00:00
					</code></pre>
					<p>Чтобы узнать больше о запросах и параметрах API, обратитесь к <a href="/documentation">документации</a>.</p>
				</div>
				<div class="content">
					<h3>Шаг 3. Интегрируйте в свое приложение</h3>
					<p>Это было краткое руководство SanaripKat API. Для получения больше информации по интеграции и примеров кода ознакомьтесь с документацией по API.</p>
					<p>Если вам потребуется какая-либо помощь, обратитесь в нашу <a href="/customer/support?message=Здраствуйте, я бы хотел больше узнать о" class="green">службу поддержки</a>.</p>
				</div>
			</div>
			<!--//customer Content-->
		</div>
		<!-- //Page Wrapper -->
		<!-- JQuery -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- Prism Js -->
		<script src="/public/js/prism.js"></script>
		<!-- Custom -->
		<script type="text/javascript" src="/public/js/scripts.js"></script>
	</body>
</html>