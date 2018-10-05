<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$filter = $_GET["create_doc"];
$APPLICATION->SetTitle("Несоответствие");
$APPLICATION->IncludeComponent(
	"wejet:eos.documents.form", 
	"nonconformity", 
	array(
		"CHILD_DOC_GUID" => "",
		"CHILD_DOC_NAME" => $_REQUEST["child_doc"],
		"COMPONENT_TEMPLATE" => "nonconformity",
		"FILTER_NAME" => $filter,
		"FORMAT_DATE" => "d.m.Y",
		"FORM_CLASS" => "",
		"FORM_ID" => "",
		"MAIN_DOC_GUID" => $_REQUEST["doc_id"],
		"MAIN_DOC_NAME" => "Document_ra_Nesootvetstvie",
		"SELECT_DOC_FIELDS" => array(
			0 => "ChertezhnyjNomer",
			1 => "DataIzgotovleniyaProdukcii",
			2 => "DataPervichnojRegistracii",
			3 => "DataVyyavleniya",
			4 => "EhtapVyyavleniya",
			5 => "KlassBezopasnosti",
			6 => "KodKKS",
			7 => "KolichestvoPredyavlennoeNaKontrol",
			8 => "KolichestvoZabrakovanno",
			9 => "VidKontrolnoyOperacii",
			10 => "MestoVyyavleniyaNS",
			11 => "NaimenovanieOborudovaniya",
			12 => "NaimenovanieTekhnologicheskojSistemy",
			13 => "NarushennyeTrebovaniya",
			14 => "NomerDokumenta",
			15 => "NomerPartii",
			16 => "NomerPervichnojRegistracii",
			17 => "NomerPlanaKachestva",
			18 => "NomerVnutrennij",
			19 => "Obekt",
			20 => "Oborudovanie",
			21 => "OboznachenieINaimenovaniePredmeta",
			22 => "Ploshchadka",
			23 => "PodrobnoeOpisanie",
			24 => "Proekt",
			25 => "ProektnayaDokumentaciya",
			26 => "RabochayaDokumentaciya",
			27 => "Sertifikat",
			28 => "SpecializirovannayaOrganizaciya",
			29 => "TipNesootvetstviya",
			30 => "VidNesootvetstviya",
			31 => "VidObektaNesootvetstviya",
			32 => "VyyavivshayaOrganizaciya",
			33 => "VyyavivsheeLico",
			34 => "VyyavivsheePodrazdelenie",
			35 => "ZavodskojNomerOborudovaniya",
			36 => "ZayavkaNaKontrolnuyuOperaciyu",
			37 => "ZayavkaNaOcenkuSootvetstviya",
			38 => "ZdanieSooruzhenie",
			39 => "ВидДокумента",
			40 => "Date",
			41 => "Number",
			42 => "ObemRabot",
			43 => "Files",
			44 => "Tasks",
			45 => "PrintForms",
			46 => "FormCaption",
			47 => "ReviziyaProektnojDokumentacii",
			48 => "ReviziyaRabochejDokumentacii",
		),
		"DESCRIPTION_LENGTH" => "80"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>