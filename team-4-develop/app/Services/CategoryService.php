<?php

namespace App\Services;

use App\Models\Enums\Category;
use App\Repositories\IRepositories\ICategoryRepository;
use App\Services\IServices\ICategoryService;
use Exception;
use Hamcrest\Type\IsNumeric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Response;

class CategoryService extends AbstractService implements ICategoryService
{

    public function __construct(ICategoryRepository $CategoryRepository)
    {
        parent::__construct($CategoryRepository);
    }

    public function paginate(Request $request)
    {
        if (!empty($request->search) || $request->search === '0') {
            return $this->repository->findByAttributes(['name'], $request)->paginate($request->limit);
        }

        return $this->repository->paginate($request);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->validated();
            $dataRespone = $this->repository->create($data);
            if (!empty($dataRespone)) {
                if (Cache::has('listCategory')) {
                    Cache::forget('listCategory');
                }
            }

            return $dataRespone;
        } catch (Exception $e) {
            Log::error($e);
            
            return Response::clientError();
        }
    }

    public function update(int $id, Request $request)
    {
        try {
            $data = $request->only('name', 'assignee', 'status');
            $status = [Category::INACTIVE, Category::ACTIVE];
            if (!in_array($data['status'], $status) || !is_int($data['status'])) {
                $data['status'] = Category::ACTIVE;
            }
            $dataRespone = $this->repository->update($id, $data);
            if (!empty($dataRespone)) {
                if (Cache::has('listCategory')) {
                    Cache::forget('listCategory');
                }
            }

            return $dataRespone;
        } catch (Exception $e) {
            Log::error($e);

            return Response::clientError();
        }
    }

    public function get()
    {
        return Cache::rememberForever('listCategory', function () {
            return $this->repository->get();
        });
    }

    public function delete($id)
    {
        try {
            $dataRespone = $this->repository->delete($id);
            if (!empty($dataRespone)) {
                if (Cache::has('listCategory')) {
                    Cache::forget('listCategory');
                }
            }

            return $dataRespone;
        } catch (Exception $e) {
            Log::error($e);

            return Response::clientError();
        }
    }
}
