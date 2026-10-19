<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Services\ImagesUpload\UploadServiceInterface;
use Illuminate\Database\Eloquent\Model;

class ImageController extends Controller
{
    public function __construct(private UploadServiceInterface $service){}
    public function store(StoreImageRequest $request,$imageable_type, Model $imageable){
        $data= $request->validated();
        
        $image= $this->service->upload($data, $imageable);

        return \response()->json([$image]);
    }
}
