<!DOCTYPE html>
<html>
	<head>
		<title>Код Подтверждения</title>
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
		<!-- Main -->
		<section id="main" class="wrapper">
			<div class="inner">
				<div class="content">
					<!-- Form -->
					<form method="post" action="/verify" class="row gtr-uniform" id="verification-form">
						<input type="hidden" name="customerid" value="<?php echo $customer_id;?>">
						<div class="col-8 col-12-xsmall" style="margin: 0 auto !important;">
							<h3 for="verification_code">Код подтверждения</h3>
							<input type="number" name="verification_code" required />
							<h4 class="msg"></h4>
						</div>
						<!-- Break -->
						<div class="col-8" style="margin: 0 auto !important;">
							<ul class="actions">
								<li><input type="submit" value="Подтвердить" class="primary" id="verify-btn" /></li>
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
		<script type="text/javascript">
		$(document).ready(function() {
			$("#verify-btn").click(function(){
			$.post($("#verification-form").attr("action"), $("#verification-form :input").serializeArray(), function(info){
				if(info==1){
					$(".msg").removeClass("error");
					$(".msg").addClass("success");
					$(".msg").html("Ваш аккаунт подтвержден!");
					$('html, body').animate({scrollTop: 0}, 'slow');
					window.setTimeout(function () {
        				location.href = "/signin";
    				}, 2000);
				}else{
					$(".msg").removeClass("success");
					$(".msg").addClass("error");
					$(".msg").html("Неправильный код");
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			});
			});
			$("#verification-form").submit(function(){
				return false;
			});
		}); 
		</script>
	</body>
</html>