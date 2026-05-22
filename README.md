# TestCenter – DDD + Clean Architecture Demo

## Giới thiệu

Đây là project demo xây dựng hệ thống thi online (Test Center) sử dụng:

* Domain Driven Design (DDD)
* Clean Architecture
* Rich Domain Model
* Tactical DDD Pattern
* Laravel 10
* PHP 8.1+

Mục tiêu của project:

* Demo cách evolve từ MVC/service layer sang DDD
* Giảm business logic phình trong service
* Tăng khả năng mở rộng business
* Tách biệt business với framework/infrastructure
* Làm tài liệu training nội bộ về DDD + Clean Architecture

---

# Các bài toán hiện tại

Hệ thống hiện tại hỗ trợ:

## Question Types

* Single Choice Question
* Multiple Choice Question
* Fill Blank Question
* Matching Question

---

## Exam Flow

* Tạo đề thi
* Submit bài thi
* Chấm điểm
* Tính tổng điểm
* Domain Event khi submit

---

## Invariant Protection

Project đã implement domain invariant:

* Không cho negative score
* Không cho duplicate multiple choice answer
* Không cho empty fill blank answer
* Không cho invalid matching pair

---

# Kiến trúc tổng quan

```txt
src/
├── Application/
├── Domain/
└── Infrastructure/
```

---

# Clean Architecture

```txt
Controller
  -> Application
      -> Domain
          <- Infrastructure
```

---

# Dependency Rule

```txt
Outer -> Inner
```

Domain layer:

* không biết Laravel
* không biết Database
* không biết Redis
* không biết HTTP
* không biết Queue

---

# Domain Layer

Chứa:

* Entity
* Value Object
* Aggregate
* Domain Service
* Domain Event
* Repository Interface

Ví dụ:

```txt
Domain/
├── Question/
├── Submission/
├── Shared/
└── Exam/
```

---

# Application Layer

Application layer chỉ orchestration:

* load aggregate
* execute business behavior
* persist
* publish event
* return response DTO

Ví dụ:

```txt
SubmitExamHandler
```

---

# Infrastructure Layer

Implement:

* Repository
* Event Bus
* ORM
* Persistence
* External Service

Ví dụ:

```txt
EloquentQuestionRepository
LaravelEventBus
```

---

# Tactical DDD được áp dụng

## Rich Domain Model

Question tự behavior:

```php
$question->grade($answer);
$question->createAnswer($payload);
```

---

## Value Object

Ví dụ:

```txt
Score
QuestionText
AcceptedAnswers
MatchingPair
UserID
ExamID
```

---

## Aggregate

Ví dụ:

```txt
Submission Aggregate
```

chịu trách nhiệm:

* consistency boundary
* submission lifecycle
* domain event recording

---

## Domain Service

Ví dụ:

```txt
ScoringService
```

Dùng cho:

* cross entity logic
* grading workflow

---

## Domain Event

Ví dụ:

```txt
ExamSubmitted
```

Flow:

```txt
Domain
 -> recordEvent()

Application
 -> publish()
```

---

# Điểm nổi bật của project

## 1. Tránh Anemic Domain Model

Business logic nằm trong Domain.

Không nằm ở:

```txt
God Service
```

---

## 2. Giảm if/else business logic

Sử dụng:

```txt
Polymorphism
```

thay vì:

```php
switch ($question->type)
```

---

## 3. Scale feature tốt hơn

Khi thêm loại question mới:

```txt
EssayQuestion
TrueFalseQuestion
```

không cần sửa logic cũ.

---

## 4. Domain tự bảo vệ state

Ví dụ:

```php
new Score(-10);
```

=> Exception

---

# So sánh MVC vs DDD

| MVC/Service Layer                  | DDD + Clean Architecture           |
| ---------------------------------- | ---------------------------------- |
| Business logic phình trong service | Business behavior nằm trong domain |
| Nhiều if/else                      | Polymorphism                       |
| Khó scale business                 | Scale tốt hơn                      |
| Coupling cao                       | Boundary rõ ràng                   |
| Entity chỉ chứa data               | Rich Domain Model                  |
| Framework-centric                  | Domain-centric                     |

---

# Hướng mở rộng trong tương lai

Project được thiết kế để dễ mở rộng cho:

## Exam Features

* Weighted Score
* Retry Policy
* Time Limit
* Random Question
* Section Score
* AI Grading
* Essay Question
* Partial Grading

---

## Anti Cheat

* Detect tab switch
* Detect copy paste
* Webcam monitoring
* Suspicious behavior detection

---

## CQRS / Analytics

* Leaderboard
* Ranking
* Analytics
* Question difficulty
* Completion rate

---

## Multi Tenant

* Nhiều trung tâm thi
* Tenant policy riêng
* Scoring strategy riêng

---

# Yêu cầu hệ thống

* PHP 8.1+
* Composer
* Laravel

---

# Cài đặt project

## Clone project

```bash
git clone <repository-url>
```

---

## Install dependency

```bash
composer install
```

---

## Copy env

```bash
cp .env.example .env
```

---

## Generate app key

```bash
php artisan key:generate
```

---

## Run migration

```bash
php artisan migrate
```

---

## Run seed

```bash
php artisan db:seed
```

---

## Start server

```bash
php artisan serve
```

---

# Chạy test

```bash
php artisan test
```

hoặc:

```bash
vendor/bin/phpunit
```

---

# Các concept DDD được demo trong project

| Concept              | Có áp dụng |
| -------------------- | ---------- |
| Entity               | ✅          |
| Value Object         | ✅          |
| Aggregate            | ✅          |
| Domain Service       | ✅          |
| Domain Event         | ✅          |
| Repository           | ✅          |
| Rich Domain Model    | ✅          |
| Invariant Protection | ✅          |
| Clean Architecture   | ✅          |
| Polymorphism         | ✅          |

---

# Mục tiêu training nội bộ

Project này được xây dựng để:

* training DDD
* training Clean Architecture
* demo scaling business complexity
* demo refactor từ MVC sang DDD
* demo tactical DDD thực tế

---

# Điều quan trọng nhất

DDD không phải:

```txt
đổi tên folder
```

DDD là:

```txt
Model business complexity bằng behavior
```

---

# License

liem04
