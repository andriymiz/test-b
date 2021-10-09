<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketRequest;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    /**
     * For storing ticket
     *
     * @param TicketRequest $request
     * @param TicketService $service
     *
     * @return JsonResponse
     */
    public function create(TicketRequest $request, TicketService $service): JsonResponse
    {
        $service->create($request);

        return response()->json([
            'message' => 'Success',
        ]);
    }
}
