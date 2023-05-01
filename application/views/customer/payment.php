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
		<link rel="icon" href="/public/images/icons/payment.ico" type="image/icon">
		<title>Оплата</title>
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
					<h3 class="page-title">История платежей</h3>
					<table>
						<tr>
							<th>ID</th>
							<th>Статус</th>
							<th>Наименование</th>
							<th>Сумма</th>
							<th>Дата</th>
							<th></th>
						</tr>
						<?php foreach ($transaction_history as $transaction): 
							$payment_type = ($transaction['amount']<=$transaction['monthly_price']) ? 'monthly' : 'annually';
							$remaining = $transaction['amount'];
						?>
						<tr>
							<td><?=$transaction['id'];?></td>
							<?php if ($transaction['status']=='success') { ?>
								<td class="green">
							<?php } else { ?>
								<td class="red">
							<?php 
							}
							?>
							<?=$transaction['status'];?></td>
							<td><?=$transaction['product'];?></td>
							<td><?=$transaction['amount'].' '.$transaction['currency'];?></td>
							<td><?=$transaction['created_at'];?></td>
							<td>
								<?php if ($transaction['status']=='success') { ?>
									<a href="javascript:void(0)" class="btn">Оплачено</a>
								<?php } else if ($transaction['status']=='shortage') { ?>
									<a href="/customer/upgrade?<?='payment_type=remaining&tariff='.$transaction['tariffid'].'&amount='.$remaining;?>" class="btn">Доплатить</a>
								<?php } else { ?>
									<a href="/customer/upgrade?<?='payment_type='.$payment_type.'&tariff='.$transaction['tariffid'];?>" class="btn">Оплатить</a>
								<?php 
								}
								?>
							</td>
						</tr>
						<?php endforeach; ?>
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