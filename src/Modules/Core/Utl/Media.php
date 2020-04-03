<?php

namespace App\Modules\Core\Utl;

class Media
{
    /**
     * Upload the given image.
     *
     * @param  object  $image
     * @param  string  $dir
     * @return string
     */
    public function uploadImage($image, $dir)
    {
        $image = \Image::make($image);
        return $this->saveImage($image, $dir);
    }

    /**
     * Upload the given image.
     *
     * @param  object  $image
     * @param  string  $dir
     * @return string
     */
    public function uploadImageBas64($image, $dir)
    {
        if (! strlen($image)) {
            return null;
        }

        $base  = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
        $image = \Image::make($base);

        return $this->saveImage($image, $dir);
    }

    /**
     * Delete the given image.
     *
     * @param  object $path
     * @return void
     */
    public function deleteImage($path)
    {
        \Storage::delete($path);
    }

    /**
     * Save the given image.
     *
     * @param  object  $image
     * @param  string  $dir
     * @return string
     */
    protected function saveImage($image, $dir)
    {
        $imageName = 'image'.uniqid().time().'.jpg';
        $path      = 'public'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$imageName;
        \Storage::put($path, $image->stream());

        return $path;
    }
}
