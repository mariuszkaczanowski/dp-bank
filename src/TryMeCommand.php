<?php

use Bank\DPBank;

include 'vendor/autoload.php';

$bank = new DPBank();
$bank->setCurrentDate(DateTime::createFromFormat('Y-m-d', '2015-02-02'));
$bank->deposit(500);

$bank->setCurrentDate(DateTime::createFromFormat('Y-m-d', '2015-02-15'));
$bank->deposit(1000);

$bank->setCurrentDate(DateTime::createFromFormat('Y-m-d', '2015-02-17'));
$bank->withdraw(200);

$bank->printStatement();;