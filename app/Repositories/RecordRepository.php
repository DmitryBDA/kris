<?php

namespace App\Repositories;

use App\Models\Record as Model;

class RecordRepository extends CoreRepository
{
  protected function createModel()
  {
    return app(Model::class);
  }

  /**
   * Добавление записей в БД
   * @param array $arData Массив с данными о добавляемых записях
   * @return boolean
   */
  public function addRecords(array $arData): bool
  {
    $result = $this->startCondition()::insert($arData);
    return $result;
  }

    public function getAllFromToday()
    {
        //Получить список записей от сегоднящнего дня
        $obRecordsList = $this->startCondition()
            ->whereDate('start', '>=', now()->format('Y-m-d 00:00:00'))
            ->orderBy('start', 'asc')
            ->get(['id', 'title', 'start', 'status'])
            ->append('className');

        return $obRecordsList->toArray();
    }

}
