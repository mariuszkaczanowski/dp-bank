<?php
declare(strict_types=1);

namespace Bank;


interface BankService
{
    public function deposit(int $amount): void;

    public function withdraw(int $amount): void;

    public function printStatement(): void;
}
