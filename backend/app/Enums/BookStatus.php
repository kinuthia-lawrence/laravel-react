<?php

namespace App\Enums;

enum BookStatus: string
{
    case AVAILABLE = 'available';
    case OUT_OF_STOCK = 'out_of_stock';
    case COMING_SOON = 'coming_soon';
    
    /**
     * Get all values as an array
     *
     * @return array
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}