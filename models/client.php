<?php
	require_once(dirname(__FILE__) . "/person.php");
	
	/**
	 *	@class Client
	 *	@short Model object for clients.
	 *	@details Objects of class Client represent an individual who has enjoyed Claudio's services.
	 */
	class Client extends Person
	{
		public function relative_url()
		{
			return sprintf('portfolio/clients/%s',
				$this->id);
		}
	}

?>