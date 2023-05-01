<?php 
function red2green($percentage){
	$color = null;
	$first = null;
	$second = null;
	if ($percentage < 50) {
		$second = ((($percentage - 0) * (255 - 0)) / (50 - 0)) + 0;
		$second = round($second);
		$color = "255 , ".$second.", 0";
	}else{
		$first = ((($percentage - 50) * (0 - 255)) / (100 - 50)) + 255;
		$first = round($first);
		$color = $first.", 255, 0";
	}
	return $color;
}
$data = (($subscription['used_requests']) / ($subscription['month_requests']) ) * (100);
$data = (100-$data);
$color = red2green($data);
$data .= '%';
?>
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
		<link rel="icon" href="/public/images/icons/usage.ico" type="image/icon">
		<title>API Потребление</title>
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
					<h3>Использование API в этом месяце:</h3>
					<div class="content-info">
						<p>API Запросы <?php echo "(".($subscription['month_requests'] - $subscription['used_requests'])." / ".$subscription['month_requests'].") ";?></p>
						<div class="usage-bar">
							<span class="usage-bar-fill" style="width: <?=$data?>;background-color: rgb(<?=$color?>);"></span>
							<div class="usage-bar-mark"></div>
						</div>
						<hr>
						<p>Период использования: <?php echo substr($subscription['from_date'], 0, 10)." - ".substr($subscription['to_date'], 0, 10);?></p>
					</div>
					<table id="requestTable">
						<tr>
							<th>№ телефона</th>
							<th>Сообщение</th>
							<th>Дата запроса</th>
							<th colspan="2">Запланировано</th>
						</tr>
						<tr>
							<td>0773748984</td>
							<td>Привет</td>
							<td>25.07.2021</td>
							<td>26.07.2021</td>
							<td>Отправлено</td>
						</tr>
						<?php
						foreach($messages as $message):?>
						<tr>
							<td><?=$message['phone'];?></td>
							<td><?=$message['sms'];?></td>
							<td><?=$message['created_date'];?></td>
							<td>Отправлено</td>
						</tr>
						<?php
						endforeach;
						?>
					</table>
				</div>
			</div>
			<!--//customer Content-->
		</div>
		<!-- //Page Wrapper -->
		<!-- JQuery -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- Custom -->
		<script type="text/javascript" src="/public/js/scripts.js"></script>
	</body>
</html>