<?php

namespace App\Enums;

enum DashboardPeriodEnum: string
{
    case CurrentMonth = 'current_month';
    case LastMonth    = 'last_month';
    case LastQuarter  = 'last_quarter';
    case CurrentYear  = 'current_year';

    /**
     * Valida se uma string corresponde a um caso válido deste Enum.
     *
     * @param string $value O valor a ser verificado (ex: 'last_month').
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        return self::tryFrom($value) !== null;
    }

    /**
     * Retorna o intervalo de datas correspondente ao período especificado.
     *
     * @param string $periodValue O valor a ser verificado (ex: 'last_month').
     * @return array|null
     */
    public static function getDateRange(string $periodValue): ?array
    {
        $enumCase = self::tryFrom($periodValue);

        if ($enumCase === null) {
            return null;
        }

        return match ($enumCase) {
            self::CurrentMonth => [now()->startOfMonth(), now()->endOfMonth()],
            self::LastMonth    => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
            self::LastQuarter  => [now()->subQuarter()->startOfQuarter(), now()->subQuarter()->endOfQuarter()],
            self::CurrentYear  => [now()->startOfYear(), now()->endOfYear()],
        };
    }
}
