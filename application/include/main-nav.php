<ul class="links">
	<li><a href="/">Главная</a></li>
<?php 
if (isset($_SESSION['isAdmin'])) { ?>
	<?php if ($_SESSION['isAdmin']==1) { ?>
		<li><a href="/admin">Админ панель</a></li>
	<?php }else{ ?>
		<li><a href="/customer">Профиль</a></li>
	<?php } ?>	 
<?php } else { ?>
		<li><a href="/signin">Войти</a></li>
		<li><a href="/signup">Регистрация</a></li>
<?php } ?>
	<li><a href="/documentation">Документация</a></li>
</ul>