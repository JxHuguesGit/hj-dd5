<?php
namespace src\Service;

use src\Repository\RpgSkill;

final class RpgSkillService
{
    public function __construct(
        private RpgSkill $skillRepository,
    ) {}

}