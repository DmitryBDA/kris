<?php

namespace App\Services;

use App\DTO\CreateRecordDto;
use App\DTO\UpdateRecordDto;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;

class RecordService
{
  public function generateArrayDataForInsert(CreateRecordDto $dto): array
  {
    $result = [];
    foreach ($dto->records as $record) {
      $date = $dto->date . ' ' . $record['time'];
      $arrData = [
        'title' => $record['title'] ?? '',
        'start' => $date,
        'end' => $date,
        'status' => $record['status']
      ];
      $result[] = $arrData;
    }
    return $result;
  }

    public function generateArrDataForRecord(array $arRecord): array
    {
        $obDate = Carbon::create($arRecord['start']);

        $arRecord['time'] = $obDate->format('H:i');
        $arRecord['dayWeek'] = Date::parse($arRecord['start'])->format('l');
        $arRecord['date'] = Date::parse($arRecord['start'])->format('d F Y');

        return $arRecord;
    }
}
