<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\CharacterCreation\CharacterDraft;
use src\Domain\Criteria\CharacterDraftCriteria;
use src\Repository\CharacterDraftRepositoryInterface;

final class CharacterDraftReader
{
    public function __construct(
        private CharacterDraftRepositoryInterface $repo,
    ) {}

    /**
     * @return ?CharacterDraft
     */
    public function characterDraftById(int $id): ?CharacterDraft
    {
        return $this->repo->find($id);
    }

    /**
     * @return Collection<CharacterDraft>
     */
    public function characterDraftByWpUser(int $wpUserId): Collection
    {
        $criteria = new CharacterDraftCriteria();
        $criteria->wpUserId = $wpUserId;
        $criteria->orderBy  = [Field::NAME=>Constant::CST_ASC];
        return $this->repo->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<CharacterDraft>
     */
    public function allFeats(?CharacterDraftCriteria $criteria=null): Collection
    {
        if (!$criteria) {
            $criteria = new CharacterDraftCriteria();
            $criteria->orderBy = [Field::NAME=>Constant::CST_ASC];
        }
        return $this->repo->findAllWithCriteria($criteria);
    }
}
