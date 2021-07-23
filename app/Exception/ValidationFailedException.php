<?php

namespace App\Exception;

class ValidationFailedException extends \Exception
{
    /**
     * @var string[] $errors массив со списком ошибок валидации
     */
    private array $errors;

    public function __construct(array $errors = [], string $message = '', int $code = 0)
    {
        $this->errors = $errors;

        parent::__construct($message, $code);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}