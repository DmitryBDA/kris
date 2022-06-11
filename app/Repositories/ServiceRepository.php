<?php

namespace App\Repositories;


use App\Models\Service as Model;
use Illuminate\Support\Carbon;

class ServiceRepository extends CoreRepository
{
    protected function createModel()
    {
        return app(Model::class);
    }

    public function getAll()
    {
        //Получить список услуг
        $arServicesList = $this->startCondition()
            ->orderBy('id', 'asc')
            ->get(['id', 'name', 'price'])
            ->toArray();

        return $arServicesList;
    }

}
