<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Wejet\Eos\Base1C;
use Bitrix\Main\Loader;

if(!Loader::includeModule('wejet.eos'))
    return;

$sortFields = array("Ref_Key"=>"Ref_key","Date"=>"Date","Number"=>"Number");
$arSorts = array("asc"=>GetMessage("WEJET_DESC_ASC"), "desc"=>GetMessage("WEJET_DESC_DESC"));
$arFormatDate = array("d.m.Y"=>GetMessage("WEJET_FORMAT_DATE"),"d.m.Y H:i"=>GetMessage("WEJET_FORMATE_DATE_TIME"));
$form = new Base1C;

$arDocList = array(
    "Document_ra_Nesootvetstvie"=>"Document_ra_Nesootvetstvie",
    "Document_ra_ZayavkaNaOcenkuSootvetstviya"=>"Document_ra_ZayavkaNaOcenkuSootvetstviya",
    "CreateNonconformity"=>"CreateNonconformity",
    "CreateConformityAssessment"=>"CreateConformityAssessment",
    "SystemSupport"=>"SystemSupport",
    "InformationRegister_ra_PrichinyNesootvetstvij" => "InformationRegister_ra_PrichinyNesootvetstvij",
    "InformationRegister_ra_KomandyNesootvetstvij" => "InformationRegister_ra_KomandyNesootvetstvij"

);
$arChildDoc = array(
    "Document_ra_Nesootvetstvie" => array(
        ""=>"",
        "Document_ra_Uvedomlenie"=>"Document_ra_Uvedomlenie",
        "Document_ra_VremennyeSderzhivayushchieDejstviyaIKorrekciya" => "Document_ra_VremennyeSderzhivayushchieDejstviyaIKorrekciya",
        "Document_ra_OcenkaZnachimosti"=>"Document_ra_OcenkaZnachimosti",
        "Document_ra_KorrektiruyushcheeDejstvie" => "Document_ra_KorrektiruyushcheeDejstvie",
        "Document_ra_PreduprezhdayushcheeDejstvie" => "Document_ra_PreduprezhdayushcheeDejstvie",
        "Document_ra_OtchetONesootvetstviiCHast1" => "Document_ra_OtchetONesootvetstviiCHast1",
        "Document_ra_AktObUstraneniiNesootvetstviya" => "Document_ra_AktObUstraneniiNesootvetstviya",
	)
);
$arSelectFields = array();
/*Получаем список полей формы*/
if(!empty($arCurrentValues["MAIN_DOC_NAME"]) && !empty($arCurrentValues["MAIN_DOC_GUID"])){

    /*Список полей формы для родительского документа*/
    if(empty($arCurrentValues["CHILD_DOC_NAME"])&& empty($arCurrentValues["CHILD_DOC_GUID"])){
        $arSelectFields = json_decode($form->getForm(
            $arCurrentValues["MAIN_DOC_NAME"],
            NULL,
            NULL,
            NULL
            ),true);
        if(count($arSelectFields["value"]) >0){
            $tempArr=array();
            foreach($arSelectFields["value"] as $item){
                $tempArr[$item["Name"]] = $item["Name"];
            }
            $arSelectFields = $tempArr;
            unset($tempArr);
        }
    }
    /*Список полей формы для дочернего документа*/
    if(!empty($arCurrentValues["CHILD_DOC_NAME"])){
        $arSelectFields = json_decode($form->getForm(
            $arCurrentValues["CHILD_DOC_NAME"],
            null
        ),true);
        if(count($arSelectFields["value"]) >0){
            $tempArr=array();
            foreach($arSelectFields["value"] as $item){
                $tempArr[$item["Name"]] = $item["Name"];
            }
            $arSelectFields = $tempArr;
            unset($tempArr);
        }
    }

}

$arComponentParameters = array(
	"GROUPS" => array(
        "SETTINGS" => array(
            "NAME" => GetMessage("WEJET_MAIN_SETTINGS_GROUP"),
            "SORT" => 2,
        ),
        "SETTINGS2" => array(
            "NAME" => GetMessage("WEJET_SORT_AND_FILTERING"),
            "SORT" => 3,
        ),
	),
	"PARAMETERS" => array(
        "MAIN_DOC_NAME" => array(
            "PARENT" => "SETTINGS",
            "NAME" => GetMessage("WEJET_DESC_LIST_TYPE"),
            "TYPE" => "LIST",
            "VALUES" => $arDocList,
            "REFRESH" => "Y"
        ),
        "MAIN_DOC_GUID" => array(
            "PARENT" => "SETTINGS",
            "NAME" => GetMessage("WEJET_MAIN_DOC_GUID"),
            "TYPE" => "STRING",
            "VALUES" => "",
            "DEFAULT"=> $_REQUEST["doc_id"],
            "REFRESH" => "Y"
        ),
        "CHILD_DOC_NAME" => array(
            "PARENT" => "SETTINGS",
            "NAME" => GetMessage("WEJET_DESC_LIST_ID"),
            "TYPE" => "LIST",
            "VALUES" => $arChildDoc[$arCurrentValues["MAIN_DOC_NAME"]],
            "REFRESH" => "Y"
        ),
        "CHILD_DOC_GUID" => array(
            "PARENT" => "SETTINGS",
            "NAME" => GetMessage("WEJET_CHILD_DOC_GUID"),
            "TYPE" => "STRING",
            "VALUES" => "",
            "DEFAULT"=> $_REQUEST["child_id"],
            "REFRESH" => "Y"
        ),
        "FORM_ID" => array(
            "PARENT" => "SETTINGS",
            "NAME" => GetMessage("WEJET_FORM_ID"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "FORM_CLASS" => array(
            "PARENT" => "SETTINGS",
            "NAME" => GetMessage("WEJET_FORM_CLASS"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "FILTER_NAME" => array(
            "PARENT" => "SETTINGS",
            "NAME" => GetMessage("WEJET_FILTER"),
            "TYPE" => "STRING",
            "DEFAULT" => "",
        ),
        "DESCRIPTION_LENGTH" => array(
            "PARENT" => "SETTINGS",
            "NAME" => GetMessage("WEJET_DESCRIPTION_LEN"),
            "TYPE" => "STRING",
            "DEFAULT" => 80,
        ),
        "SELECT_DOC_FIELDS" => array(
            "PARENT" => "SETTINGS2",
            "NAME" => GetMessage("WEJET_PROPERTY"),
            "TYPE" => "LIST",
            "MULTIPLE" => "Y",
            "VALUES" => $arSelectFields,
            "REFRESH" => "Y"
            //"ADDITIONAL_VALUES" => "Y",
        ),
        "FORMAT_DATE" => array(
            "PARENT" => "SETTINGS2",
            "NAME" => GetMessage("WEJET_SET_FORMAT_DATE"),
            "TYPE" => "LIST",
            "DEFAULT" => "desc",
            "VALUES" => $arFormatDate
        ),
        //"AJAX_MODE" => array(),
	),
);

