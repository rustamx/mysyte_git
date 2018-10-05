 <?php 
  // Установка локали и выбор значений даты 
setlocale(LC_ALL, "russian"); 
$day = strftime('%d'); 
$mon = iconv("windows-1251", "UTF-8", strftime('%B'));
$year = strftime('%Y'); 
  
$hour = (int) strftime('%H'); 
$welcome = ''; // Инициализируем переменную для приветствия 
  if ($hour>=0 && $hour<=6 ) {$welcome = "Доброй ночи";}
elseif ($hour>6 && $hour<=12 ) $welcome = "Доброго утра"; 
elseif ($hour>12 && $hour<=18 ) $welcome = "Добрый день";
else $welcome = "Добрый вечер"; 
//echo $welcome;

// $leftMenu = [
     // ['href'=>'index.php','about'=>'Домой'],
     // ['href'=>'index.php?id=about ','about'=>'О нас'],
     // ['href'=>'index.php?id=contact','about'=>'Контакты'],
     // ['href'=>'index.php?id=table','about'=>'Таблица умножения'],
     // ['href'=>'index.php?id=calc','about'=>'Калькулятор']
         // ];
         
$maxsize = ini_get("post_max_size");
$maxsize_int = (int)$maxsize;
$KolvoBukv = strlen($maxsize)-strlen($maxsize_int);
$rest = substr($maxsize, -$KolvoBukv);
// echo []{
  
// }

switch ($rest) {
  case M:
  $size = $maxsize*1000000;
 break;
     case KB:
    $size = $maxsize*1000;
break;
   default:
     $size = $maxsize;
break; 
} 
$username='Kargu@rosatom_dev';
$password='1q2w#E$R';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'http://82.202.253.116/RA_DO_Bitrix/hs/exchange/get_form?$metadata=Desktop');
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_VERBOSE,true);
curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
curl_setopt($curl, CURLOPT_TIMEOUT, 10);
$out = curl_exec($curl);
curl_close($curl);
$arr1C = json_decode($out,true,10);
$value = $arr1C["value"];
$ListButtons = $value["ListButtons"];
foreach ($ListButtons as  $key => $val) {
    //echo "$key : $val\n";  
    //echo $val["Description"];
  $leftMenu[]=['href'=>'index.php','about'=>$val["Description"]];  
}        
?>