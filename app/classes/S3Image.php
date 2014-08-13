<?php

class S3Image {

    /**
     * @param $bucket
     * @param $path
     * @return Intervention\Image\Image
     */
    public function get($bucket, $path)
    {
        $url = $this->getFullPath($bucket, $path);

        return Image::make($url);
    }

    /**
     * @param $bucket
     * @param $path
     * @return string
     */
    public function getFullPath($bucket, $path)
    {
        return 'http://'.$bucket.'.s3.amazonaws.com/'.$path;
    }

} 