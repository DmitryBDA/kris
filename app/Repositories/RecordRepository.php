<?php

namespace App\Repositories;

use App\Models\Record as Model;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function getById($id)
    {
        $obRecord = $this->startCondition()
            ->where('id', $id)
            ->select('id', 'comment', 'start', 'service_id', 'status', 'title', 'user_id')
            ->with('user:id,surname,name,phone')
            ->first();

        if($obRecord) return $obRecord->toArray();

        throw new NotFoundHttpException("Запись с id [$id] не найдена");
    }

}
