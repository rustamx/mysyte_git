<?php
echo 1 ;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://httpbin.org/post');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, '{"rule":{"value":"VALUE","tag":"TAG"}}');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$out = curl_exec($ch);
curl_close($ch);

echo $out;
// $maxsize = ini_get("post_max_size");
// $maxsize_int = (int)$maxsize;
// $KolvoBukv = strlen($maxsize)-strlen($maxsize_int);
// $rest = substr($maxsize, -$KolvoBukv);
// $teststr = "qwewqeq";
// echo $teststr {1};

// switch ($rest) {
  // case M:
  // $size = $maxsize*1000000;
    // echo $size; break;
     // case KB:
    // $size = $maxsize*1000;
    // echo $size; break;
   // default:
     // $size = $maxsize;
    // echo $size;
// }

// $Arr = [
         // "www",
         // "qqq",
         // 55=>23
        // ];
// $Arr[kkk]=25;
// unset($Arr[-11]);
// print_r($Arr);
// var_dump($Arr);

// $leftMenu = [
     // ['href'=>'index.php','about'=>'Домой'],
     // ['href'=>'about.php','about'=>'О нас'],
     // ['href'=>'contact.php','about'=>'Контакты'],
     // ['href'=>'table.php','about'=>'Таблица умножения'],
     // ['href'=>'calc.php','about'=>'Калькулятор']
         // ];

// var_dump($leftMenu);

// foreach($Arr as $k=>$test)
  // {  
  // echo "$k : $test \n";
  // };

  
// function test(){
    // static $a=0;
    // echo $a++;
// }
// test(); // 0
// test(); // 1
// test(); // 2

echo date("d-m-Y");

// var_dump ($_POST);

?>