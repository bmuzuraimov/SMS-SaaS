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
		<link rel="stylesheet" href="/public/styles/morris.css">
		<link rel="icon" href="/public/images/icons/icon_admin.ico" type="image/icon">
		<title>Админ - Статистика</title>
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
					<h2 class="page-title">Статистика</h2>
					<div class="info">
						<h3>Общая информация</h3>
						<div class="info-data">
							<div class="data">
								<h4>Всего Больниц</h4>
								<p><?=$total_hospitals?></p>
							</div>
							<div class="data">
								<h4>Всего Пациентов</h4>
								<p><?=$total_patients?></p>
							</div>
							<div class="data">
							</div>
						</div>
					</div>
					<div class="extra-info">
						<h3>Covid статистика на сегодня</h3>
						<div class="extra-info-data">
							<div class="data">
								<h4>Новых пациентов</h4>
								<p><?=$daily_patients?></p>
							</div>
							<div class="data">
								<h4>Вылечилось</h4>
								<p></p>
							</div>
							<div class="data">
								<h4>Летальных исходов</h4>
								<p></p>
							</div>
						</div>
					</div>
					<h2 class="page-title">Рост за последние 7 дней</h2>
					<div class="graph" id="patients" style=""></div>
				</div>
			</div>
			<!--//Admin Content-->
		</div>
		<!-- //Page Wrapper -->
		<!-- JQuery -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- Custom -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- Morris -->
		<script src="/public/scripts/morris.js"></script>
		<!-- Raphael-min -->
		<script src="/public/scripts/raphael-min.js"></script>
		<script>
		Morris.Area({
			element: 'patients',
			redraw: true,
			behaveLikeLine: true,
			data: [
			<?php foreach ($patients_growth as $day):
			echo "{date: '" . $day['day'] . "', y: '" . $day['patient'] . "'},";
			endforeach; ?>
			],
			parseTime: false,
			xkey: 'date',
			ykeys: 'y',
			labels: ['Пациентов', 'y']
		});
		</script>
	</body>
</html>