<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Record
 *
 */
class Record extends Model
{
    use HasFactory;

    /** @var string[] Заполняемые поля модели */
    protected $fillable = [
        'title',
        'start',
        'end',
        'status',
        'service_id',
        'user_id',
        'comment'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    // Добавление атрибута className в зависимости от статуса
    // при использовании toArray()
    public function getClassNameAttribute()
    {
        switch ($this->status) {
            case 1:
                return "greenEvent";
            case 2:
                return "yellowEvent";
            case 3:
                return "redEvent";
            case 4:
                return "greyEvent";
        }
    }
}
