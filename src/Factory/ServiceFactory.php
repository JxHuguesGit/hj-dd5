<?php
namespace src\Factory;

use src\Service\Domain\MapService;
use src\Service\Domain\MapTokenService;
use src\Service\Domain\OriginService;
use src\Service\Domain\SkillService;
use src\Service\Domain\SpecieService;
use src\Service\Domain\WpPostService;
use src\Service\Formatter\WeaponFormatter;
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
            $this->readerFactory,
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
            $this->readerFactory->power(),
            $this->readerFactory->species()
        );
    }

    public function weaponFormatter(): WeaponFormatter
    {
        return new WeaponFormatter(
            $this->wordPress(),
            $this->weaponProperties(),
            $this->readerFactory->weaponPropertyValue()
        );
    }

    public function mapToken(): MapTokenService
    {
        return new MapTokenService(
            $this->readerFactory->mapToken()
        );
    }

    public function map(): MapService
    {
        return new MapService(
            $this->readerFactory->map(),
            new WriterFactory($this->repositoryFactory)
        );
    }
}
