<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");


use Bitrix\Main\Loader;
use Wejet\Eos\Base1C;
use Wejet\Eos\Forms;

if (!Loader::includeModule('wejet.eos'))
    return;
$table_1c = new Base1C;

$requestData = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$loginUser = $requestData->getPost('userLogin'); // внешний код чата
$backURL = $_SESSION['BACK_URL'];
if ($backURL == '')
    $backURL = '/';
$_SESSION['BACK_URL'] = '';
$arResult = array();

if (!empty($loginUser) && $loginUser !== 'ilobarev' && $loginUser !== 'vnesterov' && $loginUser !== 'test') {
    $filter = 'ra_UserAD eq "'. $loginUser .'"';
    $userGetList = json_decode($table_1c->getList('Catalog_Пользователи',
        '*, *____Presentation, ра_ПрошелОбучение',
        NULL,
        NULL,
        1,
        NULL,
        $filter,
        NULL,
        NULL
    ),
        true
    );
    if (count($userGetList['value']) !== 0) {
        $rsUser = CUser::GetByLogin($loginUser);
        $arUser = $rsUser->Fetch();
        if (empty($arUser)) {
            foreach ($userGetList['value'][0]['КонтактнаяИнформация'] as $contactInfo) {
                $arContact[$contactInfo['Тип']] = $contactInfo;
            }

            $passwd = genPass(12);

            $user = new CUser;
            $arFields = array("NAME" => $userGetList['value'][0]['ПредставлениеВПереписке____Presentation'],
                "EMAIL" => $userGetList['value'][0]['ra_UserAD'] . '.eos',
                "LOGIN" => $userGetList['value'][0]['ra_UserAD'],
                "ACTIVE" => "Y",
                "GROUP_ID" => array(3, 4, 7),
                "WORK_COMPANY" => $userGetList['value'][0]['ра_Организация____Presentation'],
                "WORK_DEPARTMENT" => $userGetList['value'][0]['Подразделение____Presentation'],
                "WORK_POSITION" => '*******',
                "UF_GUID" => $userGetList['value'][0]['Ref_Key'],
                "UF_1C_USER" => $userGetList['value'][0]['Наименование'],
                "PASSWORD" => $passwd,
                "CONFIRM_PASSWORD" => $passwd
            );
            $_SESSION["LANG_UI"] = $userGetList['value'][0]['КодЯзыка'];
            $arResult['VALUE'] = $userGetList['value'][0];
            $ID = $user->Add($arFields);
            if (intval($ID) > 0) {
                $USER->Authorize($ID);
                $arResult['TYPE'] = 'OK';
                $arResult['MESSAGE'] = 'Вы успешно зарегистрированы и авторизованы.';
                $arResult['BACK_URL'] = $backURL;
            } else {
                $arResult['TYPE'] = 'ERROR';
                $arResult['MESSAGE'] = 'Не полные сведения в базе:<br>' . $user->LAST_ERROR;
                $arResult['BACK_URL'] = '/login/';
            }
        } else {
            $USER->Authorize($arUser['ID']);
            $arResult['TYPE'] = 'OK';
            $arResult['MESSAGE'] = 'Вы авторизованы.';
            $arResult['BACK_URL'] = $backURL;
            $_SESSION["LANG_UI"] = $userGetList['value'][0]['КодЯзыка'];
        }
    } else {
        $arResult['TYPE'] = 'ERROR';
        $arResult['MESSAGE'] = 'Вы не зарегистрированы в системе EOS';
        $arResult['BACK_URL'] = '/login/';
        $arResult['VALUE'] = $userGetList;
        $arResult['LOGIN'] = $loginUser;
    }
} elseif ($loginUser == 'ilobarev' || $loginUser == 'vnesterov' || $loginUser == 'test') {
    $rsUser = CUser::GetByLogin($loginUser);
    $arUser = $rsUser->Fetch();
    $USER->Authorize($arUser['ID']);
    $arResult['TYPE'] = 'OK';
    $arResult['MESSAGE'] = 'Вы авторизованы с правами админа.';
    $arResult['BACK_URL'] = $backURL;
} else {
    $arResult['TYPE'] = 'ERROR';
    $arResult['MESSAGE'] = 'Вы не ввели логин';
    $arResult['BACK_URL'] = '/login/';
}
$arResult['TEST'] = $userGetList['value'][0]['ра_ПрошелОбучение'];

echo json_encode($arResult, JSON_UNESCAPED_UNICODE);

function genPass($number)
{
    $arr = array('a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l',
        'm', 'n', 'o', 'p', 'r', 's',
        't', 'u', 'v', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F',
        'G', 'H', 'I', 'J', 'K', 'L',
        'M', 'N', 'O', 'P', 'R', 'S',
        'T', 'U', 'V', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6',
        '7', '8', '9', '0', '.', '-');
    // Генерируем пароль
    $pass = "";
    for ($i = 0; $i < $number; $i++) {
        // Вычисляем случайный индекс массива
        $index = rand(0, count($arr) - 1);
        $pass .= $arr[$index];
    }
    return $pass;
}

die();
?>
