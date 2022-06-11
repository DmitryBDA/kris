<?php

namespace App\Http\Controllers\Admin;

use App\DTO\CreateRecordDto;
use App\DTO\UpdateRecordDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRecordRequest;
use App\Http\Requests\UpdateRecordRequest;
use App\Repositories\RecordRepository;
use App\Repositories\UserRepository;
use App\Services\RecordService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RecordController extends Controller
{
    protected mixed $recordRepository;

    public function __construct()
    {
        $this->recordRepository = app(RecordRepository::class);
    }

    /**
     * @OA\Get(
     *     path="api/admin/records",
     *     description="Получить все записи",
     *     @OA\Response(
     *         response="200",
     *        @OA\JsonContent(
     *                  (type="array", @OA\Items(
     *                      @OA\Property(property="id", type="integer"),
     *                      @OA\Property(property="status", type="integer"),
     *                      @OA\Property(property="start", type="dateTime"),
     *                      @OA\Property(property="title", type="string"),
     *                      @OA\Property(property="className", type="string"),
     *                  )
     *             )
     *         )
     *     )
     */
    public function records(): \Illuminate\Http\JsonResponse
    {
        $arRecordsList = $this->recordRepository->getAllFromToday();
        return response()->json($arRecordsList, ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="api/admin/records",
     *     description="Создать новые записи",
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="date", type="string", description="Дата для которой создаются записи"),
     *              @OA\Property(property="timeRecords", type="array", description="время каждой записи", @OA\Items(
     *                      @OA\Property(property="status", type="integer"),
     *                      @OA\Property(property="time", type="string"),
     *                      @OA\Property(property="title", type="string"),
     *                  )),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="201",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="bool"),
     *         )
     *     ),
     * )
     *
     * Создать новые записи
     * @param CreateRecordRequest $request
     * @param RecordService $recordService
     * @return JsonResponse
     */
    public function create(CreateRecordRequest $request,
                           RecordService       $recordService): \Illuminate\Http\JsonResponse
    {
        //Формируем dto из данных запроса
        $dto = CreateRecordDto::fromRequest($request);

        //Формируем данные для вставки в нужном формате
        $arDataForInsert = $recordService->generateArrayDataForInsert($dto);

        //Добавляем записи в БД
        $res = $this->recordRepository->addRecords($arDataForInsert);

        return response()->json(['success' => $res], 201);
    }

}
