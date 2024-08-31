<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ImageHelper
{
    public static function getImage($destinationpath, $icon)
    {
        $image = '';
        if (!empty($icon)) {
            $image_url = $destinationpath . $icon;
            $get_image = Storage::disk('s3')->exists($image_url);
            if ($get_image == 1) {
                $image = Storage::disk('s3')->url($image_url);
            }
        }

        return $image;
    }
    //store image in laravel directory
    public static function storeImage($image_object, $folderName, $key_name = null, $add_timestamp = true, $disk = 'public')
    {

        Log::info(['ImageHelper' => $folderName]);

        $img = $image_object;

        // if($file_name == null){
            $file_name = str_replace(" ", "_", $img->getClientOriginalName());
        // }
        if ($add_timestamp) {
            $file_name = Carbon::now()->timestamp . $file_name;
        }

        Log::info(['Adding image ' => $file_name, 'folder name ' => $folderName]);
        if ($disk == 'public') {
            $folderName = 'images/' . $folderName;
            $file_upload_success = Storage::disk($disk)->put($folderName . '/' . $file_name, file_get_contents($img), 'public');
        } else {
            // if($file_name == null) {
            //     $content = file_get_contents($img); 
            // } else {
            //     $content = stream_get_contents($img);
            // }
            $file_upload_success = Storage::disk($disk)->put($folderName . '/' . $file_name, file_get_contents($img));
        }


        Log::info(['Uploading folder status ' => $file_upload_success]);

        return ($file_upload_success) ? $file_name : null;
    }

    public static function destroyImage($image, $path, $disk = 'public')
    {
        $image_url = $path . '/' . $image;
        if ($disk == 'public') {
            $image_url = 'images/' . $path . '/' . $image;
        }
        // dd($image_url);
        if (Storage::disk($disk)->exists($image_url)) {
            Storage::disk($disk)->delete($image_url);
        }
    }

    public static function destroyFolder($path, $disk = 'public')
    {
        $image_url = $path;
        if ($disk == 'public') {
            $image_url = 'images/' . $path;
        }
        if (Storage::disk($disk)->exists($image_url)) {
            Storage::disk($disk)->deleteDirectory($image_url);
        }
    }

    public static function downloadZip($images, $folderName, $zipName)
    {
        $zipFileName = $zipName . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName); // set local path to create zip

        if (file_exists($zipFilePath)) // delete .zip if already exist
            @unlink($zipFilePath);

        $zip = new Filesystem(new ZipArchiveAdapter($zipFilePath)); // create zip object

        // add images to zip object
        foreach ($images as $image) {
            $file_content = Storage::disk('s3')->get($folderName . '/' . $image->image_name);
            // $fileName = explode('/', $image->file_path);
            $zip->put($image->image_name, $file_content);
        }
        return url()->to('storage/' . $zipFileName);
    }
}

