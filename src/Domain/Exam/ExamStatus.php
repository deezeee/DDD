<?php

namespace Testcenter\Domain\Exam;

enum ExamStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
}