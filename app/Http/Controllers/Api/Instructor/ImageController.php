<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreImageRequest;
use App\Services\ImagesUpload\UploadServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Model;

class ImageController extends Controller
{
    use ApiResponse;
    public function __construct(private UploadServiceInterface $service){}
    public function store(StoreImageRequest $request,$imageable_type, Model $imageable){
        $data= $request->validated();
        
        $image= $this->service->upload($data, $imageable);

        return $this->successResponse($image, "Image created successfully");
    }
}
