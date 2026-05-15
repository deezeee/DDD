<?php

namespace Testcenter\Domain\Submission;

interface SubmissionRepository
{
    public function save(Submission $submission): void;
}