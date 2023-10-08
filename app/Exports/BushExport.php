<?php

namespace App\Exports;

use AllowDynamicProperties;
use App\Http\Resources\Material\MaterialExportResource;
use App\Models\Bush;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

/**
 * @property Bush $bush
 */
#[AllowDynamicProperties] class BushExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    use HasHeadings;

    private mixed $projects;
    private array $bushMaterials;
    private \Illuminate\Http\Resources\Json\AnonymousResourceCollection $bushCollection;
    private array $alignment;

    public function __construct(Bush $bush)
    {
        $this->bush = $bush;
        $this->projects = $this->bush->projects;

        $this->bushMaterials = [];

        foreach ($this->projects as $project) {
            foreach ($project->materials as $item) {
                $this->bushMaterials[] = $item;
            }
        }

        $this->bushCollection = MaterialExportResource::collection($this->bushMaterials);
    }

    public function collection(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return $this->bushCollection;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cells = 'A1:I' . $this->bushCollection->count() + 1;
                $cellRange = 'A1:I1';
                $workCellRange = 'A2:I' . $this->bushCollection->count() + 1;
                $event->sheet->getDelegate()->getStyle($cells)->applyFromArray(getStyleArray());
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray(getHeaderStyleArray())->
                getFill()->applyFromArray([
                    'fillType' => 'solid',
                    'color' => ['rgb' => '33FFFF'],
                ]);
                $event->sheet->getDelegate()->getStyle($workCellRange)->applyFromArray(getWorkspaceStyleArray());
            },
        ];
    }
}
