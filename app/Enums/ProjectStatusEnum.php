<?php

namespace App\Enums;

enum ProjectStatusEnum: string
{
    case SUCCESS = 'success';
    case MOVED = 'moved';
    case CLIENT_ERROR = 'client_error';
    case SERVER_ERROR = 'server_error';
    case UNKNOWN = 'unknown';
    public static function getStatus(int $status): self
    {
        if ($status >= 200 && $status < 300) {
            return self::SUCCESS;
        }
        if ($status >= 300 && $status < 400) {
            return self::MOVED;
        }
        if ($status >= 400 && $status < 500) {
            return self::CLIENT_ERROR;
        }
        if ($status >= 500 && $status < 600) {
            return self::SERVER_ERROR;
        }
        return self::UNKNOWN;
    }
    public function getStatusNumber(): int
    {
        return match ($this) {
            self::SUCCESS => 200,
            self::MOVED => 301,
            self::CLIENT_ERROR => 400,
            self::SERVER_ERROR => 500,
            self::UNKNOWN => 600,
        };
    }
}
