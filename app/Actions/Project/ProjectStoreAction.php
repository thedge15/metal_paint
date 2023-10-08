<?php

namespace App\Actions\Project;

use App\Actions\StoreUpdateAction;
use Illuminate\Http\Request;

class ProjectStoreAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->getRequest()->validate([
            'bush_id' => 'required|integer',
            'title' => 'required|string',
            'change' => 'nullable|integer',
        ]);
    }
}
