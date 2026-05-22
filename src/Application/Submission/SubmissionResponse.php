<?php

namespace Testcenter\Application\Submission;

class SubmissionResponse
{
    public function __construct(
        public int $score,
    ) {}
}