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
		<link rel="icon" href="/public/images/icons/subscription.ico" type="image/icon">
		<title>Тарифы</title>
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
					<h3>Ваш тариф: <?=$subscription['subscription_type'];?></h3>
					<div class="content-info">
						<p>Тариф: <?=$subscription['subscription_type'];?></p>
						<p>Расчетный период: <?php echo substr($subscription['from_date'], 0, 10)." - ".substr($subscription['to_date'], 0, 10);?></p>
						<p>API потребление: <?php echo round($subscription['used_requests']/$subscription['month_requests']*100)."% (".$subscription['used_requests']." / ".$subscription['month_requests'].") ";?><a href="/customer/usage">API Usage</a></p>
					</div>
					<div class="content-plans">
						<?php $upgrade_btn = "Понизить";
						foreach ($tariffs as $tariff): 
						$annual_price = ($tariff['monthly_price']*0.12)*(100-$tariff['yearly_discount']);
						?>
						<div class="plan <?php if ($tariff['name'] ==  $subscription['subscription_type']) echo 'current';?>">
							<h4 class="plan-title"><?=$tariff['name'];?></h4>
							<h3 class="plan-price"><?=number_format($tariff['monthly_price']);?> сомов</h3>
							<?php if ($tariff['name']=='Бесплатный') {
								echo "<p>Без скрытых комиссий</p>";
								echo "<p class=\"plan-price-year\">-</p>";
							} else {
								echo "<p>Цена/месяц</p>";
								echo "<p class=\"plan-price-year\">или ".number_format($annual_price)." сомов/год</p>";
							}
							if ($tariff['name'] ==  $subscription['subscription_type']) { 
								$upgrade_btn = "Повысить";
								?>
								<a href="javascript:void(0)" class="current-btn"><?="до ".substr($subscription['to_date'], 0, 10);?></a>
							<?php } else { ?>
								<a href="javascript:void(0)" class="upgrade-btn" id="upgrade_<?=$tariff['id'];?>"><?=$upgrade_btn;?></a>
							<?php }
							?>
							<p><?=$tariff['sms_quantity'];?> смс</p>
							<p>Время: до <?=$tariff['period'];?> секунд</p>
							<p>Устройство: <?=$tariff['device_type'];?></p>
							<p>Отправитель: <?=$tariff['sender'];?></p>
							<p><?=$tariff['customer_support'];?></p>
						</div>
						<?php endforeach; ?>
					</div>
					<div class="content-info">
						<p>Нужно больше смс? Запросите индивидуальное решение прямо сейчас » <a href="/customer/support" class="blue">Служба поддержки</a></p>
					</div>
					<div class="modal-bg">
						<div class="modal">
							<?php foreach ($tariffs as $tariff): 
							$annual_price = ($tariff['monthly_price']*0.12)*(100-$tariff['yearly_discount']);
							?>
							<div class="modal-tariff" id="modal_<?=$tariff['id'];?>">
								<span class="modal-close"><i class="fas fa-times"></i></span>
								<h3 class="teal">Апгрейд</h3>
								<p>Пожалуйста подтвердите предпочитаемую периодичность оплаты вашего нового тарифа.</p>
								<div class="modal-btn-group">
									<a href="/customer/upgrade?payment_type=monthly&tariff=<?=$tariff['id'];?>"><?=$tariff['monthly_price'];?> сомов в месяц</a>
									<a href="/customer/upgrade?payment_type=annually&tariff=<?=$tariff['id'];?>"><?=$annual_price." сомов в год";?> <span class="green"><?="-".$tariff['yearly_discount']."%";?></span></a>
								</div>
							</div>
							<?php endforeach; ?>
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
			$(".upgrade-btn").click(function(){
				var buttonid = this.id;
				buttonid = buttonid.substring(8);
				var modalid = '#modal_'+buttonid;
				$('.modal-bg').addClass('modal-bg-active');
				$(modalid).addClass('modal-active');
			});
			$(".modal-close").click(function(){
				$('.modal-bg').removeClass('modal-bg-active');
				$('.modal-tariff').removeClass('modal-active');
			});			
		</script>
	</body>
</html>