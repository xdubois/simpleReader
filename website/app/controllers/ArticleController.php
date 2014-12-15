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
			$items = Feed::findOrFail($id)->articles()->get();
		}
		else {
			switch ($id) {
				case 'subscriptions': // subscriptions wit no category
				$items = $this->user
					->join('feeds', 'feeds.user_id', '=', 'users.id')
					->join('articles', 'articles.feed_id', '=', 'feeds.id')
					->select('articles.*')
					->whereNull('feeds.category_id')
					->whereNull('articles.unread')
					->orWhere('articles.unread', FALSE)
					->get(); 
				break;
				case 'stared': //Only favorite items
				$items = $this->user
					->join('feeds', 'feeds.user_id', '=', 'users.id')
					->join('articles', 'articles.feed_id', '=', 'feeds.id')
					->select('articles.*')
					->where('articles.favorite', true)
					->get(); 
				break;
				case 'all': //All items
				$items = $this->user
					->join('feeds', 'feeds.user_id', '=', 'users.id')
					->join('articles', 'articles.feed_id', '=', 'feeds.id')
					->select('articles.*')
					->whereNull('articles.unread')
					->orWhere('articles.unread', FALSE)
					->get(); 
				break;
				default: // load all feeds from a folder
				$items = $this->user
					->join('feeds', 'feeds.user_id', '=', 'users.id')
					->join('categories', 'categories.id', '=', 'feeds.category_id')
					->join('articles', 'articles.feed_id', '=', 'feeds.id')
					->select('articles.*')
					->where('categories.name', $id)
					->whereNull('articles.unread')
					->orWhere('articles.unread', FALSE)
					->get(); 
				break;
			}

		}


		return View::make('front.articles.index', compact('items'));

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


}