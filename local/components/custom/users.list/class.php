<?php

use Bitrix\Main\SystemException;
use Bitrix\Iblock\Elements\ElementPeopleTable;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Loader;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CUserList extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        return $arParams;
    }

    public function executeComponent()
    {
        try {
            $this->getResult();
            $this->includeComponentTemplate();
        } catch (SystemException $e) {
            ShowError($e->getMessage());
        }
    }

    protected function getResult()
    {
        Loader::includeModule("iblock");

        $nav = new PageNavigation("nav");
        $nav->allowAllRecords(true)
            ->setPageSize($this->arParams["PAGE_SIZE"])
            ->initFromUri();

        $obElements = ElementPeopleTable::getList(array(
            "select"      => [
                "FIO_VALUE"    => "FIO.VALUE",
                "CITY_VALUE"   => "ELEMENT.CITY.VALUE",
                "STREET_VALUE" => "ELEMENT.STREET.VALUE",
                "NUMBER_VALUE" => "ELEMENT.NUMBER.VALUE"
            ],
            "filter"      => ["IBLOCK_ID" => $this->arParams["IBLOCK_ID"]],
            "count_total" => true,
            "offset"      => $nav->getOffset(),
            "limit"       => $nav->getLimit(),
            "runtime"     => [
                "ELEMENT" => [
                    "data_type" => "\Bitrix\Iblock\Elements\ElementHousesTable",
                    "reference" => [
                        "=this.HOME.VALUE" => "ref.ID"
                    ]
                ]
            ]
        ));

        $nav->setRecordCount($obElements->getCount());

        $this->arResult["NAV"] = $nav;
        $this->arResult["ITEMS"] = $obElements->fetchAll();
    }
}
