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

        $this->configurations = $this->loadConfig();
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
     * @param $identifier
     * @param ImageOperation $operation
     * @return bool
     */
    public function hasOperations($identifier, ImageOperation $operation)
    {
        foreach($this->get() as $configIdentifier => $configOperations) {

            if($configIdentifier !== $identifier) continue;

            foreach($configOperations as $configOperation)
            {
                if($this->matchOperation($configOperation, $operation)) return true;
            }
        }

        return false;
    }

    /**
     * @param $operation1
     * @param $operation2
     * @return bool
     */
    protected function matchOperation(ImageOperation $operation1, ImageOperation $operation2)
    {
        return $operation1->match($operation2);
    }

    /**
     * @return array
     */
    protected function loadConfig()
    {
        $configurations = array();

        $json = $this->getJson();

        foreach($json as $identifier => $jsonOperations) {

            $configurations[$identifier] = array();

            foreach($jsonOperations as $method => $params) {

                $configurations[$identifier][] = $this->imageOperation->make($method, $params);
            }
        }

        return $configurations;
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
        return app_path('/json/operations.json');
    }
}