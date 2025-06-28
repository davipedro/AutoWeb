<?php

namespace App\Enums;

enum VehicleStatusEnum: string
{
    case Available = 'disponivel';
    case Sold = 'vendido';
    case Unavailable = 'indisponivel';
    case Reserved = 'reservado';
    case Maintenance = 'manutencao';
    case Inactive = 'inativo';

    /**
     * Valida se uma string corresponde a um caso válido deste Enum.
     *
     * @param string $value O valor a ser verificado (ex: 'disponível').
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        return self::tryFrom($value) !== null;
    }

    /**
     * Retorna o status correspondente ao valor fornecido.
     *
     * @param string $value O valor do status (ex: 'disponível').
     * @return VehicleStatusEnum|null
     */
    public static function fromValue(string $value): ?VehicleStatusEnum
    {
        return self::tryFrom($value);
    }

    /**
     * Retorna todos os valores possíveis deste Enum.
     *
     * @return array
     */
    public static function getAllValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
