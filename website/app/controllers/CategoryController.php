<?php

class CategoryController extends AuthorizedController {

	/**
	 * Update the specified resource in storage.
	 * PUT /category/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update() {
		
		$feed = Feed::findOrFail(Input::get('feed_id'));
		$feed->category_id = Input::get('category_id') == 0 ? null : Input::get('category_id');
		$feed->save();

		return $this->user->renderMenu();
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

	public function updateCategoryName() {
		$id = Input::get('id');
		$category = Category::findOrFail($id);

		if (Input::get('name') == '') {
			return Respone::make('error', 201);
		}

		$category->name = Input::get('name');
		$category->save();
	}

	public function destroy($id) {
		$this->user->feeds()->where('category_id', $id)->update(['category_id' => NULL]);
		Category::destroy($id);

		return Redirect::back()->with('succes', Lang::get('user.succes'));
	}


}