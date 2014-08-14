<?php

class ImageController extends BaseController {

    const URL_INPUT = 'i';
    const TIME_INPUT = 'k';

    /**
     * @param ImageOperation $imageOperation
     * @param ImageCache $imageCache
     * @param ImageConfig $imageConfig
     */
    public function __construct(ImageOperation $imageOperation, ImageCache $imageCache, ImageConfig $imageConfig)
    {
        $this->imageOperation = $imageOperation;
        $this->imageCache = $imageCache;
        $this->imageConfig = $imageConfig;
    }

    /**
     * @param $name
     * @param $operations
     * @param $baseTime
     * @return mixed
     */
    public function process($name, $operations, $baseTime)
    {
        dd('Processing');
        if(! $this->checkRequestTime(time(), Input::get(self::TIME_INPUT), $baseTime)) {

            return Response::make('Forbidden', 403);
        }

        $operations = $this->imageOperation->decode($operations);

        $image = Image::make(Input::get(self::URL_INPUT));

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

    /**
     *
     */
    protected function checkRequestTime($current, $requestTime, $baseTime, $tolerance = 30)
    {
        $requestTime = $requestTime + $baseTime;

        $start = $current - $tolerance;

        return $requestTime >= $start && $requestTime <= $current;
    }
}