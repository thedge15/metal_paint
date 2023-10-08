<?php

namespace App\Exports;

trait HasHeadings
{
    public function headings(): array
    {
        return [
            '##',
            'Наименование РД',
            'Элемент',
            'Наименование',
            'Количество',
            'Ед.изм.',
            'Краска',
            'Количество, кг',
            'Цвет',
        ];
    }
}
