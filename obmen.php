<?PHP


// echo "$username:$password";
 function isDomainAvailible($domain){
               //Проверка на правильность  URL
               if(!filter_var($domain, FILTER_VALIDATE_URL))
               {
                       return false;
               }
               //Инициализация curl
               $curlInit = curl_init($domain);
               curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
               curl_setopt($curlInit,CURLOPT_HEADER,true);
               curl_setopt($curlInit,CURLOPT_NOBODY,true);
               curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
               //Получаем ответ
               $response = curl_exec($curlInit);
               
               echo  curl_error($curlInit);
               
               curl_close($curlInit);
              
       
               if ($response) return true;
               return false;
       }


// if (isDomainAvailible('http://82.202.253.116/RA_DO_Bitrix/hs/exchange/get_form?$user=bitrix&$metadata=Desktop')){

             // echo "Работает и готов отвечать на запросы!!";
     // }
     // else
     // {
             // echo "Сайт не работает!.";
     // }

// CURLOPT_USERPWD, "myusername:mypassword"
					


// $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL, 'https://httpbin.org/post');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS, '{"rule":{"value":"VALUE","tag":"TAG"}}');
// curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
// $out = curl_exec($ch);
// curl_close($ch);
// echo "next";
// echo $out;
// curl_setopt($curl, CURLOPT_URL, $url);
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			// curl_setopt($curl, CURLOPT_VERBOSE,true);
			// curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
			// curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
			// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			// curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
 	// curl_setopt($curl, CURLOPT_URL, $url);
			// curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			// curl_setopt($curl, CURLOPT_VERBOSE,true);
			// curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
			// curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
			// curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			// curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
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
// $leftMenu[]=['href'=>'index.php','about'=>'Домой'];
echo var_dump($leftMenu);
// $leftMenu = [
     // ['href'=>'index.php','about'=>'Домой'],
     // ['href'=>'index.php?id=about ','about'=>'О нас'],
     // ['href'=>'index.php?id=contact','about'=>'Контакты'],
     // ['href'=>'index.php?id=table','about'=>'Таблица умножения'],
     // ['href'=>'index.php?id=calc','about'=>'Калькулятор']
         // ];

echo var_dump ($ListButtons);
?>