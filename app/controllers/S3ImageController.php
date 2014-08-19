<?php

use UrlBuilder\S3UrlBuilder;

class S3ImageController extends BaseController {

    /**
     * @param ImageOperation $imageOperation
     * @param ImageCache $imageCache
     * @param ImageConfig $imageConfig
     * @param UrlBuilder\S3UrlBuilder $s3UrlBuilder
     */
    public function __construct(ImageOperation $imageOperation, ImageCache $imageCache, ImageConfig $imageConfig, S3UrlBuilder $s3UrlBuilder)
    {
        $this->imageOperation = $imageOperation;
        $this->imageCache = $imageCache;
        $this->imageConfig = $imageConfig;
        $this->s3UrlBuilder = $s3UrlBuilder;
    }

    /**
     * @param $bucket
     * @param $name
     * @param $operations
     * @param $path
     * @return mixed
     */
    public function process($bucket, $name, $operations, $path)
    {
        $operations = $this->imageOperation->decode($operations);

        $url = $this->s3UrlBuilder->build(compact('bucket', 'path'));

        $image = Image::make($url);

        // Run operations on this image if operation exists in the image configuration.
        foreach($operations as $operation)
        {
            if(! $this->imageConfig->hasOperations($name, $operation)) {

                return Response::make("Image configuration not found!", 400);
            }

            $operation->run($image);
        }

        // Only cache image if an operation has occurred on it
        if(! Input::get('no-cache')) {
            // Cache this image
            $this->imageCache->save($image);
        }

        //
        return $image->response();
    }
}