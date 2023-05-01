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
		<title>Админ - Добавить Пользователя</title>
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
				<div class="button-group">
					<a href="/admin/users" class="btn  btn-big">Пользователи</a>
				</div>
				<div class="content">
					<?php 
					if ($user['super']==1) {
					?>
					<h2 class="page-title">Добавить Пользователя</h2>
					<form action="/admin/createu" method="post" id="add_voter">
						<div>
							<label>Имя Пользователя</label>
							<input type="text" name="username" class="text-input">
						</div>
						<div>
							<label>Супер Админ</label>
							<select name="super" class="text-input">
								<option value="1">Да</option>
								<option value="0" selected>Нет</option>
							</select>
						</div>
						<div class="submit">
							<button type="submit" name="submit" class="btn btn-big" id="submit_voter">Добавить</button>
						</div>
					</form>
					<?php
					}else{
					 ?>
					<h2 class="page-title error">Доступ Запрещен!</h2>
					<?php
					}
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