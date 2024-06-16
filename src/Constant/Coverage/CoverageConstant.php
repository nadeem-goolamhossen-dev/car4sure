<?php

namespace App\Constant\Coverage;

class CoverageConstant
{
    const TYPE_LIABILITY = 'liability';

    const TYPE_COLLISION = 'collision';

    const TYPE_COMPREHENSIVE = 'comprehensive';

    const TYPES = [self::TYPE_LIABILITY, self::TYPE_COLLISION, self::TYPE_COMPREHENSIVE];
}