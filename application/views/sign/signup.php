<!DOCTYPE html>
<html>
	<head>
		<title>Регистрация - SanaripKat</title>
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
			<?php include 'application/include/main-nav.php';?>
		</nav>
		<!-- Heading -->
		<div id="heading" >
			<h1>Регистрация</h1>
		</div>
		<!-- Main -->
		<section id="main" class="wrapper">
			<div class="inner">
				<div class="content">
					<!-- Form -->
					<form method="post" action="/register" class="row gtr-uniform" id="signup-form">
						<div class="col-8 col-12-xsmall" style="margin: 0 auto !important;">
							<h3 class="msg"></h3>
							<label for="fname">Имя<span>*</span></label>
							<input type="text" name="fname" />
						</div>
						<div class="col-8 col-12-xsmall" style="margin: 0 auto !important;">
							<label for="lname">Фамилия<span>*</span></label>
							<input type="text" name="lname" />
						</div>
						<div class="col-8 col-12-xsmall" style="margin: 0 auto !important;">
							<label for="website">Название сайта</label>
							<input type="text" name="website" placeholder="sanarip.biz.kg " />
						</div>
						<div class="col-8 col-12-xsmall" style="margin: 0 auto !important;">
							<label for="phone">Номер телефона<span>*</span></label>
							<input type="text" name="phone" placeholder="Номер телефона" autocomplete="off" />
						</div>
						<div class="col-8 col-12-xsmall" style="margin: 0 auto !important;">
							<label for="password">Пароль<span>*</span></label>
							<input type="password" name="password" placeholder="Пароль" />
						</div>
						<!-- Break -->
						<div class="col-8" style="margin: 0 auto !important;">
							<ul class="actions">
								<li><input type="submit" value="Регистрация" class="primary" id="signup-btn" /></li>
							</ul>
						</div>
					</form>
				</div>
			</div>
		</section>
		<!-- Footer -->
		<?php include 'application/include/main-footer.php';?>
		<!-- Scripts -->
		<script src="public/js/jquery.min.js"></script>
		<script src="public/js/browser.min.js"></script>
		<script src="public/js/breakpoints.min.js"></script>
		<script src="public/js/util.js"></script>
		<script src="public/js/main.js"></script>
		<script type="text/javascript" src="/public/js/scripts.js"></script>
		<script type="text/javascript">
		$("#signup-btn").click(function(){
			ajax_signin_request('signup-form', 'msg', 2000);
		});
		</script>
	</body>
</html>