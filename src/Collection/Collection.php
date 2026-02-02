<?php
namespace src\Collection;

use src\Exception\KeyAlreadyUse;
use src\Exception\KeyInvalid;

class Collection implements \IteratorAggregate, \Countable
{
    public function __construct(
        private array $items=[]
    ) {}

    public function add($obj, ?string $key = null): self
    {
        if ($key === null) {
            $this->items[] = $obj;
        } elseif (isset($this->items[$key])) {
            throw new KeyAlreadyUse("La clé '$key' est déjà utilisée.");
        } else {
            $this->items[$key] = $obj;
        }
        return $this;
    }

    public function remove(string|int $key): void {
        if (!isset($this->items[$key])) {
            throw new KeyInvalid("Clé '$key' invalide.");
        }
        unset($this->items[$key]);
    }

    public function has(string|int $key): bool
    {
        return isset($this->items[$key]);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
    
    public function isEmpty(): bool
    {
        return $this->count()==0;
    }

    public function keys(): array
    {
        return array_keys($this->items);
    }
    
    public function clear(): void
    {
        $this->items = [];
    }

    public function first(): mixed
    {
        return reset($this->items) ?: null;
    }

    public function toArray(): array
    {
        return $this->items;
    }

    // Helpers

    public function slice(int $offset, int $length): self
    {
        return new self(array_slice($this->items, $offset, $length, true));
    }

    public function filter(callable $callback): self
    {
        return new self(array_filter($this->items, $callback));
    }

    public function map(callable $callback): self
    {
        return new self(array_map($callback, $this->items));
    }

    public function sort(callable $callback): self
    {
        $items = $this->items;
        uasort($items, $callback);
        return new self($items);
    }

    public function merge(Collection $collection, bool $preserveKeys = true): self
    {
        foreach ($collection->items as $key => $obj) {
            if ($preserveKeys) {
                if (isset($this->items[$key])) {
                    throw new KeyAlreadyUse("La clé '$key' est déjà utilisée.");
                }
                $this->items[$key] = $obj;
            } else {
                $this->items[] = $obj;
            }
        }
        return $this;
    }

    public function find(callable $callback): mixed
    {
        foreach ($this->items as $item) {
            if ($callback($item)) {
                return $item;
            }
        }
        return null;
    }

    public function findKey(callable $callback): string|int|null
    {
        foreach ($this->items as $key => $item) {
            if ($callback($item)) {
                return $key;
            }
        }
        return null;
    }

}
