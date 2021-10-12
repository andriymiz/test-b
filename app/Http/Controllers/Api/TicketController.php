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
        $user = $service->findUser($request->username, $request->email);
        $withPassword = $service->checkPassword($user, $request->password);
        $service->create($request, $user, $withPassword);

        return response()->json([
            'message' => 'Success',
        ]);
    }
}
