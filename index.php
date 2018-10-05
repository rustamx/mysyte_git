<?php
// error_reporting(0);
//echo var_dump($_SERVER["DOCUMENT_ROOT"]);
echo 11;
$filefolder = $_SERVER["DOCUMENT_ROOT"]."/inc/";
require  $filefolder."lib.inc.php";
// Установка перехватчика ошибок
set_error_handler("myError");
require  $filefolder."data.inc.php";
// Инициализация заголовков страницы 
$title = 'Сайт нашей школы'; 
$header = "$welcome, Гость!"; 
$id = strtolower(strip_tags(trim($_GET['id']))); 
// echo $_GET['id'];
switch($id){ 
  case 'about': 
    $title = 'О сайте'; 
    $header = 'О нашем сайте'; 
    break; 
  case 'contact': 
    $title = 'Контакты'; 
    $header = 'Обратная связь'; 
    break; 
  case 'table': 
    $title = 'Таблица умножения'; 
    $header = 'Таблица умножения'; 
    break; 
  case 'calc': 
    $title = 'Он-лайн калькулятор'; 
    $header = 'Калькулятор'; 
    break; 
} 
?> 
<!DOCTYPE html>
<html>
<head>
  <title> <?php echo $title?> </title>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="style.css" />
  <link href="stylebitrix.css" type="text/css" data-template-style="true" rel="stylesheet" />
</head>
<body>
  <div id="header">
    <?php 
    require $filefolder.'top.inc.php';
    ?>
  </div>
  
  
  
  
  
  
  <div id="content">
    <!-- Заголовок -->
    <h1><?php echo $header?></h1>
    <!-- Заголовок -->
    <!-- Область основного контента -->
       <?php 
         switch($id){ 
           case 'about': 
             include 'about.php'; 
             break; 
           case 'contact': 
             include 'contact.php'; 
             break; 
           case 'table': 
             include 'table.php'; 
             break; 
           case 'calc': 
             include 'calc.php'; 
             break; 
           default: 
             include $filefolder.'index.inc.php'; 
         } 
        ?> 
    <!-- Область основного контента -->
  </div>
  
  	<div class="left_bar">
				<div class="reg_block">
					<h2>Создание</h2>
					<a href="#add_control_operation" class="eos_btn turquoise_btn two_line popup-with-form hidden">
						Контрольная<br> операция
					</a>
					<a href="/create_new_doc.php?ajaxForm=nonconformity"
						 class="eos_btn middle_red_btn ajaxPopUp
						 						 "
						 data-typeopen="div"
						 data-mfp="add_nonconformity"
					>
						Nonconformity					</a>
					<a href="/create_new_doc.php?ajaxForm=conformity_assessment"
						 class="eos_btn middle_blue_btn two_line ajaxPopUp
                        "
						 data-typeopen="div"
						 data-mfp="add_conformity_assessment"
					>
              Application for conformity assessment					</a>
				</div>
				<nav class="left_menu">
					<ul>
																				<li class="">
								<a href="/">My tasks</a>
							</li>
																				<li class="">
								<a href="/nonconformity/">Nonconformities</a>
							</li>
																				<li class="">
								<a href="/zayavkanaocenkusootvetstviya/">Applications for conformity assessment</a>
							</li>
																				<li class="">
								<a href="/reports/">Reports</a>
							</li>
																				<li class="">
								<a href="/normativedocuments/">Normative documents</a>
							</li>
																				<li class="">
								<a href="/systemsupport/">System support</a>
							</li>
											</ul>
				</nav>
				<div class="mobile_apps_block hidden">
					<h3>Мобильное приложение</h3>
					<a href="#">
						<i class="fab fa-app-store"></i>
						<span>Скачать в<br>APP Store</span>
					</a>
					<a href="#">
						<i class="fab fa-google-play"></i><span>Скачать в<br>Google Play</span>
					</a>
				</div>
			</div>
  
  
  
  
  
  <div id="nav">
    <!-- Навигация -->
    
			


    <?php
    require $filefolder.'menu.inc.php';
    ?>
    <!-- Навигация -->
  </div>
  <div id="footer">
    <!-- Нижняя часть страницы -->
    <?php
    require $filefolder.'bottom.inc.php';
    ?>
    <!-- Нижняя часть страницы -->
  </div>
</body>
</html>