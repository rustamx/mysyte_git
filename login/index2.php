<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if($USER->IsAuthorized())
{
	LocalRedirect("/");
}
if (is_string($_REQUEST["backurl"]) && strpos($_REQUEST["backurl"], "/") === 0)
{
	LocalRedirect($_REQUEST["backurl"]);
}
$APPLICATION->SetTitle("Вход на сайт");
$getToken = $_GET['authToken'];
$getToken1 = base64_decode($getToken, false);
$getToken2 = str_replace('}{', ',', $getToken1);
$getToken3 = json_decode(strtok($getToken2, '}').'}', true);
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
<div style="width: 100%; float: left; position: relative"><? print_r($getToken1)?></div>
<hr style="width: 100%; float: left; position: relative">
<div style="width: 100%; float: left; position: relative"><? print_r($getToken2)?></div>
<hr style="width: 100%; float: left; position: relative">
<div style="width: 100%; float: left; position: relative"><pre><? print_r($getToken3)?></pre></div>
<hr style="width: 100%; float: left; position: relative">
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>