<?php
/**
 * Extension to provide a search interface when applied to ContentController
 * 
 * @package sapphire
 * @subpackage search
 */
class ContentControllerSearchExtension extends Extension { 
	static $allowed_actions = array(
		'SearchForm',
		'results',
	);
	
	/**
	 * Site search form
	 */
	function SearchForm() {
		$searchText = isset($_REQUEST['Search']) ? $_REQUEST['Search'] : 'Search';
		$fields = new FieldSet(
			new TextField('Search', '', $searchText)
		);
		$actions = new FieldSet(
			new FormAction('results', 'Search')
		);
		return new SearchForm($this->owner, 'SearchForm', $fields, $actions);
	}

	/**
	 * Process and render search results.
	 * 
	 * @param array $data The raw request data submitted by user
	 * @param SearchForm $form The form instance that was submitted
	 * @param SS_HTTPRequest $request Request generated for this action
	 */
	function results($data, $form, $request) {
		$data = array(
			'Results' => $form->getResults(),
			'Query' => $form->getSearchQuery(),
			'Title' => 'Search Results'
		);
		return $this->owner->customise($data)->renderWith(array('Page_results', 'Page'));
	}
}