<?php

class S3ImageController extends BaseController {

    /**
     * @param S3Image $s3Images
     * @param ImageOperation $imageOperation
     * @param ImageCache $imageCache
     * @param ImageConfig $imageConfig
     */
    public function __construct(S3Image $s3Images, ImageOperation $imageOperation,
                                ImageCache $imageCache, ImageConfig $imageConfig)
    {
        $this->s3Images = $s3Images;
        $this->imageOperation = $imageOperation;
        $this->imageCache = $imageCache;
        $this->imageConfig = $imageConfig;
    }

    /**
     * @param $bucket
     * @param $identifier
     * @param $operations
     * @param $path
     * @return mixed
     */
    public function process($bucket, $identifier, $operations, $path)
    {
        $operations = $this->imageOperation->decode($operations);

        // Get original image from s3
        $image = $this->s3Images->get($bucket, $path);

        // Run operations on this image if operation exists in the image configuration.
        foreach($operations as $operation)
        {
            if(! $this->imageConfig->hasOperations($identifier, $operation)) {

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