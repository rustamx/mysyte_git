<?php

namespace Wejet\Eos;
use \Bitrix\Main\Config\Option;
class Base1C
{

    // объявление свойства
    private $username     = '';
    private $password     = '';
    public $user_1cguid   ='';
    private $useragent    ='';
    public $base_url_http = "";
    public $auth          = CURLAUTH_BASIC;
    private $timeout      = 10;

    function __construct()
    {
       global $USER;
       $this->base_url_http = Option::get("wejet.eos", "url_api_1c");
       $this->useragent =Option::get("wejet.eos", "user_agent");
       $this->timeout = Option::get("wejet.eos", "timeout_connection");
       $this->username = Option::get("wejet.eos", "user_login");
       $this->password= Option::get("wejet.eos", "user_password");
       $user1c = $USER->GetLogin();

        if($user1c!=''){
            $sort_by = "ID";
            $sort_ord = "ASC";
            $arFilter = array("LOGIN" => $user1c,
                "ACTIVE" => 'Y',
            );
            $dbUsers = $USER->GetList($sort_by, $sort_ord, $arFilter, array('SELECT'=>array('UF_GUID', $user1c)));

            while ($arUser = $dbUsers->Fetch())
            {
                $this->username = $arUser['LOGIN'];
                $this->password='1q2w#E$R';
                $this->user_1cguid=$arUser['UF_GUID'];
            }
        }
    }

    /**
     * Метод получения контента (http запрос к внешнему серверу)
     * @param $url - string
     * @return string;
     */
    function getContent($url, $headers=array())
    {
        if(isset($_GET["debug"])){
            echo "<pre>";
            print $url;
            echo "<br>User: ".$this->username;
            echo "</pre>";
        }
        // print $url;
        // echo isset($_GET["debug"]);
        try{$curl = curl_init();
            // $headers = array('Connection: keep-alive', 'Keep-Alive: 300');
            // $headers[] = "IBSession: start";
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_VERBOSE,true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
            curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);

            $curl_response = curl_exec($curl);

            if($curl_response === false){
                if(curl_errno($curl)==28)
                    echo("<h1>Сервер 1С не отвечает</h1>");
                echo 'Ошибка curl: ' . curl_error($curl);
                curl_close($curl);
                return false;
            }
            else{
                curl_close($curl);
                return $curl_response;
            }
            curl_close($curl);
            // $response = json_decode($curl_response);
            // echo "$url\n\r";
        }
        catch (Exception $e) {
            echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
            return false;
        }

        // // Ином метод запросов к серверу 1С нативными функциями PHP
        // $b64 = base64_encode("$this->username:$this->password");
        // $auth = "Authorization: Basic $b64";
        // $opts = array (
        // 		'http' => array (
        // 			'method' => "GET",
        // 			'header' => $auth,
        // 			// 'user_agent' => '',
        // 		)
        // );
        // $context = stream_context_create($opts);
        // $res = file_get_contents($url, false, $context);
        // // echo $res;
        // return $res;


    }

    /*	Получить список объектов заданной сущности
		$obj_name - имя сущности - обязательный параметр
		$select - набор возвращаемых полей сущности
		$limit - кол-во возвращаемых объектов
		$sort - направление сортировки: asc, desc
		$last - значение сортируемого поля последнего полученного объекта (для вывода "показать еще")
		$json=true - получить поля в json-формате
		$json=false - получить готовую HTML-форму */

    public function getList($obj_name, $select='', $orderby='', $sort='asc', $limit=10, $last=NULL, $filter='', $form_settings=false, $lang="ru", $ex2ex=false)
    {
        $obj_name = urlencode($obj_name);

        /* Сбор параметров запроса */
        if (isset($filter) && $filter!=''){
            $filter = '&$filter='.$filter;
        }
        if (isset($sort)){
            $cond = ($sort=='asc'?'gt':'lt');
        }else{
            $sort = 'asc';
            $cond = 'gt';
        }

        if (isset($last)){

            if($filter!='')
                $filter .= ' and Number '.$cond.' "'.$last.'"';
            else
                $filter = '&$filter=Number '.$cond.' "'.$last.'"';
        }

        if(!isset($select))
            $select = '';
        else
            $select = '&$select='.$select;

        if(!isset($orderby)){

            if(isset($sort) && isset($last))
                $orderby = '&$orderby=Number '.$sort.',Ref_Key '.$sort;
            else
                $orderby = '';
        }else
            $orderby = '&$orderby='.$orderby;

        if($form_settings)
            $form_settings = '&$form_settings=true&$language='.$lang;
        else
            $form_settings = '';

        $export = $ex2ex ? '&$ExportToExcel=true' : '';


        $qry_str = $select.$orderby.$filter.$form_settings.$export;
        $qry_str = str_replace("\"%", "%22%25", $qry_str);
        $qry_str = str_replace("%\"", "%25%22", $qry_str);
        $qry_str = str_replace(" ", "%20", $qry_str);


        $url = $this->base_url_http.$obj_name."?"."\$top=$limit".$qry_str;
        // echo $url;

        if($ex2ex){
            $this->getFile('', false, $url);
        }

        $ret = $this->getContent($url);

        return $ret;
    }

    /*
        Метод поиска объектов по подстроке
        $user (например, user1c)
        $metadata (Catalog_Контрагенты, Catalog_ВнутренниеДокументы)
        $SearchString - строка поиска
        $filter - строка с отбором (подробнее см. пункт 1.1)
        $ResponsibleForQuality (необязательный) - ответственный за качество, может принимать значения true или false.
        Актуален только для Catalog_Пользователи. Если параметр принимает значение true,
        то поиск осуществляется только среди пользователей, ответственных за качество.
    */

    //public function getSearch($obj_name, $str, $filter='', $r4q=NULL)
    public function getSearch($post)
    {
//        if($r4q){
//            $r4qSTR = "";
//            foreach ($r4q as $key=>$value){
//                $r4qSTR .= "&\$".$key."=".$value;
//            }
//        }
//
//        $str = str_replace(" ", "%20", $str);
//        $filter = str_replace(" ", "%20", $filter);
//
//        $url = $this->base_url_http."FullTextSearch?\$user=$this->username&\$metadata=$obj_name&\$SearchString=$str&\$filter=$filter".$r4qSTR.$leader;
//
//        $resul = $this->getContent($url);
//        return $resul;
        array_walk_recursive($post,
            function (&$value,$key){
                if(strtolower($value) ==="true"|| strtolower($value ==="false")){
                    $value = (bool)$value;
                }
            }
        );
        $post = json_encode($post,JSON_UNESCAPED_UNICODE);
        $obj_name = "FullTextSearch";
        $url = $this->base_url_http.$obj_name."/?\$format=json";
        if(isset($_GET["debug"]))
            echo $url;
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
            curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $curl_response = curl_exec($curl);
            // $response = json_decode($curl_response);
            curl_close($curl);
            // echo json_encode($response);
            return $curl_response;
        }
    }

    /*	Получить список объектов заданной сущности
        $obj_name - имя сущности - обязательный параметр
        $select - набор возвращаемых полей сущности
        $limit - кол-во возвращаемых объектов
        $sort - направление сортировки: asc, desc
        $last - значение сортируемого поля последнего полученного объекта (для вывода "показать еще")
        $json=true - получить поля в json-формате
        $json=false - получить готовую HTML-форму */

    public function getTask($obj_name, $select='', $orderby='', $sort='asc', $limit=10, $last=NULL)
    {


        $obj_name = urlencode($obj_name);
        // echo $obj_name;
        /* Сбор параметров запроса */
        if (isset($sort)){
            $cond = ($sort=='asc'?'gt':'lt');
        }
        else {
            $sort = 'asc';
            $cond = 'gt';
        }
        if (isset($last)){
            $filter = '&$filter=Number '.$cond.' "'.$last.'"';
        }
        else $filter = '';

        if(!isset($select)){
            $select = urlencode($select);
            $select = '';//.$select;
        }else
            $select = '&$select='.$select;
        if(!isset($orderby)){
            $orderby = '';//'&$orderby=Number '.$sort.',Ref_Key '.$sort;
        }else
            $orderby = '&$orderby='.$orderby;

        $qry_str = $select.$orderby.$filter;
        $qry_str = str_replace(" ", "%20", $qry_str);

        $url = $this->base_url_http.$obj_name."/?\$top=$limit".$qry_str;
        // echo $url;

        $ret = $this->getContent($url);
        return $ret;
    }

    /* получение настроек формы для объекта*/

    public function getForm($obj_name, $guid=NULL, $lang='ru', $filter=NULL)
    {
        if (isset($filter)){
            $filter = str_replace(" ", "%20", $filter);
            // $filter = urlencode($filter);
            $filter = '&$filter='.$filter;
        }
        else $filter = '';
        $url = $this->base_url_http."get_form?\$user=$this->username&\$metadata=$obj_name&\$guid=$guid&\$language=$lang"."$filter";
        // echo $url;
        // echo $USER->GetLogin();
        $form_params = $this->getContent($url);
        return $form_params;
    }

    /**
     * Метод содает объект в таблице $table
     * @param $url - string
     * @return string;
     */

    public function setData($obj_name, $post)
    {
        $obj_name = str_replace(" ", "%20", $obj_name);
        $url = $this->base_url_http.$obj_name."/?\$format=json";
        if(isset($_GET["debug"]))
            echo $url;
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
            curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $curl_response = curl_exec($curl);
            // $response = json_decode($curl_response);
            curl_close($curl);
            // echo json_encode($response);
            return $curl_response;
        }
    }
    public function sendSupportForm($post){
        //send_email HTTP/1.1
        $url = $this->base_url_http."/send_email";
        if(isset($_GET["debug"]))
            echo $url;
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
            curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));

            $curl_response = curl_exec($curl);
            // $response = json_decode($curl_response);
            curl_close($curl);
            // echo json_encode($response);
            return $curl_response;
        }
    }
    public function updateData($obj_name, $guid, $post)
    {
        $obj_name = urlencode($obj_name);
        $guid = "(guid'$guid')";

        // Костыль
        if($obj_name == 'UpdateContactInformation'){
            $guid = '';
        }

        $url = $this->base_url_http.$obj_name.$guid;//."/?\$format=json";

        if(isset($_GET["debug"])){
            echo "<pre>";
            echo $url."<br>";
            echo $post;
            echo "<br>User: ".$this->username;
            echo "</pre>";
            // echo "<pre>";
            // print_r(json_decode($post));
            // echo "</pre>";
        }
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_VERBOSE,true);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
            curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
            curl_setopt($curl, CURLOPT_VERBOSE, true);

            $curl_response = curl_exec($curl);
            // $response = json_decode($curl_response);
            curl_close($curl);
            // echo json_encode($response);
            return $curl_response;
        }
    }

    public function deleteData($obj_name, $post)
    {
        $obj_name = urlencode($obj_name);
        $post = json_encode($post,JSON_UNESCAPED_UNICODE);
        $url = $this->base_url_http.$obj_name;//."/?\$format=json";
        if(isset($_GET["debug"]))
            echo $url;
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_VERBOSE,true);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
            curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $curl_response = curl_exec($curl);
            curl_close($curl);
            return $curl_response;
        }
    }

    public function getCopy($source, $reciever, $guid, $filter=NULL,$lang='')
    {
        if (isset($filter)){
            $filter = str_replace(" ", "%20", $filter);
            // $filter = urlencode($filter);
            $filter = '&$filter='.$filter;
        }
        else $filter = '';

        $url = $this->base_url_http."copy_object?\$user=$this->username&\$metadata_source=$source&\$metadata_reciever=$reciever&\$guid_source=$guid"."$filter"."&\$language=$lang";
        // if(isset($_GET["debug"]))
        // echo $url;
        $form_params = $this->getContent($url);
        return $form_params;
    }

    public function sendFile($obj_name, $guid, $path, $filename='', $extension='', $filesize, $guid_file='')
    {

        $url = $this->base_url_http."add_file";
        if(isset($_GET["debug"]))
            echo $url;


        // $curlfile = new CURLFile('1.doc', 'application/octet-stream', '1.doc');

        // if(isset($filename) && $filename != ''){
        //
        // }
        // else {
        // 	// $path
        // }

        $data = file_get_contents($path);
        $base64 = base64_encode($data);

        $array = array(
            "metadata" => $obj_name,
            "extension_file" => $extension,
            "name_file" => $filename,
            // "name_file" => iconv('windows-1251','utf-8', $filename),
            "size_file" => $filesize,
            "guid" => $guid,
            "guid_file" => $guid_file,
            "file" => $base64
        );

        $array = json_encode($array);


        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HTTPAUTH, $this->auth);
            curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $array);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/octet-stream'));

            $curl_response = curl_exec($curl);
            curl_close($curl);
            // echo $curl_response;
            return $curl_response;
        }
        return false;
    }

    public function getFile($guid, $show=false, $url=NULL)
    {
        if(is_null($url))
            $url = $this->base_url_http."get_file?\$guid=$guid";

        if(isset($_GET["debug"]))
            echo $url;

        $filename =  $url;
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }

        $b64 = base64_encode("$this->username:$this->password");
        $auth = "Authorization: Basic $b64";
        $opts = array (
            'http' => array (
                'method' => "GET",
                'header' => $auth,
                'user_agent' => $this->useragent,
            )
        );

        $context = stream_context_create($opts);

        if ($fd = fopen($url, 'rb', false, $context)) {
            if (isset($http_response_header)){
                // print_r($http_response_header);
                foreach ($http_response_header as  $key=>$val){
                    if(strpos($val, "Content-Disposition:") !== false){
                        $header_filename = $val;
                    }
                    if(strpos($val, "Content-Length::") !== false){
                        $header_filesize = $val;
                    }
                }
            }else{
                echo 'Заголовков нет';
            }

            if($show==true){
                $filename_header = str_replace("attachment", "inline", $header_filename);
                header('Content-Type: application/pdf');
                header($filename_header);
            }
            else{
                header('Content-Type: application/octet-stream');
                header('Content-Description: File Transfer');
                header($header_filename);
            }
            header($header_filesize);
            header('Content-Transfer-Encoding: binary');
            while (!feof($fd)) {
                print fread($fd, 1024);
            }
            fclose($fd);
        }
        else echo('Не удается открыть файл fopen');
        exit;

        return false;
    }
    public function getNormativeDocs($document_type=null,$top=10){
        $url = $this->base_url_http."get_normative_documents?\$document_type=$document_type&\$top=$top";

        $ret = $this->getContent($url);

        return $ret;
    }
    public function getFilesList($obj_name,$guid,$top=10,$orderby=null,$filter=null){
        if (isset($filter)){
            $filter = str_replace(" ", "%20", $filter);
            // $filter = urlencode($filter);
            $filter = '&$filter='.$filter;
        }
        else $filter = '';
        $url = $this->base_url_http."get_files_list?\$metadata=$obj_name&\$guid=$guid&\$top=$top".$filter;

        $ret = $this->getContent($url);

        return $ret;
    }
    public function getPrintForm($obj_name, $guid, $guidfile, $get=false)
    {

        $url = $this->base_url_http."GetPrintForm?\$metadata=$obj_name&\$guid=$guid&\$guidFile=$guidfile";

        if(isset($_GET["debug"]))
            echo $url;

        $filename =  $url;

        if (ob_get_level()) {
            ob_end_clean();
        }

        $b64 = base64_encode("$this->username:$this->password");
        $auth = "Authorization: Basic $b64";
        $opts = array (
            'http' => array (
                'method' => "GET",
                'header' => $auth,
                'user_agent' => $this->useragent,
            )
        );
        $context = stream_context_create($opts);

        if ($fd = fopen($url, 'rb', false, $context)) {


            // static $regex = '/^Content-Length: *+\K\d++$/im';
            // static $regex2 = '/filename=*.+$/im';
            // if (isset($http_response_header) && preg_match($regex, implode("\n", $http_response_header), $matches)){
            //   preg_match($regex2, implode("\n", $http_response_header), $matches2);
            //   $filename = $matches2[0];
            //   $filesize = (int)$matches[0];
            //   $filename = explode("=", $matches2[0]);
            // }
            // exit;
            // заставляем браузер показать окно сохранения файла
            //
            if($get==true){
                header('Content-Type: application/octet-stream');
                header('Content-Description: File Transfer');
                header("$http_response_header[3]");
            }
            else{
                $filename_header = str_replace("attachment", "inline", $http_response_header[3]);
                header('Content-Type: application/pdf');
                header($filename_header);
            }
            // Вставляем размер файла
            header("$http_response_header[7]");

            // header('Accept-Ranges:	bytes');
            // header($filename_header);
            // header('Content-Disposition: attachment; filename='.$filename[1]);
            // header('Content-Length: ' . $filesize);

            // header("$http_response_header[3]");

            // header('Content-Transfer-Encoding: binary');
            while (!feof($fd)) {
                print fread($fd, 1024);
            }
            fclose($fd);
        }
        else{
            echo('Запрошенная печатная форма не найдена.');
        }
        exit;

        return false;
    }

    public function getReportOptions()
    {
        $url = $this->base_url_http."GetReportOptions";

        $resul = $this->getContent($url);
        return $resul;
    }

    public function getReport($guid, $guidfile)
    {
        $url = $this->base_url_http."GenerateReport?\$guid=$guid&\$guidFile=$guidfile";

        // $url = $this->base_url_http."get_file?\$guid=$guid";
        if(isset($_GET["debug"]))
            echo $url;

        $filename =  $url;
        // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
        // если этого не сделать файл будет читаться в память полностью!
        if (ob_get_level()) {
            ob_end_clean();
        }

        $b64 = base64_encode("$this->username:$this->password");
        $auth = "Authorization: Basic $b64";
        $opts = array (
            'http' => array (
                'method' => "GET",
                'header' => $auth,
                'user_agent' => $this->useragent,
            )
        );

        $context = stream_context_create($opts);

        if ($fd = fopen($url, 'rb', false, $context)) {
            if (isset($http_response_header)){
                // print_r($http_response_header);
                foreach ($http_response_header as  $key=>$val){
                    if(strpos($val, "Content-Disposition:") !== false){
                        $header_filename = $val;
                    }
                    if(strpos($val, "Content-Length::") !== false){
                        $header_filesize = $val;
                    }
                }
            }else{
                echo 'Заголовков нет';
            }

            if($show==true){
                // $filename_header = str_replace("attachment", "inline", $header_filename);
                // header('Content-Type: application/pdf');
                // header($filename_header);
            }
            else{
                // header('Content-Type: application/octet-stream');
                // header('Content-Description: File Transfer');
                // header($header_filename);
            }
            // header($header_filesize);
            // header('Content-Transfer-Encoding: binary');
            while (!feof($fd)) {
                $ret .= fread($fd, 1024);
            }
            fclose($fd);
        }
        else echo('Не удается открыть файл fopen');
        // exit;

        return $ret;
    }

    public function siteURL()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'].'/';
        return $protocol.$domainName;
    }

}
