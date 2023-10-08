<?php

namespace App\Actions\Project;

use App\Actions\StoreUpdateAction;

class ProjectUpdateAction extends StoreUpdateAction
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->getRequest()->validate([
            'title' => 'required|string',
            'change' => 'required|integer',
        ]);
    }
}
