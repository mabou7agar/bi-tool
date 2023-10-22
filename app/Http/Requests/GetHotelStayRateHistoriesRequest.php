<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DTOs\GetHotelStayRateHistoriesDTO;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class GetHotelStayRateHistoriesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'date_of_stay' => 'required|date|date_format:Y-m-d',
            'hotel_name' => 'required|exists:hotels,name',
            'page' => 'int',
            'per_page' => 'int',
        ];
    }

    public function createGetHotelStayRateHistoriesDTO(): GetHotelStayRateHistoriesDTO
    {
        return new GetHotelStayRateHistoriesDTO(
            hotelName:  $this->get('hotel_name'),
            dateOfStay: Carbon::createFromFormat('Y-m-d', $this->get('date_of_stay')),
            page:       (int) $this->get('page', 1),
            perPage:    (int) $this->get('per_page', 15)
        );
    }
}
