<?php
namespace src\Collection;

use src\Entity\Entity;
use src\Exception\KeyAlreadyUse;
use src\Exception\KeyInvalid;

class Collection implements \Iterator
{
    private array $items = [];
    private int $indexIterator = -1;

    /**
     * Ajoute un objet à la collection.
     *
     * @param Entity $obj L'objet à ajouter.
     * @param string|null $key La clé optionnelle. Si aucune clé n'est fournie, un hash unique de l'objet est utilisé.
     * @return self
     * @throws KeyAlreadyUse Si la clé existe déjà.
     */
    public function addItem(Entity $obj, ?string $key = null): self
    {
        if ($key === null) {
            $key = ++$this->indexIterator;
        }

        // Si la clé existe déjà, une exception est levée
        if (isset($this->items[$key])) {
            throw new KeyAlreadyUse("La clé '$key' est déjà utilisée.");
        }

        $this->items[$key] = $obj;

        return $this;
    }

    /**
     * Supprime un objet de la collection.
     *
     * @param int $key L'index de l'objet à supprimer.
     * @throws KeyInvalid Si l'objet n'est pas trouvé dans la collection.
     */
    public function deleteItem(int $key): void
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            throw new KeyInvalid("L'objet avec la clé '$key' est invalide.");
        }
    }

    /**
     * Vérifie si un objet existe dans la collection.
     *
     * @param int $key L'index de l'objet à vérifier.
     * @return bool Vrai si l'objet existe, faux sinon.
     */
    public function hasItem(int $key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * Retourne toutes les clés de la collection.
     *
     * @return array Les clés de la collection.
     */
    public function keys(): array
    {
        return array_keys($this->items);
    }

    /**
     * Retourne le nombre d'éléments dans la collection.
     *
     * @return int Le nombre d'éléments.
     */
    public function length(): int
    {
        return count($this->items);
    }

    /**
     * Retourne une nouvelle collection contenant une portion de la collection initiale.
     *
     * @param int $offset L'index de départ.
     * @param int $length Le nombre d'éléments à extraire.
     * @return Collection La nouvelle collection contenant les éléments extraits.
     */
    public function slice(int $offset, int $length): Collection
    {
        $slicedItems = array_slice($this->items, $offset, $length);
        $newCollection = new self();

        foreach ($slicedItems as $item) {
            $newCollection->addItem($item);
        }

        return $newCollection;
    }

    /**
     * Fusionne une autre collection avec la collection actuelle.
     *
     * @param Collection $collection La collection à fusionner.
     * @return self
     * @throws KeyAlreadyUse Si une clé existe déjà.
     */
    public function merge(Collection $collection): self
    {
        foreach ($collection->items as $key => $obj) {
            // Si la clé existe déjà, une exception est levée
            if (isset($this->items[$key])) {
                throw new KeyAlreadyUse("La clé '$key' est déjà utilisée.");
            }

            $this->addItem($obj, $key);
        }

        return $this;
    }

    /**
     * Convertit la collection en un tableau.
     *
     * @return array Le tableau contenant tous les objets de la collection.
     */
    public function toArray(): array
    {
        return array_map(fn($item) => get_object_vars($item), $this->items);
    }

    /**
     * Filtre les éléments de la collection en fonction d'une fonction de rappel.
     *
     * @param callable $callback La fonction de rappel utilisée pour filtrer les éléments.
     * @return Collection La nouvelle collection contenant les éléments filtrés.
     */
    public function filter(callable $callback): Collection
    {
        $filteredItems = array_filter($this->items, $callback);
        $newCollection = new self();

        foreach ($filteredItems as $item) {
            $newCollection->addItem($item);
        }

        return $newCollection;
    }

    /**
     * Trie les éléments de la collection.
     *
     * @param callable $callback La fonction de rappel utilisée pour comparer les éléments.
     * @return self La collection triée.
     * 
     * Exemple :
     * $sortedCollection = $collection->sort(function($a, $b) {
     *      return $a->getWeight() <=> $b->getWeight(); // Trie par poids
     * });
     */
    public function sort(callable $callback): self
    {
        usort($this->items, $callback);
        return $this;
    }

    /**
     * Réinitialise l'index de l'itérateur à 0.
     */
    public function rewind(): void
    {
        $this->indexIterator = 0;
    }

    /**
     * Vérifie si l'index est valide.
     *
     * @return bool Vrai si l'index est valide, sinon faux.
     */
    public function valid(): bool
    {
        return isset($this->items[$this->indexIterator]);
    }

    /**
     * Retourne l'élément courant de l'itérateur.
     *
     * @return mixed L'élément courant.
     */
    public function current(): mixed
    {
        return $this->items[$this->indexIterator];
    }

    /**
     * Avance l'index de l'itérateur.
     */
    public function next(): void
    {
        ++$this->indexIterator;
    }

    /**
     * Retourne l'index de l'itérateur.
     *
     * @return int L'index courant.
     */
    public function key(): int
    {
        return $this->indexIterator;
    }

    /**
     * Vide la collection.
     */
    public function empty(): void
    {
        $this->items = [];
        $this->indexIterator = 0;
    }
}
