<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetHotelStayRateHistoriesRequest;
use App\Presenters\GetHotelStayRateHistoriesPresenter;
use App\Services\HotelStayRateService;

class HotelStayRateController extends Controller
{
    public function __construct(private HotelStayRateService $hotelStayRateService)
    {
    }

    public function histories(GetHotelStayRateHistoriesRequest $getHotelStayRateHistoriesRequest)
    {
        $histories = $this->hotelStayRateService->getHistories(
            $getHotelStayRateHistoriesRequest->createGetHotelStayRateHistoriesDTO()
        );

        return response()->json(GetHotelStayRateHistoriesPresenter::collection($histories));
    }
}
