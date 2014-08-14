<?php

class ImageOperation {

    const OPERATION_SEPARATOR = '-';
    const PARAMS_SEPARATOR = '_';

    /**
     * @var array
     */
    protected static $allowedMethods = array(
        'resize', 'fit'
    );

    /**
     * @var string
     */
    protected $method = '';

    /**
     * @var array
     */
    protected $params = array();

    /**
     * @param $method
     * @param array $params
     */
    public function __construct($method = '', $params = array())
    {
        $this->method = $method;
        $this->params = $params;
    }

    /**
     * @param ImageOperation $operation
     * @return bool
     */
    public function match($operation)
    {
        if($this->method != $operation->method) return false;

        if(count($this->params) != count($operation->params)) return false;

        for($i = 0; $i < count($operation->params); $i++) {

            if($operation->params[$i] != $this->params[$i]) return false;
        }

        return true;
    }

    /**
     * @param $method
     * @param array $params
     * @return static
     */
    public static function make($method, $params = array())
    {
        return new static($method, $params);
    }

    /**
     * resize_300_400-crop_fit
     *
     * @param $operationsString
     * @return ImageOperation[]
     */
    public static function decode($operationsString)
    {
        $operations = array();

        $operationsString = explode(self::OPERATION_SEPARATOR, $operationsString);

        foreach($operationsString as $operationString)
        {
            $parts = explode(self::PARAMS_SEPARATOR, $operationString);

            $operations[] = static::make(array_shift($parts), $parts);
        }

        return $operations;
    }

    /**
     * @param $image
     * @return \Intervention\Image\Image
     */
    public function run($image)
    {
        if(in_array($this->method, static::$allowedMethods))
        {
            return call_user_func_array(array($image, $this->method), $this->params);
        }
    }
}