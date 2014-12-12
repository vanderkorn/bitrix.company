<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/wizard.php");
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/install/wizard_sol/utils.php");
if (class_exists("vdk_companies")) return;
Class vdk_companies extends CModule
{
var $MODULE_ID = "vdk_companies";
var $MODULE_VERSION;
var $MODULE_VERSION_DATE;
var $MODULE_NAME;
var $MODULE_DESCRIPTION;
var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

function vdk_companies()
{
$arModuleVersion = array();

$path = str_replace("\\", "/", __FILE__);
$path = substr($path, 0, strlen($path) - strlen("/index.php"));
include($path."/version.php");

if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
{
$this->MODULE_VERSION = $arModuleVersion["VERSION"];
$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
}

$this->MODULE_NAME = "vdk_companies – модуль с компонентом";
$this->MODULE_DESCRIPTION = "После установки вы сможете пользоваться компонентом dv:date.current";
}

function InstallFiles($arParams = array())
{
CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/vdk_companies/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
return true;
}

function UnInstallFiles()
{
DeleteDirFilesEx("/bitrix/components/vdk");
return true;
}
function InstallDB()
{
if(!CModule::IncludeModule("iblock"))
return;
	global $DB;
	$arFields = Array(
	'ID'=>'vdk_companies_type',
	'SECTIONS'=>'Y',
	'IN_RSS'=>'N',
	'SORT'=>100,
	'LANG'=>Array(
		'en'=>Array(
			'NAME'=>'Сompanies',
			'SECTION_NAME'=>'Catalog',
			'ELEMENT_NAME'=>'Сompany'
			),
			'ru'=>Array(
			'NAME'=>'Компании',
			'SECTION_NAME'=>'Каталог',
			'ELEMENT_NAME'=>'Компания'
			)
		)
	);

$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res)
{$DB->Rollback();   echo 'Error: '.$obBlocktype->LAST_ERROR.'<br>';}
else
{$DB->Commit();}
   

$arFields = Array(
	'ID'=>'vdk_cities_type',
	'SECTIONS'=>'Y',
	'IN_RSS'=>'N',
	'SORT'=>100,
	'LANG'=>Array(
		'ru'=>Array(
			'NAME'=>'Города',
			'SECTION_NAME'=>'Страна',
			'ELEMENT_NAME'=>'Город'
			),
			'en'=>Array(
			'NAME'=>'Cities',
			'SECTION_NAME'=>'Country',
			'ELEMENT_NAME'=>'City'
			)
		)
	);

$obBlocktype = new CIBlockType;
$DB->StartTransaction();
$res = $obBlocktype->Add($arFields);
if(!$res)
{$DB->Rollback();   echo 'Error: '.$obBlocktype->LAST_ERROR.'<br>';}
else
{$DB->Commit();}

$iblockID = WizardServices::ImportIBlockFromXML("/bitrix/modules/vdk_companies/install/db/infoblocks/cities.xml", "vdk_cities", "vdk_cities_type", "s1");
if ($iblockID < 1) return false;
$iblockID = WizardServices::ImportIBlockFromXML("/bitrix/modules/vdk_companies/install/db/infoblocks/1.xml", "vdk_companies", "vdk_companies_type", "s1");
if ($iblockID < 1) return false;
return true;
}

	function UnInstallDB()
	{global $DB;
		if(CModule::IncludeModule("iblock"))
	{
		$DB->StartTransaction();
		if(!CIBlockType::Delete('vdk_companies_type'))
		{
			$DB->Rollback();
			echo 'Delete error!';
		}
		$DB->Commit();
	}
		if(CModule::IncludeModule("iblock"))
	{
		$DB->StartTransaction();
		if(!CIBlockType::Delete('vdk_cities_type'))
		{
			$DB->Rollback();
			echo 'Delete error!';
		}
		$DB->Commit();
	}
	
		return true;
	}
function DoInstall()
{

global $DOCUMENT_ROOT, $APPLICATION;
$res1 = $this->InstallFiles();
$res2 = $this->InstallDB();
	
RegisterModule("vdk_companies");
$APPLICATION->IncludeAdminFile("Установка модуля vdk_companies", $DOCUMENT_ROOT."/bitrix/modules/vdk_companies/install/step.php");


}

function DoUninstall()
{
global $DOCUMENT_ROOT, $APPLICATION;
$this->UnInstallFiles();
$this->UnInstallDB();
UnRegisterModule("vdk_companies");
$APPLICATION->IncludeAdminFile("Деинсталляция модуля vdk_companies", $DOCUMENT_ROOT."/bitrix/modules/vdk_companies/install/unstep.php");
}
}
?>