<?php

use Intervention\Image\Image;

class ImageCache {

    /**
     * @param Image $image
     */
    public function save(Image $image)
    {
        // Save image to the cached url
        $image->save($this->getCachedPath());
    }

    /**
     * Get current uri
     */
    public function getCachedPath()
    {
        $pathinfo = pathinfo(Request::path());

        $full_path = public_path($pathinfo['dirname']);

        if(! file_exists($full_path)) {

            mkdir($full_path, 0777, true);
        }

        return public_path($pathinfo['dirname'].'/'.$pathinfo['basename']);
    }

} 