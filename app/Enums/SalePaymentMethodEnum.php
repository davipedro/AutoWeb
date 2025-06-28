<?php

namespace App\Enums;

enum SalePaymentMethodEnum: string
{
    case CreditCard = 'Cartão de Crédito';
    case Pix = 'PIX';
    case Cash = 'Dinheiro';
    case BankTransfer = 'Transferência Bancária';

    /**
     * Valida se uma string corresponde a um caso válido deste Enum.
     *
     * @param string $value O valor a ser verificado (ex: 'Cartão de Crédito').
     * @return bool
     */
    public static function isValid(string $value): bool
    {
        return self::tryFrom($value) !== null;
    }

    /**
     * Retorna o método de pagamento correspondente ao valor fornecido.
     *
     * @param string $value O valor do método de pagamento (ex: 'Cartão de Crédito').
     * @return SalePaymentMethodEnum|null
     */
    public static function fromValue(string $value): ?SalePaymentMethodEnum
    {
        return self::tryFrom($value);
    }

    /**
     * Retorna todos os métodos de pagamento disponíveis.
     *
     * @return array
     */
    public static function getAllMethods(): array
    {
        return array_column(self::cases(), 'value');
    }
}
