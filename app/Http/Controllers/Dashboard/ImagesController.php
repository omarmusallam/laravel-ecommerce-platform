<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImagesController extends Controller
{
    public function index($disk, $width, $height, $image_path)
    {
        if (!Storage::disk($disk)->exists($image_path)) {
            abort(404);
        }
        $path = Storage::disk($disk)->path($image_path);

        $image = Image::make($path);

        $image->resize($width, $height, function ($e) {
            $e->aspectRatio();
        })->crop($width, $height);

        $image->text('Golden-store', $width / 2, $height / 2, function ($e) {
            $e->file(storage_path('app/ARLRDBD.TTF'));
            $e->size(20);
            $e->color([0, 0, 0, 0.5]);
            $e->align('center');
            $e->valign('middle');
        });

        return $image->response('webp');
    }
}