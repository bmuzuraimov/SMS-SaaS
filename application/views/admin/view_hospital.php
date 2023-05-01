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
		<title>Админ - <?=$hospital['name'];?></title>
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
					<div class="button-group">
						<?php 
						$show = filter_input(INPUT_GET, 'show');
						if (empty($show)) { ?>
							<a href="/admin/viewh?hospitalid=<?=$_GET['hospitalid'];?>&show=requests" class="btn  btn-big">Заблокированные аккаунты</a>
						<?php } elseif ($show == 'requests') { ?>
							<a href="/admin/viewh?hospitalid=<?=$_GET['hospitalid'];?>" class="btn  btn-big"><?=$hospital['name'];?></a>
						<?php } else { ?>
							<a href="/admin/viewh?hospitalid=<?=$_GET['hospitalid'];?>" class="btn  btn-big"><?=$hospital['name'];?></a>
						<?php }
						 ?>
					</div><br><br>
					<h2 class="page-title"><?=$hospital['name'];?></h2>
					<div class="info">
						<h3>Инфо</h3>
						<div class="info-data">
							<div class="data">
								<h4>Проверенный</h4>
								<p><?=$hospital['valid']?></p>
							</div>
							<div class="data">
								<h4>Всего Коек</h4>
								<p><?=$hospital['tunits']?></p>
							</div>
							<div class="data">
								<h4>Свободно</h4>
								<p><?=$hospital['aunits'];?></p>
							</div>
						</div>
					</div>
					<div class="extra-info">
						<div class="extra-info-data">
							<div class="data">
								<h4>Область</h4>
								<p><?=$hospital['oblast']?></p>
							</div>
							<div class="data">
								<h4>Город</h4>
								<p><?=$hospital['city']?></p>
							</div>
							<div class="data">
								<h4>Улица</h4>
								<p><?=$hospital['address']?></p>
							</div>
						</div>
					</div>
					<h2 class="page-title">Врачи</h2>
					<table>
						<thead>
							<th>id</th>
							<th>Глав</th>
							<th>Фамилия</th>
							<th>Имя</th>
							<th>Номер телефона</th>
							<th colspan="2">Действия</th>
						</thead>
						<tbody>
							<?php foreach ($doctors as $doctor): ?>
							<tr>
									<td><?=$doctor['id']?></td>
									<td><?=($doctor['isHead']==1)?"@":"*";?></td>
									<td><?=$doctor['lname']?></td>
									<td><?=$doctor['fname']?></td>
									<td><?=$doctor['phone']?></td>
									<td><a href="/admin/blockd?doctor_id=<?=$doctor['id']?>" class="delete">Блок</a></td>
									<td><a href="/admin/view_doctor?doctor_id=<?=$doctor['id']?>" class="publish">Просмотр</a></td>
							</tr>								
							<?php endforeach ?>
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