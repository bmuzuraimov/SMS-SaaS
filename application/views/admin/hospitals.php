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
		<title>Админ - Больницы</title>
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
					<?php if (empty($_GET)) {?>
					<div class="button-group">
						<a href="/sign_up" class="btn  btn-big">Добавить Больницу</a>
						<a href="/admin/hospitals?show=requests" class="btn  btn-big">Запросы</a>
					</div>
					<h2 class="page-title">Больницы</h2>
					<table>
						<thead>
							<th>id</th>
							<th>Имя</th>
							<th>IP</th>
							<th colspan="3">Действия</th>
						</thead>
						<tbody>
							<?php foreach ($hospitals as $hospital): ?>
							<tr>
									<td><?=$hospital['id']?></td>
									<td><?=$hospital['name']?></td>
									<td><?=$hospital['ip']?></td>
									<td><a href="/admin/edith?hospitalid=<?=$hospital['id']?>" class="edit">Изменить</a></td>
									<td><a href="/admin/approveh?hospitalid=<?=$hospital['id'];?>" class="delete">Блок</a></td>
									<td><a href="/admin/viewh?hospitalid=<?=$hospital['id']?>" class="publish">Просмотр</a></td>
							</tr>								
							<?php endforeach ?>
						</tbody>
					</table>
					<?php } elseif ($_GET['show']=='requests') { ?>
					<div class="button-group">
						<a href="/admin/hospitals" class="btn  btn-big">Больницы</a>
					</div>
					<h2 class="page-title">Запросы</h2>
					<table>
						<thead>
							<th>id</th>
							<th>Имя</th>
							<th>IP</th>
							<th colspan="3">Действия</th>
						</thead>
						<tbody>
							<?php foreach ($unvalid_hosptials as $hospital): ?>
							<tr>
									<td><?=$hospital['id']?></td>
									<td><?=$hospital['name']?></td>
									<td><?=$hospital['ip']?></td>
									<td><a href="/admin/deleteh?hospitalid=<?=$hospital['id']?>" class="delete">Удалить</a></td>
									<td><a href="/admin/approveh?hospitalid=<?=$hospital['id'];?>" class="edit">Одобрить</a></td>
									<td><a href="/admin/viewh?hospitalid=<?=$hospital['id']?>" class="publish">Просмотр</a></td>
							</tr>								
							<?php endforeach ?>
						</tbody>
					</table>
					<?php } else { ?>
					<div class="button-group">
						<a href="/admin/hospitals" class="btn  btn-big">Больницы</a>
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