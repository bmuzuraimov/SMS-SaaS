<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" conternt="ie=edge">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="https://fonts.googleapis.com/css2?family=Lora:wght@500&family=Merriweather:wght@300&family=Sansita+Swashed:wght@300;400&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="/public/styles/style.css">
		<link rel="stylesheet" href="/public/styles/admin.css">
		<link rel="icon" href="/public/images/icons/icon_admin.ico" type="image/icon">
		<title>Админ - Пользователи</title>
	</head>
	<body>
		<header>
			<div class="logo">
				<h1 class="logo-text"><a href="/">SanaripKat</a></h1>
			</div>
			<i class="fa fa-bars menu-toggle"></i>
			<ul class="nav">
				<li>
					<a href="/admin"><?=$user['username'];?><i class="fa fa-chevron-down"></i></a>
					<ul>
						<li><a href="/admin/logout" class="logout">Выйти</a></li>
					</ul>
				</li>
			</ul>
		</header>
		<!-- Page Wrapper -->
		<div class="admin-wrapper">
			<!--Left Sidebar-->
			<div class="left-sidebar">
				<?php include('application/include/admin_sidebar.html'); ?>
			</div>
			<!--//Left Sidebar-->
			<!--Admin Content-->
			<div class="admin-content">
				<div class="content">
					<?php if (empty($_GET)) { ?>
					<div class="button-group">
						<a href="/admin/createu" class="btn  btn-big">Добавить Пользователя</a>
						<a href="/admin/users?show=requests" class="btn  btn-big">Запросы</a>
					</div><br><br>
					<h2 class="page-title">Управление Пользователями</h2>
					<table>
						<thead>
							<th>id</th>
							<th>Пользователь</th>
							<th>Временный пароль</th>
							<th>Права</th>
							<th>Действие</th>
						</thead>
						<tbody>
							<?php 
							foreach ($users as $user):
							?>
							<tr>
								<td><?=$user['id']?></td>
								<td><?=$user['username']?></td>
								<td><?=$user['temp_password']?></td>
								<td><?=$user['super']?></td>
								<td>
								<?php 
								if ($user['super']==1) {?>
									<a href="#доступ ограничен" class="delete">Блок</a>
								<?php
								}else{ ?>
									<a href="/admin/blocku?userid=<?=$user['id']?>&block=0" class="delete">Блок</a>
									<?php
								}
								?>
								</td>
							</tr>
							<?php
							endforeach;
							 ?>
						</tbody>
					</table>
					<?php } elseif ($_GET['show']=='requests') {
					if ($user['super']==1) {
					?>
					<div class="button-group">
						<a href="/admin/users" class="btn  btn-big">Пользоваетели</a>
					</div>
					<h2 class="page-title">Запросы Пользователей</h2>
					<table>
						<thead>
							<th>id</th>
							<th>Пользователь</th>
							<th>Временный пароль</th>
							<th>Права</th>
							<th colspan="2">Действие</th>
						</thead>
						<tbody>
							<?php foreach ($user_requests as $user_request): ?>
							<tr>
								<td><?=$user_request['id']?></td>
								<td><?=$user_request['username']?></td>
								<td><?=$user_request['temp_password']?></td>
								<td><?=$user_request['super']?></td>
								<td><a href="/admin/blocku?userid=<?=$user_request['id']?>&block=1" class="edit">Подтвердить</a></td>
								<td><a href="/admin/deleteu?userid=<?=$user_request['id']?>" class="delete">Удалить</a></td>
							</tr>								
							<?php endforeach ?>
						</tbody>
					</table>
					<?php
					}else{
					 ?>
					<h2 class="page-title error">Доступ Запрещен!</h2>
					<?php
					}
					} else { ?>
					<div class="button-group">
						<a href="/admin/users" class="btn  btn-big">Пользователи</a>
					</div><br><br>
					<h2 class="page-title error">Произошла ошибка</h2>
					<?php }
					 ?>
				</div>
			</div>
			<!--//Admin Content-->
		</div>
		<!-- //Page Wrapper -->
		<!-- JQuery -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- Custom -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
	</body>
</html>