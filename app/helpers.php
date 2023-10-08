<?php

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

if (!function_exists('getStyleArray')) {
    /**
     * @return array
     */
    function getStyleArray(): array
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'font' => [
                'name' => 'Times New Roman',
            ],
        ];
    }
};
if (!function_exists('getHeaderStyleArray')) {
    /**
     * @return array
     */
    function getHeaderStyleArray(): array
    {
        return [
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => [
                        'rgb' => '808080'
                    ]
                ],
                'top' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => [
                        'rgb' => '808080'
                    ]
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => [
                        'rgb' => '808080'
                    ]
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_THICK,
                    'color' => [
                        'rgb' => '808080'
                    ]
                ],
            ],
        ];
    }
}

if (!function_exists('getWorkspaceStyleArray')) {
    /**
     * @return array
     */
    function getWorkspaceStyleArray(): array
    {
        return [
            'borders' => [
                'bottom' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => [
                        'rgb' => '808080'
                    ]
                ],
                'top' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => [
                        'rgb' => '808080'
                    ]
                ],
                'right' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => [
                        'rgb' => '808080'
                    ]
                ],
                'left' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color' => [
                        'rgb' => '808080'
                    ]
                ],
            ],

        ];
    }
};
