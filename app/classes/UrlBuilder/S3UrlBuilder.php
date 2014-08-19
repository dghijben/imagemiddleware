<?php namespace UrlBuilder;

class S3UrlBuilder implements UrlBuilderInterface {

    /**
     * @param array $options
     * @return mixed
     */
    public function build(array $options = array())
    {
        $bucket = $options['bucket'];
        $path = $options['path'];

        return 'http://'.$bucket.'.s3.amazonaws.com/'.$path;
    }
}