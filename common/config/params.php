<?php

$countryCodeList = require(__DIR__ . '/gis/country-code-list-ua.php');
$countrySlugList = require(__DIR__ . '/gis/country-slug-list.php');

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,

    'backend.gridView.pagination.pageSizeLimit.default' => 15,
    'employee.gridView.pagination.pageSizeLimit.default' => 15,
    'frontend.gridView.pagination.pageSizeLimit.default' => 15,

    'countryCodeList' => $countryCodeList,
    'countrySlugList' => $countrySlugList,
];
