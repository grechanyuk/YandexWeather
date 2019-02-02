<?php
namespace Grechanyuk\YandexWeather\Exceptions;

use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class NotValidApiKey extends RuntimeException {
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        Log::warning('YandexWeather: Ошибка API ключа', ['message' => $message, 'code' => $code]);
        parent::__construct($message, $code, $previous);
    }
}