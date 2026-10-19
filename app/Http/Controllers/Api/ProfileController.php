<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ImagesUpload\UploadServiceInterface;
use App\Http\Requests\StoreImageRequest;
class ProfileController extends Controller
{
    public function __construct(private UploadServiceInterface $service){}
    public function storeImage(StoreImageRequest $request){
        $data= $request->validated();

        $image= $this->service->upload($data, $request->user());

        return \response()->json([$image]);
    }
}
