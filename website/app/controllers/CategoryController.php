<?php

class CategoryController extends AuthorizedController {

	private $category;

	public function __construct(Category $category) {
		$this->category = $category;
		parent::__construct();
	}
	/**
	 * Update the specified resource in storage.
	 * PUT /category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function updateFeedCategory() {
		
		$feed = Feed::findOrFail(Input::get('feed_id'));
		$feed->category_id = Input::get('category_id') == 0 ? null : Input::get('category_id');
		$feed->save();

		return $this->user->renderMenu();
	}

	public function edit($id) {
		$category = $this->category->findOrFail($id);

		return View::make('front.category.edit', compact('category'));
	}

	public function update($id) {
		$validator = Validator::make(Input::all(), Category::$rules);
    if ($validator->fails()) {
      return Redirect::back()->withInput()
      											 ->withErrors($validator);
    }
		$this->category = $this->category->findOrFail($id);
		$this->category->update(['name' => Input::get('name')]);

    return Redirect::route('user.index')->with('success', Lang::get('category.success'));
	}

	public function store() {
		$validator = Validator::make(Input::all(), Category::$rules);
    if ($validator->fails()) {
      return Redirect::route('user.index')->withInput()
      											 ->withErrors($validator);
    }
		$this->user
				 ->categories()
				 ->create(['name' => Input::get('name')]);

    return Redirect::back()->with('success', Lang::get('user.success'));
	}

	public function destroy($id) {
		$this->user->feeds()->where('category_id', $id)->update(['category_id' => NULL]);
		Category::destroy($id);

		return Redirect::back()->with('succes', Lang::get('user.succes'));
	}


}