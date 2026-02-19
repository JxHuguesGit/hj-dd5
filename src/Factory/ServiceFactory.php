<?php
namespace src\Factory;

use src\Service\Domain\{OriginService, SpecieService, SkillService, WpPostService};
use src\Service\Formatter\WeaponPropertiesFormatter;

final class ServiceFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private RepositoryFactory $repositoryFactory
    ) {}

    public function wordPress(): WpPostService
    {
        return new WpPostService();
    }

    public function weaponProperties(): WeaponPropertiesFormatter
    {
        return new WeaponPropertiesFormatter();
    }

    public function origin(): OriginService
    {
        return new OriginService(
            $this->repositoryFactory->feat(),
            $this->repositoryFactory->tool(),
            $this->repositoryFactory->originSkill(),
            $this->repositoryFactory->originAbility(),
            $this->repositoryFactory->originItem(),
            $this->readerFactory->skill(),
            $this->readerFactory->ability(),
            $this->readerFactory->item()
        );
    }

    public function skill(): SkillService
    {
        return new SkillService(
            $this->repositoryFactory->originSkill(),
            $this->repositoryFactory->subSkill(),
            $this->readerFactory->origin()
        );
    }

    public function specie(): SpecieService
    {
        return new SpecieService(
            $this->repositoryFactory->speciePower(),
            $this->readerFactory->power()
        );
    }
}
