<?php

class API {

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @param $key
     * @param $secret
     */
    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    /**
     * @param $key
     * @return bool
     */
    public function checkKey($key)
    {
        return $key !== $this->key;
    }

    /**
     * @param $signature
     * @param int $tolerance
     * @return bool
     */
    public function checkSignature($signature, $tolerance = 4)
    {
        $current = time();

        for($i = 0; $i < $tolerance; $i ++)
        {
            if($signature === $this->generateSignature($this->key, $this->secret, $current)) {

                return true;
            }

            $current ++;
        }

        return false;
    }

    /**
     * @param $key
     * @param $secret
     * @param $timestamps
     * @return string
     */
    public function generateSignature($key, $secret, $timestamps)
    {
        return md5($key.$timestamps.$secret);
    }

} 