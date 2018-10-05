<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Несоответствия");
$APPLICATION->IncludeComponent(
	"wejet:eos.documents.list", 
	".default", 
	array(
		"AJAX_MODE" => "Y",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "Y",
		"AJAX_OPTION_JUMP" => "Y",
		"AJAX_OPTION_STYLE" => "Y",
		"CHILD_DOC_NAME" => "",
		"COUNT_DOC_ON_PAGE" => "10",
		"FILTER_NAME" => "",
		"MAIN_DOC_GUID" => $_REQUEST["doc_id"],
		"MAIN_DOC_NAME" => "Document_ra_Nesootvetstvie",
		"SELECT_DOC_FIELDS" => array(
		),
		"SORT_BY1" => "Number",
		"SORT_BY2" => "Ref_Key",
		"SORT_ORDER1" => "desc",
		"SORT_ORDER2" => "desc",
		"COMPONENT_TEMPLATE" => ".default",
		"SHOW_SEARCH_FILTERS" => "Y",
		"MAIN_ORDER_SORT" => "desc",
		"FORMAT_DATE" => "d.m.Y",
		"PAGE_PATH" => "/inconsistencies/"
	),
	false
);?>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
