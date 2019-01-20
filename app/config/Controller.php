<?php 
/**
 * Controller Class
 * Load Models and Views
 */

abstract class Controller
{
	protected $user;
	protected $session;

	public function __construct()
	{
		$this->user = $this->createModel('User');
		$this->session = $this->createModel('Session');
	}

	/**
	* Load a model and return an instance of it
	*/
	public function createModel (string $model)
	{
		require_once APPROOT . '\\app\\models\\' . $model . '.php';
		return new $model;
	}

	/**
	* Load a view
	*/
	public function loadView (string $view, array $data = []) : void
	{
		# Check if view file exists
		if (file_exists(APPROOT . '\\app\\views\\' . $view . '.php')) 
		{
			require_once APPROOT . '\\app\\views\\' . $view . '.php';
		} else
		{
			die('Not found');
		}
	}
}