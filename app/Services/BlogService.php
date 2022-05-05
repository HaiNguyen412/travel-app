<?php

namespace App\Services;

use App\Models\Blog;
use App\Services\IServices\IBlogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogService extends AbstractService implements IBlogService
{

    public function __construct(Blog $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request, $limit = 10)
    {
        // todo: tạo request validated field của blog. => dùng request->tên_field
        // todo: search theo name thì $request->name chứ không đặt params rồi lại isset($params['params'])

//        $params = $request->all();
//        $results = Blog::when(isset($params['params']), function ($query) use ($params) {
//            return $query->where('blogs.name', 'like', '%' . $params['params'] . '%');
//        })
//            ->paginate($request->limit);
//        if (isset($params['params'])) {
//            $results->appends(['params' => $params['params']]);
//        }

        // todo: Biết $this->query là ở đâu ko? Ko thì trỏ vào nó. Nó nằm trong BaseService
        // todo: Tự so sánh 2 đoạn code. Hiểu rồi thì xoá nó đi nha
        return $this->query()->when($request->name, function ($query, $name) {
            return $query->search('name', $name);
        })->paginate($limit);
    }

    public function create(Request $request)
    {

        // todo: tạo request validated giá trị của blog. => dùng request->validated()
        $blog = $request->all();

        return Blog::create($blog);
    }

    public function like(Request $request, $id)
    {
        // todo: Sửa lại hết như index a làm mẫu. Tạo request để validate
        $id = $request->id;
        $params = $request->like;
        if ($params == 1) {
            return Blog::where('id', $id)->update([
                'like_total' => DB::raw('like_total+1')
            ]);
        } else {
            return Blog::where('id', $id)->update([
                'like_total' => DB::raw('like_total-1')
            ]);
        }
    }

    public function dislike(Request $request, $id)
    {
        // todo: Sửa lại hết như index a làm mẫu. Tạo request để validate

        $id = $request->id;
        $params = $request->dislike;
        if ($params == 1) {
            return Blog::where('id', $id)->update([
                'dislike_total' => DB::raw('dislike_total+1')
            ]);
        } else {
            return Blog::where('id', $id)->update([
                'dislike_total' => DB::raw('dislike_total-1')
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        // todo: Sửa lại hết như index a làm mẫu. Tạo request để validate
        // todo: Xem baseservice nó có sẵn update rồi. Lấy của nó mà dùng
        $blog = $request->all();
        return Blog::findOrFail($id)->update($blog);
    }

    public function delete($id)
    {
        // todo: Sửa lại hết như index a làm mẫu. Tạo request để validate
        // todo: Xem baseservice nó có sẵn update rồi. Lấy của nó mà dùng
        return Blog::findOrFail($id)->delete();
    }
}
