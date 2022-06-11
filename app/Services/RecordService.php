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

}
