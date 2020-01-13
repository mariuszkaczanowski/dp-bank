<?php declare(strict_types=1);

namespace Tests\Bank;

use Bank\DPBank;
use Bank\Exceptions\BankException;
use DateTime;
use PHPUnit\Framework\TestCase;

class DPBankTest extends TestCase
{
    public function testWithdraw(): void
    {
        $this->expectException(BankException::class);

        $bank = new DPBank();
        $bank->withdraw(100);

    }

    public function testDeposit(): void
    {
        $bank = new DPBank();
        $bank->setCurrentDate(new DateTime());
        $bank->deposit(100);

        $this->assertEquals(100, $bank->getBalance());
    }

    public function testIsSetCurrentDate(): void
    {
        $this->expectException(BankException::class);

        $bank = new DPBank();
        $bank->deposit(100);
    }
}
