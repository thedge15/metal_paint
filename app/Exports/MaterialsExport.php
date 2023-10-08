<?php

namespace App\Exports;

use App\Http\Resources\Material\MaterialExportResource;
use App\Models\Material;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

/**
 * @property Project $project
 */
class MaterialsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    use HasHeadings;

    /**
     * @var Builder[]|Collection
     */
    private array|Collection $materials;

    /**
     * @param Project $project
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->materials = Material::query()->where('project_id', $this->project->id)->get();
    }
    /**
     * @return AnonymousResourceCollection
     */
    public function collection(): AnonymousResourceCollection
    {
        return MaterialExportResource::collection($this->materials);
    }
    /**
     * @return string[]
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cells = 'A1:I' . $this->materials->count() + 1;
                $cellRange = 'A1:I1';
                $workCellRange = 'A2:I' . $this->materials->count() + 1;
                $event->sheet->getDelegate()->getStyle($cells)->applyFromArray(getStyleArray());
                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray(getHeaderStyleArray());
                $event->sheet->getDelegate()->getStyle($workCellRange)->applyFromArray(getWorkspaceStyleArray());
            },
        ];
    }
}
