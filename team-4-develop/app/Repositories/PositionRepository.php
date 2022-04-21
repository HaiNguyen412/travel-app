<?php

namespace App\Repositories;

use App\Models\Position;
use App\Repositories\IRepositories\IPositionRepository;
use Illuminate\Http\Request;

class PositionRepository extends AbstractRepository implements IPositionRepository
{
    public function __construct(Position $position)
    {
        parent::__construct($position);
    }

    public function get()
    {
        return $this->query()->get();
    }
}
