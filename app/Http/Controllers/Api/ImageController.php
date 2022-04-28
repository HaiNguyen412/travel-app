<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\ImageUploadRequest;
use App\Models\User;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function upload(ImageUploadRequest $request)
    {
        try {
            /**
             * Update the images
             *
             * @param \Illuminate\Http\Request $request
             * @return \Illuminate\Http\Response
             */

            $file = $request->file('file');
            $path = $file->store(config("images.$request->entity.path"));

            $imageData = [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
            ];

            switch ($request->entity) {
                case app(User::class)->getTable():
                    $image = User::findOrFail($request->entity_id)->image()->create($imageData);
                    break;
                default:
                    throw new \Exception();
                    break;
            }

            return \Response::showSuccess($image);
        } catch (\Exception $e) {
            return \Response::serverError();
        }
    }
}
