<?php

class FeedController extends AuthorizedController {

	private $simplepie;
	private $feed;

	public function __construct(Feed $feed) {
		$this->simplepie = new SimplePie();
		$this->feed = $feed;
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 * GET /feed.php
	 *
	 * @return Response
	 */
	public function index() {

		$feeds = $this->user->feeds()->with('category')->get();
		$categories = ['none'] + $this->user->categories->lists('name', 'id');

		return View::make('front.feeds.index', compact('feeds', 'categories'));
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /feed.php
	 *
	 * @return Response
	 */
	public function store() {

		$validator = Validator::make(Input::all(), $this->feed->getRules());
    if ($validator->fails()) {
      return Redirect::back()->withInput()
      											 ->withErrors($validator);
    }

    if (! $this->initPie(Input::get('url'))) {
    	//error
    	return Redirect::back()->withInput()
    												 ->with('error', $this->simplepie->error());
    }
    //save feed
    $this->feed->name = $this->simplepie->get_title();
    $this->feed->description = $this->simplepie->get_description();
    $this->feed->website = $this->simplepie->get_permalink();
    $this->feed->url = $this->simplepie->subscribe_url();
    $this->feed->lastUpdate = Carbon\Carbon::now();
    $this->feed->error = false;
    if (Input::get('category') != 0) {
    	$this->feed->category_id = Input::get('category');
    }
    $this->user->feeds()->save($this->feed);

    //Grab the first items
    $this->getArticles();

    return Redirect::back()->with('success', Lang::get('feed.success'));
	}


	/**
	 * Update the specified resource in storage.
	 * PUT /feed.php/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id = null) {
		if ($id === NULL) {
			$feeds = $this->user->feeds()->get();
			foreach ($feeds as $feed) {
				$this->feed = $feed;
				$this->getLastArticles();
				$this->flushFeedCache();
			}
		}
		else {
			$this->feed = $this->user->feeds()->findOrFail($id);
			$this->getLastArticles();
			$this->flushFeedCache();
		}
	}

	private function getLastArticles() {
		$this->initPie($this->feed->url);
		$items = array_reverse($this->simplepie->get_items(0, $this->user->articleCacheMax));
		$newArticles = 0;
		foreach ($items as $item) {
			$exist = $this->feed->articles()
					 ->where('guid', $item->get_id())
					 ->count();
			if ($exist) {
				continue;
			}
			$this->saveArticle($item);
			$newArticles++;
		}
		$this->feed->lastUpdate = Carbon\Carbon::now();
		$this->feed->save();
		$this->user->aricleDownloaded += $newArticles;
		$this->user->save();

	}

	private function flushFeedCache() {
		$currentCount = $this->feed->join('articles', 'articles.feed_id', '=', 'feeds.id')
																->where('favorite', FALSE)
																->whereNull('unread')
																->OrWhere('unread', TRUE)
																->orderBy('articles.id')
																->count();

		$diff = $currentCount - $this->user->articleCacheMax;		
		if ($diff > 0 ) {
				$bindParam = ['diff' => $diff, 'id' => $this->feed->id];
				$res = DB::select(DB::raw('DELETE FROM articles WHERE favorite = 0  AND (unread IS NULL OR unread = 1) AND feed_id = :id ORDER BY id, pubDate LIMIT :diff'), $bindParam);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /feed.php/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id) {
		Feed::destroy($id);
		return Redirect::back()->with('success', Lang::get('feed.deleted'));
	}

	private function initPie($url) {
		$this->simplepie->enable_cache(false);
		$this->simplepie->set_feed_url($url);
		$this->simplepie->strip_htmltags(Config::get('simplereader.striped_tags'));
		$this->simplepie->handle_content_type();
		$this->simplepie->force_feed();

		return $this->simplepie->init();
	}

	private function getArticles() {
		$items = array_reverse($this->simplepie->get_items(0, $this->user->articleCacheMax));
		foreach ($items as $item) {
			$this->saveArticle($item);
		}

	}

	private function saveArticle($item) {
			$article = new Article();
			$article->guid = $item->get_id();
			$article->title = $item->get_title();
			$article->creator = ($item->get_author() === NULL ?: $item->get_author()->name);
			$article->link = $item->get_link();
			$article->content = $item->get_content();
			$article->pubDate = $item->get_gmdate('Y-m-d H:i:s');
			$this->feed->articles()->save($article);
	}

	public function setAllArticleRead($id) {
		if (is_numeric($id)) {
			Article::where('feed_id', $id)->update(['unread' => FALSE]);
		}
		return $this->user->renderMenu();
	}

}