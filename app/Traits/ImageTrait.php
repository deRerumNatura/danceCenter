<?php
/**
 * Created by PhpStorm.
 * User: марк
 * Date: 24.04.2018
 * Time: 14:52
 */

namespace App\Traits;


use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    private function uploadImage ($request, $path) {

        $recivedImage = $request->file($path.'_img');
//        dump($request->all());
        if ( $request->hasFile($path.'_img') ) {
//            dump('image isset!');
            $filenameToUpload = $this->prepareImage($recivedImage, $path);
        }
        else {
//            dump('no image!');
            $filenameToUpload = 'noimage.jpg';
        }
//        die();
        $requestToUpload = $request->all();
        unset($requestToUpload[$path.'_img']);
        $requestToUpload[$path.'_img'] = $filenameToUpload;

        return $requestToUpload;
    }

    public function prepareImage($imageToUploading, $path)
    {
        //==============================================================================
        //upload file
        //todo $request->file('cover_image') == $imageToUploading
        //Get filename with the extention
        $filenameWithExt = $imageToUploading->getClientOriginalName();
        //Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //Get just extention
        $extention = $imageToUploading->getClientOriginalExtension();
        //filename to store
        $fileNameToStore = $filename . '_' . time() . '.' . $extention;
        //Store image in dir
        $path = $imageToUploading->storeAs('public/img/' . $path, $fileNameToStore);

        return $fileNameToStore;
    }

    public function deleteImage($imageToDeleting, $path)
    {
        //todo $posts->cover_image == $imageToDeleting
        if ($imageToDeleting != 'noimage.jpg') {
            Storage::delete('public/img/' . $path . '/' . $imageToDeleting);
            return true;
        } else {
            return false;
        }
    }
}