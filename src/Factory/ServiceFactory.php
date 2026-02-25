<?php
namespace src\Factory;

use src\Service\Domain\OriginService;
use src\Service\Domain\SkillService;
use src\Service\Domain\SpecieService;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\WeaponPropertiesFormatter;

final class ServiceFactory
{
    public function __construct(
        private ReaderFactory $readerFactory
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
            $this->readerFactory->feat(),
            $this->readerFactory->tool(),
            $this->readerFactory->originSkill(),
            $this->readerFactory->originAbility(),
            $this->readerFactory->originItem(),
            $this->readerFactory->skill(),
            $this->readerFactory->ability(),
            $this->readerFactory->item()
        );
    }

    public function skill(): SkillService
    {
        return new SkillService(
            $this->readerFactory->originSkill(),
            $this->readerFactory->subSkill(),
            $this->readerFactory->origin()
        );
    }

    public function specie(): SpecieService
    {
        return new SpecieService(
            $this->readerFactory->speciePower(),
            $this->readerFactory->power()
        );
    }
}
