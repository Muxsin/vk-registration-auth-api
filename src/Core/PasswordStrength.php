<?php

declare(strict_types=1);

namespace Muhsin\VK\Core;

enum PasswordStrength
{
    case WEAK;
    case GOOD;
    case PERFECT;

    public function isWeak(): bool
    {
        return $this === self::WEAK;
    }

    public function toString(): string
    {
        return match ($this) {
            self::PERFECT => 'perfect',
            self::GOOD => 'good',
            default => 'weak',
        };
    }
}
