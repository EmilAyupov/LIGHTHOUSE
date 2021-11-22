<?php

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
    "custom:users.list",
    "",
    [
        "IBLOCK_ID" => 4,
        "PAGE_SIZE" => 3
    ],
    false
);