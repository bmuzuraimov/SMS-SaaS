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
    <link rel="icon" href="/public/images/icons/account.ico" type="image/icon">
    <title>Изменить Данные Аккаунта</title>
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
          <h3 class="page-title">Изменить Данные Аккаунта</h3>
          <h4 class="msg"></h4>
          <form action="/customer/update_account" method="post" id="save-profile-form">
            <div>
              <label for="30a2ca5a">E-mail<span>*</span></label><br>
              <input type="text" name="email" value="<?=$customer['email'];?>" class="text-input" id="30a2ca5a" required/>
            </div>
            <div>
              <label for="6f694786">Имя<span>*</span></label><br>
              <input type="text" name="fname" value="<?=$customer['fname'];?>" class="text-input" id="6f694786" required/>
            </div>
            <div>
              <label for="lname">Фамилия<span>*</span></label><br>
              <input type="text" name="lname" value="<?=$customer['lname'];?>" class="text-input" id="lname" required/>
            </div>
            <div>
              <label for="73a1b455">Адрес<span>*</span></label><br>
              <input type="text" name="address" value="<?=$customer['address'];?>" class="text-input" id="73a1b455" required/>
            </div>
            <div>
              <label for="3c88e81a">Почтовый индекс<span>*</span></label><br>
              <input type="text" name="postcode" value="<?=$customer['postcode'];?>" class="text-input" id="3c88e81a" required/>
            </div>
            <div>
              <label for="e932b8d7">Город<span>*</span></label><br>
              <input type="text" name="city" value="<?=$customer['city'];?>" class="text-input" id="e932b8d7" required/>
            </div>
            <div>
              <label for="80078896">Область<span>*</span></label><br>
              <select name="state" class="text-input" id="80078896">
                <option <?php if ($customer['state'] == 'Баткенская область' ) echo 'selected';?> value="Баткенская область">Баткенская область</option>
                <option <?php if ($customer['state'] == 'Джалал-Абадская область' ) echo 'selected';?> value="Джалал-Абадская область">Джалал-Абадская область</option>
                <option <?php if ($customer['state'] == 'Иссык-Кульская область' ) echo 'selected';?> value="Иссык-Кульская область">Иссык-Кульская область</option>
                <option <?php if ($customer['state'] == 'Нарынская область' ) echo 'selected';?> value="Нарынская область">Нарынская область</option>
                <option <?php if ($customer['state'] == 'Ошская область' ) echo 'selected';?> value="Ошская область">Ошская область</option>
                <option <?php if ($customer['state'] == 'Таласская область' ) echo 'selected';?> value="Таласская область">Таласская область</option>
                <option <?php if ($customer['state'] == 'Чуйская область' ) echo 'selected';?> value="Чуйская область">Чуйская область</option>
              </select>
            </div>
            <div>
              <label for="a01a40b2">Компания<span>*</span></label><br>
              <input type="text" name="company" value="<?=$customer['company'];?>" class="text-input" id="a01a40b2" required/>
            </div>
            <div>
              <label for="b1ddf015">Вебсайт<span>*</span></label><br>
              <input type="text" name="website" value="<?=$customer['website'];?>" class="text-input" id="b1ddf015" required/>
            </div>
            <div class="animated-submit">
              <button type="submit" name="submit" class="btn btn-big" id="save-profile-btn">Сохранить</button>
            </div>
          </form>
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
      $('#save-profile-btn').click(function() {
        ajax_update_request('save-profile-form', 'save-profile-btn', 'msg', 'Сохранено', true);
      });
    </script>
  </body>
</html>