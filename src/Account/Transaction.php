<?php
declare(strict_types=1);

namespace Bank\Account;

use Bank\Exceptions\TransactionException;
use DateTime;

use function sprintf;

final class Transaction
{
    public const DIRECTION_IN = 'IN';
    public const DIRECTION_OUT = 'OUT';

    /**
     * @var DateTime
     */
    private $entryDate;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $balance;

    /**
     * @var string
     */
    private $direction;

    public function  __construct(DateTime $entryDate, string $direction, int $amount, int $balance)
    {
        if ($amount <= 0) {
            throw new TransactionException('Invalid transaction amount. Amount must by positive number');
        }
        $this->entryDate = $entryDate;
        $this->direction = $direction;
        $this->amount    = $amount;
        $this->balance   = $balance;
    }

    public function __toString(): string
    {
        return sprintf('%s || %s || %s', $this->getEntryDate()->format('d/m/Y'), $this->getPrettyAmount(), $this->getBalance());
    }

    /**
     * @return DateTime
     */
    public function getEntryDate(): DateTime
    {
        return $this->entryDate;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPrettyAmount(): string
    {
        return sprintf('%s%s', self::DIRECTION_OUT === $this->direction ? '-' : '', $this->amount);
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }
}