<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class CoreRepository
{
    /** @var Model */
    protected $model;

    public function __construct()
    {
        $this->model = $this->createModel();
    }

    abstract protected function createModel();

    protected function startCondition()
    {
        return clone $this->model;
    }
}
