<?php

namespace App\Services;

use App\Repositories\IRepositories\IPositionRepository;
use App\Services\IServices\IPositionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PositionService extends AbstractService implements IPositionService
{
    public function __construct(IPositionRepository $positionRepository)
    {
        parent::__construct($positionRepository);
    }

    public function get()
    {
        return Cache::rememberForever('positions', function () {
            return $this->repository->get();
        });
    }
}
