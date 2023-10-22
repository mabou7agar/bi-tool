<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetHotelStayRateHistoriesRequest;
use App\Presenters\GetHotelStayRateHistoriesPresenter;
use App\Services\HotelStayRateService;
use App\Traits\PaginationInfo;
use Illuminate\Http\JsonResponse;

class HotelStayRateController extends Controller
{
    use PaginationInfo;

    public function __construct(private HotelStayRateService $hotelStayRateService)
    {
    }

    public function histories(GetHotelStayRateHistoriesRequest $getHotelStayRateHistoriesRequest): JsonResponse
    {
        $dto = $getHotelStayRateHistoriesRequest->createGetHotelStayRateHistoriesDTO();
        $paginatedData = $this->hotelStayRateService->getPaginatedHistories($dto);

        return response()->json(
            [
                "items"=> GetHotelStayRateHistoriesPresenter::collection($paginatedData->getItems())
            ]+ $this->getPaginationInformation($dto->page, $dto->perPage, $paginatedData->getCount())
        );
    }
}
