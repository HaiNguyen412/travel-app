<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseIndexRequest;
use App\Http\Resources\PositionResource;
use App\Services\IServices\IPositionService;

class PositionController extends Controller
{
    private $positionService;

    public function __construct(IPositionService $positionService)
    {
        $this->middleware(['jwt.auth']);
        $this->positionService = $positionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PositionResource::collection(
            $this->positionService->get()
        );
    }
}
