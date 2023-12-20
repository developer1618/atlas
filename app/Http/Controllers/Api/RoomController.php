<?php

namespace App\Http\Controllers\Api;

use Botble\Hotel\Models\Room;
use Botble\Hotel\Models\RoomDate;
use Botble\Hotel\Tables\RoomTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Botble\Hotel\Repositories\Interfaces\RoomInterface;
use Botble\Slug\Facades\SlugHelper;
use Botble\Hotel\Facades\HotelHelper;
use Botble\Hotel\Enums\ReviewStatusEnum;
use Botble\Media\Facades\RvMedia;
class RoomController extends Controller
{
    protected $roomRepository;

    public function __construct(RoomInterface $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    public function index(Request $request)
    {
        $filters = [
            // Ваши фильтры, если есть
        ];

        $params = [
            'paginate' => [
                'per_page' => $request->input('per_page', 10),
                'current_paged' => $request->input('page', 1),
            ],
            'with' => [
                'amenities',
                'amenities.metadata',
                // Другие отношения, если есть
            ],
        ];

        $rooms = $this->roomRepository->getRooms($filters, $params);

        return response()->json(['rooms' => $rooms]);
    }

    public function show(int $roomId)
    {
        $room = Room::with([
            'amenities',
            'currency',
            'category'
        ])
            ->findOrFail($roomId);

        return response()->json(['room' => $room]);
    }
}