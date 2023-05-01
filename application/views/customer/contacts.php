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
		<link rel="icon" href="/public/images/icons/sms.ico" type="image/icon">
		<title>Контакты</title>
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
			<!--Customer Content-->
			<div class="customer-content">
				<!--Content-->
				<div class="content">
					<div class="tab" style="grid-template-columns: 50% 50%;">
						<a href="javascript:void(0)" class="create-group">Создать группу</a>
						<a href="javascript:void(0)" class="add-contact">Добавить контакт</a>
					</div>
					<!--Contact-container-->
					<div class="contact-container">
					<?php foreach ($groups as $group): ?>
							<div class="contact">
								<img src="/public/images/group.jpg" alt="contact profile">
								<a onclick="show_group_info(this.id)" href="javascript:void(0);" id=<?='group_'.$group['id'];?>><?=$group['name'];?></a>		
							</div>	
					<?php endforeach;
						foreach ($contacts as $contact): ?>
							<div class="contact">
								<img src="/public/images/contact.png" alt="contact profile">
								<a onclick="show_contact_info(this.id)" href="javascript:void(0);" id=<?='contact_'.$contact['id'];?>><?=$contact['fname'].' '.$contact['lname'];?></a>
							</div>
						<?php endforeach; ?>
					</div>
					<!--//Contact-container-->
					<!--Modal-bg-->
					<div class="modal-bg">
						<div class="modal">
							<!--view contact-->
							<div class="modal-view-contact">
								<div class="contact_info_content"></div>
								<span class="modal-close"><i class="fas fa-times"></i></span>
							<!--//view contact-->
							</div>
							<!--view group-->
							<div class="modal-view-group">
								<div class="group_info_content"></div>
								<span class="modal-close"><i class="fas fa-times"></i></span>
							<!--//view group-->
							</div>
							<!--modal-add-contact-->
							<div class="modal-add-contact">
								<h3 class="page-title">Новый контакт</h3>
								<span class="modal-close"><i class="fas fa-times"></i></span>
								<p class="msg"></p>
								<form action="/customer/add_contact" method="post" id="add-contact-form">
									<div>
										<label for="B06F0F6C">Имя</label>
										<input type="text" class="text-input" name="fname" id="B06F0F6C">
									</div>
									<div>
										<label for="068840FD">Фамилия</label>
										<input type="text" class="text-input" name="lname" id="068840FD">
									</div>
									<div>
										<label for="3920167F">Номер телефона</label>
										<input type="text" class="text-input" name="phone" id="3920167F">
									</div>
									<div>
										<h4 class="page-title">Группы</h4>
									</div>
									<div class="modal-contacts-container">
										<?php foreach ($groups as $group): ?>
											<div class="modal-contact">
												<input type="checkbox" class="contact-checkbox" name="contact_groups[]" value="<?=$group['group_key'];?>" id="<?='groups'.$group['id'];?>">
												<label for="<?='groups'.$group['id'];?>" class="contact-label"><?=$group['name'];?></label>
											</div>
										<?php endforeach; ?>
									</div>
									<div class="animated-submit">
										<button type="submit" class="btn btn-big" id="add-contact-btn">Добавить</button>
									</div>
								</form>
							<!--//modal-add-contact-->
							</div>
							<!--modal-create-group-->
							<div class="modal-create-group">
								<h3 class="page-title">Новая группа</h3>
								<span class="modal-close"><i class="fas fa-times"></i></span>
								<p class="msg"></p>
								<form action="/customer/create_group" method="post" id="create-group-form">
									<div>
										<label for="31d6cfe0">Название группы</label>
										<input type="text" name="group_name" class="text-input" id="31d6cfe0" required>
									</div>
									<div>
										<label for="">Описание</label>
										<textarea name="notes" id="" class="text-input"></textarea>
									</div>
									<div class="modal-group-container">
										<?php foreach ($contacts as $contact): ?>
											<div class="modal-contact">
												<input type="checkbox" class="contact-checkbox" name="group_contacts[]" value="<?=$contact['id'];?>" id="<?='contact'.$contact['id'];?>">
												<label for="<?='contact'.$contact['id'];?>" class="contact-label"><?=$contact['fname']." ".$contact['lname'];?></label>
											</div>
										<?php endforeach; ?>
									</div>
									<div class="animated-submit">
										<button type="submit" class="btn btn-big" id="create-group-btn">Добавить</button>
									</div>
								</form>
							<!--//modal-create-group-->
							</div>
						<!--//Modal-->
						</div>
					<!--//Modal-bg-->
					</div>
				<!--//Content-->
				</div>
			<!--//Customer Content-->
			</div>
		<!-- //Page Wrapper -->
		</div>
		<!-- JQuery -->
		<script type="text/javascript" src="/public/js/jquery.min.js"></script>
		<!-- Custom -->
		<script type="text/javascript" src="/public/js/scripts.js"></script>
		<script type="text/javascript">
			function show_group_info(id){
				var groupid = id.substring(6);
				$('.modal-bg').addClass('modal-bg-active');
				$('.modal-view-group').addClass('modal-active');
				$.ajax({
					url:'/customer/group_info',
					data: 'groupid='+groupid,
					type:'POST',
					success:function(res){
						$('.group_info_content').html(res);
					}
				});
			}
			function show_contact_info(id){
				var contactid = id.substring(8);
				$('.modal-bg').addClass('modal-bg-active');
				$('.modal-view-contact').addClass('modal-active');
				$.ajax({
					url:'/customer/contact_info',
					data: 'contactid='+contactid,
					type:'POST',
					success:function(res){
						$('.contact_info_content').html(res);
					}
				});
			}
			$(".tab .create-group").click(function(){
				$('.modal-bg').addClass('modal-bg-active');
				$('.modal-create-group').addClass('modal-active');
			});
			$(".tab .add-contact").click(function(){
				$('.modal-bg').addClass('modal-bg-active');
				$('.modal-add-contact').addClass('modal-active');
			});
			$(".modal-close").click(function(){
				$('.modal-bg').removeClass('modal-bg-active');
				$('.modal-create-group, .modal-add-contact, .modal-view-contact, .modal-view-group').removeClass('modal-active');
			});
		  $('#create-group-btn').click(function() {
		    ajax_insert_request('create-group-form', 'create-group-btn', 'msg', 'Добавлено', true);
		  });
		  $('#add-contact-btn').click(function() {
		    ajax_insert_request('add-contact-form', 'add-contact-btn', 'msg', 'Добавлено', true);
		  });
		</script>
	</body>
</html>