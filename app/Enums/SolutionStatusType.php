<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SolutionStatusType extends Enum
{
    public const EMPTY = 0;

    public const RECEIVED = 1;

    public const VALIDATED = 2;

    public const INVALID_LANGUAGE_USED = 3;

    public const CHARACTERS_LIMIT_EXCEEDED = 4;

    public const INVALID_SOLUTION_CODE_DATA = 5;

    public const MALFORMED_UTF8_CODE_STRING = 6;

    public const INVALID = 7;

    public const DELEGATED = 8;

    public const PASSED_ALL_TESTS = 9;

    public const FAILED_TESTS = 10;

    public const INTERRUPTED = 11;
}
