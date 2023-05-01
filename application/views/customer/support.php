<?php 
if (empty($_GET['message'])) {
	$quickmessage = '';
} else {
	$quickmessage = filter_input(INPUT_GET, 'message');
}
 ?>
<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" conternt="ie=edge">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="https://fonts.googleapis.com/css2?family=Lora:wght@500&family=Merriweather:wght@300&family=Sansita+Swashed:wght@300;400&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="/public/css/dashboard.css">
		<link rel="stylesheet" href="/public/css/customer.css">
		<link rel="stylesheet" href="/public/css/chat.css">
		<link rel="icon" href="/public/images/icons/support.ico" type="image/icon">
		<title>Служба Поддержки</title>
	</head>
	<body>
		<header>
			<div class="logo">
				<h1 class="logo-text"><a href="/">SanaripKat</a></h1>
			</div>
			<i class="fa fa-bars menu-toggle"></i>
			<ul class="nav">
				<li>
					<?php
					if (isset($_SESSION['name'])) { ?>
					<a href="/customer"><?=$_SESSION['name'];?><i class="fa fa-chevron-down"></i></a>
					<?php } else { ?>
					<a href="/customer/editprofile">Настройка профиля<i class="fa fa-chevron-down"></i></a>
					<?php }
					?>
					<ul>
						<li><a href="/customer/logout" class="logout">Выйти</a></li>
					</ul>
				</li>
			</ul>
		</header>
		<!-- Page Wrapper -->
		<div class="customer-wrapper">
			<!--Left Sidebar-->
			<div class="left-sidebar">
				<?php include('application/include/customer_sidebar.php'); ?>
			</div>
			<!--//Left Sidebar-->
			<!--customer Content-->
			<div class="customer-content">
				<div class="content">
					<div class="chatbox">
						<div class="tab" style="grid-template-columns: 50% 50%;">
							<a href="javascript:void(0);" class="selected-tab">Технический отдел</a>
							<a href="javascript:void(0);">Абонентский Отдел</a>
						</div>
						<div class="chatlogs"></div>
						<div class="chat-form">
							<textarea id="textmessage" name="message" autocomplete="off" placeholder="Напишите что-то..." required><?=$quickmessage;?></textarea>
							<a href="javascript:void(0)" class="submit"><i class="far fa-paper-plane"></i></a>
						</div>
					</div>
				</div>
			</div>
			<!--//customer Content-->
		</div>
		<!-- //Page Wrapper -->
		<!-- JQuery -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- Custom -->
		<script type="text/javascript" src="/public/js/scripts.js"></script>
		<script type="text/javascript">
		    $(".tab a").click(function() {
		        $('.tab a').eq($(this).index()).addClass('selected-tab').siblings().removeClass('selected-tab');
		    });
			function listMessages()
				{
					$.ajax({
						url:'/customer/updatechat',
						success:function(res){
							$('.chatlogs').html(res);
						}
					})
				}
			$(function(){
				listMessages()
				setInterval(function(){
					listMessages();
				},10000);
				$('.submit').click(function(){
					var textmessage = $('#textmessage').val();
					$.ajax({
						url:'/customer/chat',
						data: 'message='+textmessage,
						type:'POST',
						success:function()
						{
							$('#textmessage').val('');
							listMessages();
							var last_message_pos = $('.chat-message :last-child').position();
							$('.chatlogs').animate({
        						scrollTop: last_message_pos.top
    						}, 'slow');
						}
					})
				})
			})
		</script>
	</body>
</html>