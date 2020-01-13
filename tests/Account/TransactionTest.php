<?php declare(strict_types=1);

namespace Tests\Bank\Account;

use Bank\Account\Transaction;
use Bank\Exceptions\TransactionException;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testGetEntryDate(): void
    {
        $amount = 100;
        foreach ([Transaction::DIRECTION_IN, Transaction::DIRECTION_OUT] as $direction) {
            $transaction = new Transaction(new \DateTime(), $direction, $amount, 0);
            $this->assertEquals($amount, $transaction->getAmount());
        }
    }

    public function testGetBalance(): void
    {
        $balance = 100;
        foreach ([Transaction::DIRECTION_IN, Transaction::DIRECTION_OUT] as $direction) {
            $transaction = new Transaction(new \DateTime(), $direction, 1, $balance);
            $this->assertEquals($balance, $transaction->getBalance());
        }
    }

    public function testAmountMusBePositive(): void
    {
        $this->expectException(TransactionException::class);

        new Transaction(new \DateTime(), Transaction::DIRECTION_IN, 0, 0);
    }
}
