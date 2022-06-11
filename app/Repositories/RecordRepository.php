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

}
