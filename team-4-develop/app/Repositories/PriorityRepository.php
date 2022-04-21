<?php

namespace App\Repositories;

use App\Models\Position;
use App\Models\Priority;
use App\Repositories\IRepositories\IPriorityRepository;
use Illuminate\Http\Request;

class PriorityRepository extends AbstractRepository implements IPriorityRepository
{
    public function __construct(Priority $priority)
    {
        parent::__construct($priority);
    }

    public function get()
    {
        return $this->query()->get();
    }
}
