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
		<link rel="icon" href="/public/images/icons/sms.ico" type="image/icon">
		<title>Панель управления</title>
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
					<div class="tab" style="grid-template-columns: 50% 50%;">
						<a href="/customer/quickstart">Быстрый старт 3 шага</a>
						<a href="/documentation">Документация</a>
					</div>
				</div>
				<div class="content">
					<h3>Ваш API Ключ Доступа</h3>
					<div class="content-info">
						<h4><i class="fas fa-key"></i>&nbsp;<?=$customer['api_key'];?></h4>					
					</div>
				</div>
				<div class="content">
					<h3>Ваш тариф</h3>
					<div class="content-info">
						<p>Тариф: <?=$subscription['subscription_type'];?></p>
						<p>Статус: <a href="/customer/payment" class=<?=$status_color;?>><?=$account_status;?></a></p>
						<p>API потребление: <?php echo round($subscription['used_requests']/$subscription['month_requests']*100)."% (".$subscription['used_requests']." / ".$subscription['month_requests'].") ";?><a href="/customer/usage">API Usage</a></p>
					</div>
					<h3>Ваш аккаунт</h3>
					<div class="content-info">
						<p>Имя: <?=$customer['fname'];?></p>
						<p>Почта: <?=$customer['email'];?></p>
						<p>Компания: <?=$customer['company'];?></p>
					</div>
					<h3>Оплата</h3>
					<div class="content-info">
						<p>Текущее: <?php echo $subscription['month_price']." сом в месяц";?></p>
						<p>Расчетный период: <?=substr($subscription['from_date'], 0, 10)." - ".substr($subscription['to_date'], 0, 10);?></p>
						<p>Итого к оплате: <a href="/customer/payment" class=<?=$status_color;?>><?=$due_amount." сом";?></a></p>
					</div>
				</div>
			</div>
			<!--//customer Content-->
		</div>
		<!-- //Page Wrapper -->
		<!-- JQuery -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- Custom -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
	</body>
</html>