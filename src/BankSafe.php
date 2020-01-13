<?php
declare(strict_types=1);

namespace Bank;

use Bank\Account\History;
use Bank\Account\Transaction;
use Bank\Exceptions\BankException;
use DateTime;

final class BankSafe
{
    /**
     * @var ?DateTime
     */
    private $currentDate;

    /**
     * @var int
     */
    private $balance;

    /**
     * @var History
     */
    private $bcaHistory;

    public function __construct()
    {
        $this->balance    = 0;
        $this->bcaHistory = new History;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @param DateTime $currentDate
     * @throws BankException
     */
    public function setCurrentDate(DateTime $currentDate): void
    {
        if ($currentDate < $this->currentDate) {
            throw new BankException('New date can be earlier then current one');
        }
        $this->currentDate = $currentDate;
    }

    /**
     * Tutaj chyba popłynąłem bo zrobiłem to "po bankowemu" czyli transakcja ma kierunek
     * (brakuje "nadawcy" i "odbiorcy") i przeważnie ma kwotę jako wartość bezwzględną.
     * Przeważnie bo są wyjątki :)
     *
     * @param string $direction
     * @param int $amount
     * @throws BankException
     * @throws Exceptions\TransactionException
     */
    public function createTransaction(string $direction, int $amount): void
    {
        if (Transaction::DIRECTION_OUT === $direction && $amount > $this->balance) {
            throw new BankException('Not enough available assets');
        }
        if (!$this->currentDate instanceof DateTime) {
            throw new BankException('You have to set current date first');
        }
        $realAmount = $amount;
        if (Transaction::DIRECTION_OUT === $direction) {
            $realAmount = -$amount;
        }
        $this->balance += $realAmount;
        $this->bcaHistory->add(new Transaction($this->currentDate, $direction, $amount, $this->balance));
    }

    public function getReversedHistory(): array
    {
        return $this->bcaHistory->getReversedHistory();
    }
}