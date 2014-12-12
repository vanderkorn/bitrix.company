<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<?foreach($arResult["ITEMS"] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;?>
	<table class="data-table" cellspacing="0" cellpadding="2" style="color: black;">
	<thead>
		<tr>
			<td colspan="2" align="center"><?=GetMessage("IBLOCK_FILTER_TITLE")?></td>
		</tr>
	</thead>
	<tbody>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if(!array_key_exists("HIDDEN", $arItem)):?>
				<?if (strpos($arItem["INPUT_NAME"],'vdk_city') !== false):?> 
					<tr>
					<td valign="top"><?=$arItem["NAME"]?>:</td>
					<td valign="top">
         	            			<select name="<?=$arItem["INPUT_NAME"]?>" id="<?=$arItem["INPUT_NAME"]?>">
							<option value="" ></option>
							<?if(CModule::IncludeModule("iblock")){
							$asd = GetIBlockElementListEx("vdk_cities_type","vdk_cities");$asd->NavStart(1000);
							foreach($asd->arResult as $item) { ?>
							<option value="<?=$item["ID"]?>" <?if ($arItem["INPUT_VALUE"] == $item["ID"]){echo "selected";}?> ><?=$item["NAME"]?></option>
							<? } }?>
						</select>
					</td>
					</tr>
				<?else:?> 
					<tr>
					<td valign="top"><?=$arItem["NAME"]?>:</td>
					<td valign="top"><?=str_replace("\"text\"","\"text\" hintenable='none' ",$arItem["INPUT"])?></td>
					</tr>
				<?endif;?> 
			<?endif?>


		<?endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
				<input type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" /><input type="hidden" name="set_filter" value="Y" />&nbsp;&nbsp;<input type="submit" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>" /></td>
		</tr>
	</tfoot>
	</table>
</form>
