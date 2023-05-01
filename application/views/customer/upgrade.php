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
    <link rel="icon" href="/public/images/icons/upgrade.ico" type="image/icon">
    <title>Апгрейд</title>
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
          <h3>Выбранный тариф: <span class="blue"><?=$tariff['name'];?></span></h3><hr>
          <div class="content-info">
            <h3 class="page-title">Счет за Тариф</h3>
            <p>ID cчета: 803452</p>
            <p><?="Период тарифа: ".substr($from_date, 0, 10)." - ".substr($to_date, 0, 10);?></p>
            <form action="/customer/verify_transaction" method="post" id="verify-transaction-form">
              <input type="hidden" name="tsid" value="<?=$transactionid;?>">
              <input type="hidden" name="sbid" value="<?=$subscriptionid;?>">
              <div>
                <label for="30a2ca5a">Номер отправителя<span>*</span></label><br>
                <input type="text" name="phone" class="text-input" id="30a2ca5a" required/>
              </div>
              <div>
                <label for="6f694786">Сумма</label><br>
                <input type="text" name="amount" value="<?=$due_price.' сомов';?>" class="text-input" id="6f694786" readonly="readonly"/>
              </div>
              <div>
                <label>Номер транзакции<span>*</span></label><br>
                <input type="text" name="transactionid" placeholder="TX0017298660" class="text-input" required/>
              </div>
              <div class="animated-submit">
                <button type="submit" name="submit" class="btn btn-big" id="verify-transaction-btn">Потвердить</button>
              </div>
            </form>
          </div>
          <hr>
        </div>
      </div>
      <!--//customer Content-->
    </div>
    <!-- //Page Wrapper -->
    <!-- JQuery -->
    <script type="text/javascript" src="/public/js/jquery.min.js"></script>
    <!-- Sweet Alert 2 -->
    <script src="/public/js/sweetalert2.all.min.js"></script>
    <!-- Custom -->
    <script type="text/javascript" src="/public/js/scripts.js"></script>
    <script type="text/javascript">
      $("#verify-transaction-btn").click(function(){
          $.post($("#verify-transaction-form").attr("action"), $("#verify-transaction-form :input").serializeArray(), function(info){
            console.log(info);
            if(info=='success'){
              Swal.fire({
                icon: 'success',
                title: 'Ваша оплата прошла успешно',
                confirmButtonColor: '#111111',
                allowOutsideClick: false,
              }).then((result) => {
                if (result.isConfirmed) {
                  location.replace("/customer");
                }
              });
            }else if($.isNumeric(info)){
              Swal.fire({
                icon: 'warning',
                title: 'Внимание!',
                text: 'Ваш тариф еще не активирован. Ваш оставшийся долг составляет '+info+' сом',
                showDenyButton: true,
                confirmButtonText: `Оплатить`,
                denyButtonText: `Позже`,
                confirmButtonColor: '#00ba44',
                denyButtonColor: '#de0000',
                allowOutsideClick: false,
              }).then((result) => {
                if (result.isConfirmed) {
                  location.replace("/customer/upgrade");
                } else if (result.isDenied) {
                  location.replace("/customer");
                }
              });
            }else if(info=='wrong'){
              Swal.fire({
                icon: 'error',
                title: 'Ошибка',
                text: 'Введены неверные данные! Попробуйте еще раз',
                confirmButtonColor: '#111111',
                footer: '<a href="/customer/support?message=Здраствуйте, у меня возникли проблемы с оплатой">или попробуйте обратиться в <span class="blue">службу поддержки</span></a>',
                allowOutsideClick: false,
              });
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Ошибка!',
                text: 'Произошла неизвестная ошибка!',
                confirmButtonColor: '#111111',
                footer: '<a href="/customer/support?message=Здраствуйте, у меня возникли проблемы с оплатой">или попробуйте обратиться в <span class="blue">службу поддержки</span></a>',
                allowOutsideClick: false,
              });
            }
          });
      });
      $("#verify-transaction-form").submit(function(){
          return false;
      });
    </script>
  </body>
</html>