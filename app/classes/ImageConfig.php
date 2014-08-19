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
     * @var
     */
    protected $jsonConfigurations;

    /**
     * @param $jsonConfigurations
     * @param ImageOperation $imageOperation
     */
    public function __construct($jsonConfigurations, ImageOperation $imageOperation)
    {
        $this->imageOperation = $imageOperation;

        $this->jsonConfigurations = $jsonConfigurations;
    }

    /**
     * Get all configurations.
     *
     * @return array
     */
    public function get()
    {
        return $this->jsonConfigurations;
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
}