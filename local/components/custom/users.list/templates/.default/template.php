<?php

foreach ($arResult['ITEMS'] as $item) {
    echo "-- {$item[FIO_VALUE]} - {$item[CITY_VALUE]} {$item[STREET_VALUE]}, {$item[NUMBER_VALUE]}</br>";
}

$APPLICATION->IncludeComponent(
    "bitrix:main.pagenavigation",
    "modern",
    array(
        "NAV_OBJECT" => $arResult['NAV'],
    ),
    false
);