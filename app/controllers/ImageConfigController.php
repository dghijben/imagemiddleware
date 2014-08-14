<?php

class ImageConfigController extends \BaseController {

    /**
     * @param ImageConfig $imageConfig
     * @param API $api
     */
    public function __construct(ImageConfig $imageConfig, API $api)
    {
        $this->imageConfig = $imageConfig;
        $this->api = $api;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return Response::json($this->imageConfig->getJson());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
//        if(! $this->api->checkKey(Input::get('key')) || ! $this->api->checkSignature(Input::get('signature')))
//        {
//            return Response::make('Forbidden', 403);
//        }

        $this->imageConfig->set(Input::except('key', 'signature'));
	}
}
