<?php namespace UrlBuilder;

interface UrlBuilderInterface {

    /**
     * @param array $options
     * @return mixed
     */
    public function build(array $options = array());

} 