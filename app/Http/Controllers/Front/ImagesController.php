<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImagesController extends Controller
{
    public function index($disk, $width, $height, $image_path)
    {
        abort_unless($disk === 'public', 404);

        $width = (int) $width;
        $height = (int) $height;

        abort_if($width < 1 || $height < 1 || $width > 2000 || $height > 2000, 404);

        if (!Storage::disk($disk)->exists($image_path)) {
            abort(404);
        }
        $path = Storage::disk($disk)->path($image_path);

        $image = Image::make($path);

        $image->resize($width, $height, function ($e) {
            $e->aspectRatio();
        })->crop($width, $height);

        $fontPath = storage_path('app/ARLRDBD.TTF');

        if (is_file($fontPath)) {
            $image->text(config('app.name', 'Digital Hub'), $width / 2, $height / 2, function ($e) use ($fontPath) {
                $e->file($fontPath);
                $e->size(20);
                $e->color([0, 0, 0, 0.5]);
                $e->align('center');
                $e->valign('middle');
            });
        }

        return $image->response('webp');
    }
}
