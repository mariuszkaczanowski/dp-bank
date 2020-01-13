<?php
declare(strict_types=1);

namespace Bank\Account;

use Countable;
use RuntimeException;
use IteratorAggregate;
use ArrayAccess;
use ArrayIterator;
use function count;
use function current;
use function key;
use function next;

final class History implements ArrayAccess, IteratorAggregate, Countable
{
    /**
     * @var array
     */
    private $elements;

    public function __construct()
    {
        $this->elements = [];
    }

    /**
     * @param array $elements
     */
    public function setElements(array $elements): void
    {
        if (!empty($this->elements)) {
          throw new RuntimeException();
        }
        $this->elements = $elements;
    }

    public function count(): int
    {
        return count($this->elements);
    }

    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->elements);
    }

    public function offsetGet($offset)
    {
        return array_key_exists($offset, $this->elements) ? $this->elements[$offset] : null;
    }

    public function offsetSet($offset, $value): void
    {
        if (null === $offset) {
            $this->elements[] = $value;

            return;
        }
        $this->elements[$offset] = $value;
    }

    public function offsetUnset($offset): void
    {
        unset($this->elements[$offset]);
    }

    public function getReversedHistory(): array
    {
        return array_reverse($this->elements);
    }

    public function add(Transaction $transaction): void
    {
        $this->elements[] =$transaction;
    }

    /**
     * @inheritDoc
     */
    public function current(): Transaction
    {
        return current($this->elements);
    }

    /**
     * @inheritDoc
     */
    public function next(): Transaction
    {
        return next($this->elements);
    }

    /**
     * @inheritDoc
     */
    public function key(): ?int
    {
        return key($this->elements);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->elements);
    }
}