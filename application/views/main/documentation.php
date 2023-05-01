<!DOCTYPE html>
<html>
	<head>
		<title>API Документация</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="/public/css/main.css" />
		<link rel="stylesheet" href="/public/css/prism.css" />
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
			<h1>Документация</h1>
		</div>
		<!-- Main -->
		<section id="main" class="wrapper">
			<div class="inner">
				<div class="content">
					<header>
						<h2>Быстрый старт SanaripKat</h2>
					</header>
					<p>SanaripKat API предлагает мощный онлайн сервис отправки SMS. Сообщения доставляются в течение миллисекунд и присылает ответ в формате JSON. Используя SanaripKat вы автоматизируете рутинные дела об информировании ваших клиентов и потверждении телефонных номеров кодом верификации.</br>В этой документации подробно описаны функции API, доступные параметры и руководства по интеграции на языках программирования PHP и Javascript.В нескольких строках кода ваше веб страница может отправлять текстовые сообщения с помощью программируемых SMS-сообщений SanaripKat.</p>
				</div>
				<div class="content">
					<header>
						<h2>API ответ</h2>
					</header>
					<pre><code class="language-javascript">{
  "success": true,
  "waiting": 120
}					</code></pre>
				</div>
				<div class="content">
					<header>
						<h2>PHP (cURL)</h2>
					</header>
						<pre><code class="language-php">// set phone, message and API access key 
$phone = '0777128934';
$message = 'Ваш код верификации 4839';
$message = urlencode($message);
$access_key = 'ВАШ КЛЮЧ ДОСТУПА';

// Initialize CURL:
$ch = curl_init('http://sanarip.biz.kg/send_sms?access_key='.$access_key.'&phone='.$phone.'message='.$message);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$api_result = json_decode($json, true);

// Output the "type" object inside "output"
echo $api_result['output']['type'];
						</code></pre>
				</div>
				<div class="content">
					<header>
						<h2>JavaScript - jQuery.ajax</h2>
					</header>
						<pre><code class="language-javascript">// set endpoint and your access key
var phone = '0777128934';
var message = 'Ваш код верификации 4839';
var access_key = 'ВАШ КЛЮЧ ДОСТУПА';
// get the API result via jQuery.ajax
$.ajax({
    url: 'http://sanarip.biz.kg/send_sms?access_key='+access_key+'&phone='+phone+'message='+$message,   
    dataType: 'jsonp',
    success: function(json) {

        // output the "type" object inside "output"
        alert(json.output.type);
        
    }
});
					</code></pre>
				</div>
				<div class="content">
					<header>
						<h2>Ошибки</h2>
					</header>
						<p>Если запрошенный ресурс недоступен или вызов API не удается по другой причине, возвращается ошибка JSON. Ошибки всегда сопровождаются кодом ошибки и описанием.</br>Пример ошибки: следующая ошибка возвращается, если ваш ежемесячный объем запросов API был превышен.</p>
						<pre><code class="language-json">{
  "success": false,
  "error": {
    "code": 104,
    "type": "monthly_limit_reached",
    "info": "Your monthly API request volume has been reached. Please upgrade your plan."    
  }
}						</code></pre></br>
					<header>
						<h2>Список всех ошибок</h2>
					</header>
					<div class="table-wrapper">
						<table class="alt">
							<thead>
								<tr>
									<th>Код</th>
									<th>Тип</th>
									<th>Описание</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>100</td>	
									<td>invalid_access_key</td>	
									<td>No API Key was specified or an invalid API Key was specified.</td>
								</tr>
								<tr>
									<td>101</td>	
									<td>invalid_receiver</td>	
									<td>No receiver (phone, contact, group) was specified.</td>
								</tr>
								<tr>
									<td>102</td>	
									<td>no_message</td>	
									<td>No message was specified.</td>
								</tr>
								<tr>
									<td>102</td>	
									<td>inactive_user</td>	
									<td>The current user account is not active. User will be prompted to get in touch with Customer Support.</td>
								</tr>
								<tr>
									<td>103</td>	
									<td>message_length</td>	
									<td>The length of message exceeds max length of 72 characters.</td>
								</tr>
								<tr>
									<td>104</td>	
									<td>usage_limit_reached</td>	
									<td>The maximum allowed amount of monthly API requests has been reached.</td>
								</tr>
								<tr>
									<td>105</td>	
									<td>incorrect_carrier</td>	
									<td>The carrier of phone is incorrect.</td>
								</tr>
							</tbody>
						</table>
					</div>
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
		<script src="public/js/prism.js"></script>
	</body>
</html>