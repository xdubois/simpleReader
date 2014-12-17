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
	public function show($id = '', $filter = null) {
		if (is_numeric($id)) {
			$items = Feed::findOrFail($id)->articles()
																		->whereNull('articles.unread')
																		->orWhere('articles.unread', TRUE)
																		->get();												
		}
		else {
			switch ($id) {
				case 'subscriptions': // subscriptions wit no category
				$items = $this->user->getArticlesWithNoCategory();
				break;
				case 'stared': //Only favorite items
				$items = $this->user->getFavoriteArticles();
				break;
				case 'all': //All items
				$items = $this->user->getAllArticles();
				break;
				default: // load all feeds from a folder
				$items = $this->user->getArticlesFromCategory($id);
				break;
			}

		}


		return View::make('front.articles.index', compact('items', 'id'));

	}

	public function toggleRead() {
		$id = Input::get('id');
		$article = Article::findOrFail($id);
		$article->unread = Input::get('unread');
		$article->save();

		return $this->user->renderMenu();
	}

	public function toggleFavorite() {
		$id = Input::get('id');
		$article = Article::findOrFail($id);
		$article->favorite = !$article->favorite;
		$article->save();

		return $this->user->renderMenu();
	}

	public function setRead() {
		$id = Input::get('id');
		$article = Article::findOrFail($id);
		if ($article->unread === NULL) {
			$article->unread = FALSE;
		}
		$article->save();

		return $this->user->renderMenu();
	}


}