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


}