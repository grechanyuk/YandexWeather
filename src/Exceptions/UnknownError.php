<?php
namespace Grechanyuk\YandexWeather\Exceptions;

use RuntimeException;
use Throwable;

class UnknownError extends RuntimeException{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        \Log::warning('YandexWeather: Произошла неизвестная ошибка', ['message' => $message, 'code' => $code]);
        parent::__construct($message, $code, $previous);
    }
}