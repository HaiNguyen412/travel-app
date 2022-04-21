<?php

namespace App\Services;

use App\Repositories\IRepositories\IPriorityRepository;
use App\Services\IServices\IPriorityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PriorityService extends AbstractService implements IPriorityService
{

    public function __construct(IPriorityRepository $IPriorityRepository)
    {
        parent::__construct($IPriorityRepository);
    }

    public function get()
    {
        return Cache::rememberForever('priorities', function () {
            return $this->repository->get();
        });
    }
}
