<?php

namespace App\Enums;

enum BookGenre: string
{
    case FICTION = 'fiction';
    case NON_FICTION = 'non_fiction';
    case SCIENCE = 'science';
    case HISTORY = 'history';
    case BIOGRAPHY = 'biography';
    case FANTASY = 'fantasy';
    case MYSTERY = 'mystery';
    case ROMANCE = 'romance';
    case THRILLER = 'thriller';
    case HORROR = 'horror';
    case SCIENCE_FICTION = 'science_fiction';
    
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