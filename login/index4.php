
<!DOCTYPE html>
<html lang="ru">
  <head>
      <script>
          var newDate = new Date("2018-09-24T21:29:10+03:00");
      </script>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="robots" content="index, follow" />
<link href="/bitrix/cache/css/s1/EOS_local_nonRegister/kernel_main/kernel_main.css?15347745413040" type="text/css" rel="stylesheet" />
<link href="/bitrix/cache/css/s1/EOS_local_nonRegister/template_7299e00236d7fcb9c42cdc16bb847730/template_7299e00236d7fcb9c42cdc16bb847730.css?1534928165196484" type="text/css" data-template-style="true" rel="stylesheet" />
<script type="text/javascript">if(!window.BX)window.BX={};if(!window.BX.message)window.BX.message=function(mess){if(typeof mess=='object') for(var i in mess) BX.message[i]=mess[i]; return true;};</script>
<script type="text/javascript">(window.BX||top.BX).message({'JS_CORE_LOADING':'Загрузка...','JS_CORE_NO_DATA':'- Нет данных -','JS_CORE_WINDOW_CLOSE':'Закрыть','JS_CORE_WINDOW_EXPAND':'Развернуть','JS_CORE_WINDOW_NARROW':'Свернуть в окно','JS_CORE_WINDOW_SAVE':'Сохранить','JS_CORE_WINDOW_CANCEL':'Отменить','JS_CORE_WINDOW_CONTINUE':'Продолжить','JS_CORE_H':'ч','JS_CORE_M':'м','JS_CORE_S':'с','JSADM_AI_HIDE_EXTRA':'Скрыть лишние','JSADM_AI_ALL_NOTIF':'Показать все','JSADM_AUTH_REQ':'Требуется авторизация!','JS_CORE_WINDOW_AUTH':'Войти','JS_CORE_IMAGE_FULL':'Полный размер'});</script>
<script type="text/javascript">(window.BX||top.BX).message({'LANGUAGE_ID':'ru','FORMAT_DATE':'DD.MM.YYYY','FORMAT_DATETIME':'DD.MM.YYYY HH:MI:SS','COOKIE_PREFIX':'BITRIX_SM','SERVER_TZ_OFFSET':'10800','SITE_ID':'s1','SITE_DIR':'/','USER_ID':'','SERVER_TIME':'1537813750','USER_TZ_OFFSET':'0','USER_TZ_AUTO':'Y','bitrix_sessid':'72c9be70b1e1f18182c150ae0553540a'});</script>


<script type="text/javascript"  src="/bitrix/cache/js/s1/EOS_local_nonRegister/kernel_main/kernel_main.js?1534853237124949"></script>
<script type="text/javascript">BX.setJSList(['/bitrix/js/main/core/core.js','/bitrix/js/main/core/core_fx.js','/bitrix/js/main/core/core_ajax.js','/bitrix/js/main/json/json2.min.js','/bitrix/js/main/core/core_ls.js','/bitrix/js/main/session.js','/local/templates/EOS_local_nonRegister/js/scripts.min.js','/local/templates/EOS_local_nonRegister/js/common.js','/local/templates/EOS_local_nonRegister/js/test_api.js','/local/templates/EOS_local_nonRegister/js/global.js']); </script>
<script type="text/javascript">BX.setCSSList(['/bitrix/js/main/core/css/core.css','/local/templates/EOS_local_nonRegister/css/fonts.min.css','/local/templates/EOS_local_nonRegister/css/fontawesome-all.css','/local/templates/EOS_local_nonRegister/css/main.min.css','/local/templates/EOS_local_nonRegister/styles.css']); </script>


<script type="text/javascript"  src="/bitrix/cache/js/s1/EOS_local_nonRegister/template_297662a3800e5f8e3bba1319240fe121/template_297662a3800e5f8e3bba1319240fe121.js?1535979668686100"></script>

    <meta charset="utf-8">
    <title>Вход на сайт</title>
    <meta description content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta property="og:image" content="path/to/image.jpg">
    <link rel="shortcut icon" href="/local/templates/EOS_local_nonRegister/img/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="/local/templates/EOS_local_nonRegister/img/favicon/apple-touch-icon.png">
    <link rel="apple-touch-icon" size="72x72" href="/local/templates/EOS_local_nonRegister/img/favicon/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" size="114x114" href="/local/templates/EOS_local_nonRegister/img/favicon/apple-touch-icon-114x114.png">
    <!--Chrome, Firefox OS and Opera-->
    <meta name="theme-color" content="#000">
    <!--Windows Phone-->
    <meta name="msapplication-navbutton-color" content="#000">
    <!--iOS Safari-->
    <meta name="apple-mobile-web-app-status-bar-style" content="#000">
	</head>
  <body>
		<header>
			<div class="logo table_cell">
				<a href="/"><img src="/local/templates/EOS_local_nonRegister/img/logo_rus.png" alt="ЕОС"></a>
			</div>
			<div class="search_header table_cell"></div>
			<div class="header_date_time_wrap table_cell">
				<div class="header_time"><span class="timeZone">GMT +3</span><span class="hour"></span><span class="dotTime">:</span><span class="minute"></span></div>
				<div class="header_date"></div>
			</div>
		</header>


<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//if($USER->IsAuthorized())
//{
//	LocalRedirect("/");
//}
if (is_string($_REQUEST["backurl"]) && strpos($_REQUEST["backurl"], "/") === 0)
{
	//LocalRedirect($_REQUEST["backurl"]);
}
//$APPLICATION->SetTitle("Вход на сайт");


$my_array=array("Вася Пупкин"=>"первый",
"Христофор Бонифатич"=>"второй",
"Человек и Пароход"=>"третий",
"Вольдемарыч"=>"четвертый",
"Харитоныч"=>"пятый",
"Пупырышкин"=>"шестой",
"Абдурахамныч"=>"седьмой");
print_r($_SERVER);

//echo $_SERVER;
?>
<div class="authSystem">
	<div class="">
		<div>
			<form name="userAuth" action="" method="POST" enctype="multipart/form-data">
				<h1>Авторизация</h1>
				<p>Введите логин</p>
				<input name="userLogin" placeholder="логин@домен" value="">
				<button type="submit">Авторизоваться</button>
				<div class="systemMessage"></div>
			</form>
		</div>
	</div>
</div>
<div class="authSystem">
	<div class="">
		<div>
			<form name="userAuth" action="" method="Get" enctype="multipart/form-data">
				<h1>Авторизация</h1>
				<p>Введите логин</p>
				<input name="userLogin" placeholder="логин@домен" value="">
				<button type="submit">Авторизоваться</button>
				<div class="systemMessage"></div>
			</form>
		</div>
	</div>
</div>
</body>
</html>
<?
//require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>