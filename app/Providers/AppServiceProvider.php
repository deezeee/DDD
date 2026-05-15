<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Testcenter\Domain\Exam\ExamRepository;
use Testcenter\Domain\Question\QuestionRepository;
use Testcenter\Domain\Submission\SubmissionRepository;
use Testcenter\Infrastructure\Exam\MysqlExamRepository;
use Testcenter\Infrastructure\Question\MysqlQuestionRepository;
use Testcenter\Infrastructure\Submission\MysqlSubmissionRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(QuestionRepository::class, function () {
            return app(MysqlQuestionRepository::class);
        });

        $this->app->singleton(SubmissionRepository::class, function () {
            return app(MysqlSubmissionRepository::class);
        });

        $this->app->singleton(ExamRepository::class, function () {
            return app(MysqlExamRepository::class);
        });
    }
}
