<?php
if (isset($_SESSION['isAdmin'])){
	if ($_SESSION['isAdmin']==true) {
		header('Location: /admin');
		exit;
	} else {
		header('Location: /customer');
		exit;
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Вход - SanaripKat</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="/public/css/main.css" />
		<link rel="icon" href="/public/images/icons/sms.ico" type="image/icon">
	</head>
	<body class="is-preload">
		<!-- Header -->
		<header id="header">
			<a class="logo" href="/">SanaripKat</a>
			<nav>
				<a href="#menu">Меню</a>
			</nav>
		</header>
		<!-- Nav -->
		<nav id="menu">
			<?php include('application/include/main-nav.php'); ?>
		</nav>
		<!-- Heading -->
		<div id="heading" >
			<h1>Войти</h1>
		</div>
		<!-- Main -->
		<section id="main" class="wrapper">
			<div class="inner">
				<div class="content">
					<!-- Form -->
					<form method="post" action="/authenticate" class="row gtr-uniform" id="sign-in-form">
						<div class="col-8 col-12-xsmall" style="margin: 0 auto !important;">
							<h3 class="msg"></h3>
							<label for="phone">Номер телефона</label>
							<input type="text" name="phone" id="name" placeholder="Номер телефона" />
						</div>
						<div class="col-8 col-12-xsmall" style="margin: 0 auto !important;">
							<label for="password">Пароль</label>
							<input type="password" name="password" id="password" placeholder="Пароль" />
						</div>
						<!-- Break -->
						<div class="col-8" style="margin: 0 auto !important;">
							<ul class="actions">
								<li><input type="submit" value="Войти" class="primary" id="sign-in-btn" /></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
		</section>
		<!-- Footer -->
		<?php include('application/include/main-footer.php'); ?>
		<!-- Scripts -->
		<script src="public/js/jquery.min.js"></script>
		<script src="public/js/browser.min.js"></script>
		<script src="public/js/breakpoints.min.js"></script>
		<script src="public/js/util.js"></script>
		<script src="public/js/main.js"></script>
		<script type="text/javascript" src="/public/js/scripts.js"></script>
		<script type="text/javascript">
		$("#sign-in-btn").click(function(){
			ajax_signin_request('sign-in-form', 'msg', 1000);
		});
		</script>
	</body>
</html>