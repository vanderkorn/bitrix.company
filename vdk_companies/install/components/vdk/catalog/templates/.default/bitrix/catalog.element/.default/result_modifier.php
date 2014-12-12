<?
if($arParams['ADD_SECTIONS_CHAIN'] && !empty($arResult['NAME']))
{

    $arResult['SECTION']['PATH'][] = array(

        'NAME' => $arResult['NAME'],
        'PATH' => $arResult['DETAIL_PAGE_URL']
    );

}

$res = CIBlockElement::GetByID($arResult["ID"]);
if($ar_res = $res->GetNext(false,false))
$arResult["SHOW_COUNTER"] = $ar_res["SHOW_COUNTER"]; 

?>