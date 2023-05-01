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
		<title>Админ - Посты</title>
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
						<a href="/admin/createp" class="btn  btn-big">Добавить пост</a>
					</div>
					<div class="content">
						<h2 class="page-title">Посты</h2>
						<table>
							<thead>
								<th>id</th>
								<th>Заголовок</th>
								<th>Автор</th>
								<th>Дата</th>
								<th>Посещений</th>
								<th colspan="3">Действия</th>
							</thead>
							<tbody>
							<?php 
							foreach ($posts as $post):
							?>
								<tr>
									<td><?=$post['id'];?></td>
									<td><?=$post['title'];?></td>
									<td><?=$post['author'];?></td>
									<td><?=$post['date'];?></td>
									<td><?=$post['visited'];?></td>
									<td><a href="/admin/editp?postid=<?=$post['id']?>" class="edit">Редактировать</a></td>
									<td><a href="/admin/deletep?postid=<?=$post['id']?>" class="delete">Удалить</a></td>
									<td>
										<?php 
										if ($post['published']==1) {
										?>
										<a href="/admin/publishp?postid=<?=$post['id']?>&published=0" class="publish">Убрать</a>
										<?php
										}else{
										?>
										<a href="/admin/publishp?postid=<?=$post['id']?>&published=1" class="publish">Публикация</a>
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