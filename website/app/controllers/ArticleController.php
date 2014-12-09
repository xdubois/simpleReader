<?php

class ArticleController extends AuthorizedController {

	/**
	 * Display a listing of the resource.
	 * GET /article
	 *
	 * @return Response
	 */
	public function index() {

		$feeds = $this->user->feeds()->get();
		$items = [];
		foreach ($feeds as $feed) {
			foreach ($feed->articles()->get() as $item) {
				$items[] = $item;
			}
		}

		return View::make('front.articles.index', compact('items'));
	}

	/**
	 * Display the specified resource.
	 * GET /article/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


}