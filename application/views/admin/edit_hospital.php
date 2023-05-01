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
		<title>Админ - Редактировать Больницу</title>
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
					<h2 class="page-title">Редактировать Больницу</h2>
					<form action="/admin/updateр" method="post">
						<input type="hidden" name="hospital_id" value="<?=$_GET['hospital_id']?>">
			            <div>
			              <label>Название больницы<span>*</span></label><br>
			              <input type="text" name="name" value="<?=$hospital['name'];?>" class="text-input" required/>
			            </div>
			            <div>
			              <label>Адрес<span>*</span></label><br>
			              <input type="text" name="address" value="<?=$hospital['address'];?>" class="text-input" required/>
			            </div>
			            <div>
			              <label>Город<span>*</span></label><br>
			              <input type="text" name="city" value="<?=$hospital['city'];?>" class="text-input" required/>
			            </div>
			            <div>
			              <label>Область<span>*</span></label><br>
			              <select name="oblast" class="text-input">
			                <option disabled selected="<?=$hospital['oblast'];?>"><?=$hospital['oblast'];?></option>
			                <option value="Баткенская область" >Баткенская область</option>
			                <option value="Джалал-Абадская область">Джалал-Абадская область</option>
			                <option value="Иссык-Кульская область">Иссык-Кульская область</option>
			                <option value="Нарынская область">Нарынская область</option>
			                <option value="Ошская область">Ошская область</option>
			                <option value="Таласская область">Таласская область</option>
			                <option value="Чуйская область">Чуйская область</option>
			              </select>
			            </div>
			            <div>
			              <label>Всего коек<span>*</span></label><br>
			              <input type="number" name="tunits" value="<?=$hospital['tunits'];?>" class="text-input" required/>
			            </div>
						<div class="submit">
							<button type="submit" name="submit" class="btn btn-big" id="submit_voter">Сохранить</button>
						</div>
					</form>
				</div>
			</div>
			<!--//Admin Content-->
		</div>
		<!-- //Page Wrapper -->
		<!-- JQuery -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- CKEditor -->
		<script src="https://cdn.ckeditor.com/ckeditor5/21.0.0/classic/ckeditor.js"></script>
		<script src="/public/scripts/post_editor.js"></script>
		<!-- Custom -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
	</body>
</html>