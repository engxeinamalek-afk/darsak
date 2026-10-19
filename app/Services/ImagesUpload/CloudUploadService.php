<?php

namespace App\Services\ImagesUpload;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
class CloudUploadService implements UploadServiceInterface
{
    public function upload(array $data, Model $targetModel): Image
    {
        $path = $data['image']->store('fake-cloud-chunks', 'public');

        $fileName = basename($path);
        $fakeCloudUrl = "https://amazonaws.com" . $fileName;

        $image = $targetModel->image()->updateOrCreate(
            [
                'imageable_id'   => $targetModel->id
            ],
            [
                'path' => $fakeCloudUrl // حفظ الرابط السحابي المزيف في قاعدة البيانات
            ]
        );

        return $image;
    }
}
