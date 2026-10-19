<?php

namespace App\Services\ImagesUpload;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
class LocalUploadService implements UploadServiceInterface
{
    public function upload(array $data, Model $targetModel): Image{
        $path = $data['image']->store('photos', 'public');

        $image= $targetModel->image()->updateOrCreate(
            [
                'imageable_id'   => $targetModel->id
            ],
            ['path' => $path]);

        return $image;
    }

}
