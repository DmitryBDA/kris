<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ServiceController extends Controller
{
  public function get(ServiceRepository $serviceRepository)
  {
    $arServiceList = $serviceRepository->getAll();
    return response()->json($arServiceList, ResponseAlias::HTTP_OK);
  }
}
