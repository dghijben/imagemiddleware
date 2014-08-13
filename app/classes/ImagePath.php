<?php

class ImagePath {

    const MODIFIERS_SEPARATION_CHAR = '-';
    const OPERATION_SEPARATION_CHAR = '__';

    /**
     * @param ImageModifier $imageModifier
     */
    public function __construct(ImageModifier $imageModifier)
    {
        $this->imageModifier = $imageModifier;
    }

    /**
     * @param $str
     * @return mixed
     */
    public function isImageModifier($str)
    {
        return $this->imageModifier->check($str);
    }

    /**
     * @param $path
     * @return array decoded path (array containing original image path and the operation)
     */
    public function decode($path)
    {
        $parts = explode(self::OPERATION_SEPARATION_CHAR, $path);

        $original_path = $parts[0];

        // If operation where given
        if(count($parts) == 2) {
            // Get operation without extension
            $operation = substr($parts[1], 0, strrpos($parts[1], '.'));
            // Add extension to original path
            $original_path .= substr($parts[1], strrpos($parts[1], '.'));

            return array($operation, $original_path);
        }

        return array($original_path, null);
    }
} 