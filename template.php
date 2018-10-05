<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?empty($arParams["CHILD_DOC_NAME"])?$Table=$arParams["CHILD_DOC_NAME"]:$Table=$arParams["MAIN_DOC_NAME"];?>
<?use Wejet\Eos\Forms;?>
<?$form = new Forms?>
<!--<pre>--><?//print_r($arResult)?><!--</pre>-->
<!--<pre>--><?////print_r($_SERVER)?><!--</pre>-->
<!--<pre>--><?////print_r($_GET)?><!--</pre>-->
<!--<pre>--><?//print_r($arParams)?><!--</pre>-->
<?
!empty($arResult["FORM"]["NomerVnutrennij"]["Value"])?$docInnerNumber = "/".$arResult["FORM"]["NomerVnutrennij"]["Value"]:$docInnerNumber="";
?>
<section id="create_inconsistencies" class="ajaxDoc" data-document="<?=$arParams["MAIN_DOC_NAME"]?>">
	<?if(isset($_REQUEST["ajaxCopyDoc"])) $GLOBALS['APPLICATION']->RestartBuffer();?>
	<div class="create_operation_header">
		<div class="create_operation_title_wrap table">
			<div class="create_operation_title table_cell v_middle">
				<?$docNumber = trim((int)$arResult["FORM"]["Number"]["Value"])?>
				<h1><?=$arResult["DOC_HEADER"]?> <?=$docNumber==0?"":$docNumber?><?=$docInnerNumber?></h1>
				<span class="create_operation_date"><?=$arResult["FORM"]["Date"]["Value"]?></span>
			</div>
			<div class="volume_works table_cell text_right v_middle">
          <?$arResult["FORM"]["ObemRabot"]["Value"]==""?$class="undefined":$class=strtolower($arResult["FORM"]["ObemRabot"]["Value"])?>
				<span class="volume_work <?=$class?>"><?=$class=="undefined"?"?":$arResult["FORM"]["ObemRabot"]["Value"]?></span>
			</div>
		</div>
		<div class="create_operation_documents">
			<div class="table">
				<div class="table_row">
					<div class="table_cell"><?=$arResult["FORM"]["EhtapVyyavleniya"]["Description"]?>:
						<span> <?=$arResult["FORM"]["EhtapVyyavleniya"]["Presentation"]?></span>
					</div>
				</div>
				<div class="table_row">
					<div class="table_cell"><?=$arResult["FORM"]["VidObektaNesootvetstviya"]["Description"]?>:
						<span> <?=$arResult["FORM"]["VidObektaNesootvetstviya"]["Presentation"]?></span>
					</div>
				</div>
			</div>
			<div class="related_documents table hidden">
				<div class="table_cell">Документ основание:<a href="#">Контрольная операция №1257/2</a></div>
			</div>
		</div>
		<div class="status_operation">
			<ul class="step_creation hidden">
				<li class="active current_step">
					<h4>Этап 1</h4><span>Уведомление</span>
				</li>
				<li>
					<h4>Этап 2</h4><span>Команда<br>и описание</span>
				</li>
				<li>
					<h4>Этап 3</h4><span>ВСД<br>и Коррекция</span>
				</li>
				<li>
					<h4>Этап 4</h4><span>Оценка<br>объема работ</span>
				</li>
				<li>
					<h4>Этап 5</h4><span>Коренная<br>причина</span>
				</li>
				<li>
					<h4>Этап 6</h4><span>Коррект.<br>действие</span>
				</li>
				<li>
					<h4>Этап 7</h4><span>Предупрежд.<br>действие</span>
				</li>
			</ul>
		</div>
		<div class="table">
			<div class="table_row">
				<div class="table_cell copy_doc_link_wrap">
					<?$duplicate = $arResult["BUTTONS"]["Duplicate"]?>
					<a class="copy_doc<?=$duplicate["Visibility"]!=1?" hidden":null;$duplicate["Availability"]!=1?" disabled":null;?>" href="javascript:void(0)"><?=$duplicate["Description"]?></a>
				</div>
				<div class="table_cell">
            <?if(count($arResult["FORM"]["PrintForms"]["Value"]) > 0):?>
							<div class="create_operation_documents_links">
								<span class="print_icon"><i class="fas fa-print"></i></span>
								<div class="custom_select simple_select print_forms_select">
									<span><?=$arResult["FORM"]["PrintForms"]["Presentation"]?></span>
									<div class="custom_select_options">
										<ul>
                        <?foreach ($arResult["FORM"]["PrintForms"]["Value"] as $item):?>
													<li data-val="<?=$item["guid"]?>">
														<a class="iframe-popup" href="/ajax/downloadFile.php?obj_name=<?=$arParams["MAIN_DOC_NAME"]?>&amp;doc_guid=<?=$_REQUEST["doc_id"]?>&amp;pf_guid=<?=$item["guid"]?>&amp;show=1"><?=$item["name"]?></a>
													</li>
                        <?endforeach;?>
										</ul>
									</div>
								</div>
							</div>
            <?endif;?>
				</div>
			</div>
		</div>
	</div>
	<?$step=$_GET["step"];?>
	<pre><?//print_r($arResult["MAIN_MENU"])?></pre>
	<nav class="menu_step_operation <?if(empty(trim($arResult["FORM"]["Number"]["Value"]))):?>hidden<?endif;?>">
		<div class="owl-carousel">
			<div class="menu_step_operation_item">
				<div class="table">
					<div class="table_cell v_bottom">
						<a href="mainForm.php?doc_id=<?=$_GET["doc_id"]?>" class="<?=!$step?"active":""?>">
							<?$Description = explode(" ",$arResult["MAIN_MENU"]["Description"]["Description"],2)?>
							<?=$Description[0]?><br><?=$Description[1]?>
						</a>
					</div>
				</div>
			</div>
			<div class="menu_step_operation_item">
				<div class="table">
					<div class="table_cell v_bottom">
						<a href="notifications.php?doc_id=<?=$_GET["doc_id"]?>&step=notifications" class="<?=$step=="notifications"?"active":""?>">
                <?$Description = explode(" ",$arResult["MAIN_MENU"]["Notification"]["Description"],2)?>
                <?=$Description[0]?><br><?=$Description[1]?>
						</a>
					</div>
				</div>
			</div>
			<div class="menu_step_operation_item">
				<div class="table">
					<div class="table_cell v_bottom">
						<a href="teamBuilding.php?doc_id=<?=$_GET["doc_id"]?>&step=team_building" class="<?=$step=="team_building"?"active":""?>">
                <?$Description = explode(" ",$arResult["MAIN_MENU"]["FormingTheTeam"]["Description"],2)?>
                <?=$Description[0]?><br><?=$Description[1]?>
						</a>
					</div>
				</div>
			</div>
			<div class="menu_step_operation_item">
				<div class="table">
					<div class="table_cell v_bottom">
						<a href="vsd.php?doc_id=<?=$_GET["doc_id"]?>&step=vsd" class="<?=$step=="vsd"?"active":""?>">
                <?$Description = explode(" ",$arResult["MAIN_MENU"]["Correction"]["Description"],2)?>
                <?=$Description[0]?><br><?=$Description[1]?>
						</a>
					</div>
				</div>
			</div>
			<div class="menu_step_operation_item">
				<div class="table">
					<div class="table_cell v_bottom">
						<a href="root.php?doc_id=<?=$_GET["doc_id"]?>&step=root_cause" class="<?=$step=="root_cause"?"active":""?>">
                <?$Description = explode(" ",$arResult["MAIN_MENU"]["Definition"]["Description"],2)?>
                <?=$Description[0]?><br><?=$Description[1]?>
						</a>
					</div>
				</div>
			</div>
			<div class="menu_step_operation_item">
				<div class="table">
					<div class="table_cell v_bottom">
						<a href="correctiveActions.php?doc_id=<?=$_GET["doc_id"]?>&step=corrective" class="<?=$step=="corrective"?"active":""?>">
                <?$Description = explode(" ",$arResult["MAIN_MENU"]["CorrectiveActions"]["Description"],2)?>
                <?=$Description[0]?><br><?=$Description[1]?>
						</a>
					</div>
				</div>
			</div>
			<div class="menu_step_operation_item">
				<div class="table">
					<div class="table_cell v_bottom">
						<a href="preventiveActions.php?doc_id=<?=$_GET["doc_id"]?>&step=preventive" class="<?=$step=="preventive"?"active":""?>">
                <?$Description = explode(" ",$arResult["MAIN_MENU"]["WarningAction"]["Description"],2)?>
                <?=$Description[0]?><br><?=$Description[1]?>
						</a>
					</div>
				</div>
			</div>
			<div class="menu_step_operation_item">
				<div class="table">
					<div class="table_cell v_bottom">
						<a href="final_report.php?doc_id=<?=$_GET["doc_id"]?>&step=final_report" class="<?=$step=="final_report"?"active":""?>">
                <?$Description = explode(" ",$arResult["MAIN_MENU"]["FinalReport"]["Description"],2)?>
                <?=$Description[0]?><br><?=$Description[1]?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</nav>
	<div id="ajax_content">

      <?switch ($_GET["step"]){
          case "notifications" :
              require_once ($_SERVER['DOCUMENT_ROOT'].'/inconsistencies/notifications.php');
              break;
          case "team_building":
              require_once ($_SERVER['DOCUMENT_ROOT'].'/inconsistencies/teamBuilding.php');
              break;
          case "vsd":
              require_once ($_SERVER['DOCUMENT_ROOT'].'/inconsistencies/vsd.php');
              break;
          case "preventive":
              require_once ($_SERVER['DOCUMENT_ROOT'].'/inconsistencies/preventiveActions.php');
              break;
          case "root_cause":
              require_once ($_SERVER['DOCUMENT_ROOT'].'/inconsistencies/root.php');
              break;
          case "final_report":
              require_once ($_SERVER['DOCUMENT_ROOT'].'/inconsistencies/final_report.php');
              break;
          case "corrective":
              require_once ($_SERVER['DOCUMENT_ROOT'].'/inconsistencies/correctiveActions.php');
              break;
          default:
              require_once ($_SERVER['DOCUMENT_ROOT'].'/inconsistencies/mainForm.php');
      }?>

	</div>
    <?if(isset($_REQUEST["ajaxCopyDoc"])) die();?>
</section>



