<?php
use kartik\datecontrol\Module;

$tesseract = require __DIR__ . 'tesseract.php';

$params = [
    'adminEmail' => 'admin@example.com',

    // format settings for displaying each date attribute (ICU format example)
    'dateControlDisplay' => [
        Module::FORMAT_DATE => 'dd.MM.yyyy',
        Module::FORMAT_TIME => 'hh:mm',
        Module::FORMAT_DATETIME => 'dd.MM.yyyy hh:mm',
    ],

    // format settings for saving each date attribute (PHP format example)
    'dateControlSave' => [
        Module::FORMAT_DATE => 'php:Y-m-d', // saves as unix timestamp
        Module::FORMAT_TIME => 'php:H:i',
        Module::FORMAT_DATETIME => 'php:Y-m-d H:i',
    ],

    'dateControlDisplayTimezone' => 'Europe/Berlin',
    'dateControlSaveTimezone' => 'Europe/Berlin',
];

return array_merge($params, $tesseract);