<?php

class ImageConfig {

    /**
     * @var array
     */
    protected $configurations = array();

    /**
     * @var ImageOperation
     */
    protected $imageOperation;

    /**
     * @param ImageOperation $imageOperation
     */
    public function __construct(ImageOperation $imageOperation)
    {
        $this->imageOperation = $imageOperation;

        $this->loadConfig();
    }

    /**
     * Set configuration from the given array
     *
     * @todo validate given configurations
     * @param $array
     */
    public function set($array){

        file_put_contents($this->getJsonPath(), json_encode($array));
    }

    /**
     * Get all configurations.
     *
     * @return array
     */
    public function get()
    {
        return $this->configurations;
    }

    /**
     * @param $name
     * @param ImageOperation $operation
     * @return bool
     */
    public function hasOperations($name, ImageOperation $operation)
    {
        foreach($this->get() as $configuration) {

            if($configuration->name !== $name) continue;

            foreach($configuration->operations as $configOperation)
            {
                if($this->matchOperation($configOperation, $operation)) return true;
            }
        }

        return false;
    }

    /**
     * @param $configOperation
     * @param ImageOperation $operation
     * @return bool
     */
    protected function matchOperation($configOperation, ImageOperation $operation)
    {
        return $operation->match($configOperation);
    }

    public function loadConfig()
    {
        $this->configurations = $this->getJson();
    }

    /**
     * @return array
     */
    public function getJson()
    {
        return json_decode(file_get_contents($this->getJsonPath()));
    }

    /**
     * @return string
     */
    protected function getJsonPath()
    {
        $path = '/json/'.App::environment().'_configurations.json';

        return app_path($path);
    }
}