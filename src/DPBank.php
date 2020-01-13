<?php
declare(strict_types=1);

namespace Bank;

use Bank\Account\Transaction;
use Bank\Exceptions\BankException;
use DateTime;
use const PHP_EOL;

final class DPBank implements BankService
{
    /**
     * @var BankSafe
     */
    private $bankSafe;

    public function __construct()
    {
        $this->bankSafe = new BankSafe();
    }

    public function setCurrentDate(DateTime $date): void
    {
        $this->bankSafe->setCurrentDate($date);
    }

    public function deposit(int $amount): void
    {
        if ($amount<=0) {
            throw new BankException('Invalid transaction amount. Amount must by positive number');
        }
        $this->bankSafe->createTransaction(Transaction::DIRECTION_IN, $amount);
    }

    public function withdraw(int $amount): void
    {
        $this->bankSafe->createTransaction(Transaction::DIRECTION_OUT, $amount);
    }

    public function printStatement(): void
    {
        echo 'Data       || Kwota  || Saldo', PHP_EOL;
        /** @var Transaction $entry */
        foreach ($this->bankSafe->getReversedHistory() as $entry) {
            echo (string)$entry, PHP_EOL;
        }
    }

    public function getBalance(): int
    {
        return $this->bankSafe->getBalance();
    }
}