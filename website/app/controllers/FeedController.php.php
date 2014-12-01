<?php

class FeedController extends \BaseController {

	private $simplepie;
	private $striped_tags = ['base',
		'blink',
		'body',
		'doctype',
		'font',
		'form',
		'frame',
		'frameset',
		'html',
		'input',
		'marquee',
		'meta',
		'noscript',
		'script',
		'style',
	];

	public function __construct(SimplePie $simplepie) {
		$this->simplepie = $simplepie;
	}

	/**
	 * Display a listing of the resource.
	 * GET /feed.php
	 *
	 * @return Response
	 */
	public function index() {

		$urls = ['http://feeds.betacie.com/viedemerde',
						 'http://www.bonjourmadame.fr/',
						 'http://feeds.feedburner.com/blogeekch'];

		$this->simplepie->set_feed_url($urls);
		$this->simplepie->enable_cache(true);
		$this->simplepie->strip_htmltags($this->striped_tags);
		$this->simplepie->handle_content_type();
		$this->simplepie->force_feed();

		$this->simplepie->set_item_limit(2);
		
		$success = $this->simplepie->init();

		//if($this->simplepie->error());
		//
		//get_description();
		//get_author(s);
		//get_link(s)
		//get_type()
		//get_title()
		//get_permalink()
		//get_favicon();

		$items = $this->simplepie->get_items();

		// $this->simplepie->get_item_quantity();

		return View::make('feeds.index', compact('items'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /feed.php/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /feed.php
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /feed.php/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /feed.php/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /feed.php/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /feed.php/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}