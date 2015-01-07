<?php

class ArticleController extends AuthorizedController {

	/**
	 * Display a listing of the resource.
	 * GET /article
	 *
	 * @return Response
	 */
	public function index() {
		$items = $this->user->getAllArticles();
		$id = 'all';
		return View::make('front.articles.index', compact('items', 'id'));
	}

	/**
	 * show feed's articles
	 * @param  string $id     id
	 * @param  mixed $filter filter
	 * @return View
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
		$b = $article->unread;
		if ($article->unread == NULL || $article->unread == true) {
			$article->unread = FALSE;
			$article->save();
			$this->user->articleReaded++;
			$this->user->save();
		}

		return $this->user->renderMenu();
	}


}