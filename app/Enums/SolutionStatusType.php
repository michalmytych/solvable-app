<?php

namespace App\Enums;

enum SolutionStatusType: int
{
    case EMPTY = 0;

    case RECEIVED = 1;

    case VALIDATED = 2;

    case INVALID_LANGUAGE_USED = 3;

    case CHARACTERS_LIMIT_EXCEEDED = 4;

    case EMPTY_DECODING_RESULT = 5;

    case MALFORMED_UTF8_CODE_STRING = 6;

    case INVALID = 7;

    case DELEGATED = 8;

    case PASSED_ALL_TESTS = 9;

    case FAILED_TESTS = 10;

    case INTERRUPTED = 11;
}
