<?php
	require_once(dirname(__FILE__) . "/../include/tag_support.inc.php");

	/**
	 *	@class Gate
	 *	@short Helper class to represent a gate.
	 *	@details A gate is an abstraction for the association of:
	 *	@li A controller object;
	 *	@li an action;
	 *	@li a set of parameters of the request.
	 */
	class Gate
	{
		/**
		 *	@attr controller
		 *	@details The controller of the gate.
		 */
		public $controller;
		
		/**
		 *	@attr action
		 *	@details The action of the gate.
		 */
		public $action;
		
		/**
		 *	@attr params
		 *	@details Parameters for the gate.
		 */
		public $params;
		
		/**
		 *	@fn by_URI
		 *	@details Creates a Gate object for the given URI.
		 *	@param the_URI An URI used to create the gate.
		 *	@param params An optional array of parameters if already available
		 */
		public static function by_URI($the_URI, $params = NULL)
		{
			$gate = new self();
			
			if (isset($params))
			{
				eval("\$prm = $params;");
				$gate->params = $prm;
			}
			else
			{
				$parts = explode('?', $the_URI);
				$qs = @$parts[1];
			
				$qs_parts = explode('&', $qs);
				foreach ($qs_parts as $qs_part)
				{
					$qs_part_parts = explode('=', $qs_part);
					$gate->params[urldecode($qs_part_parts[0])] = 
						urldecode(@$qs_part_parts[1]);
				}
			}
						
			$gate->controller = ucwords($gate->params['controller']);
			$gate->action = isset($gate->params['action']) ?
				$gate->params['action'] : 'index';
			
			unset($gate->params['controller']);
			unset($gate->params['action']);
			
			return $gate;
		}
		
		/**
		 *	@fn __toString
		 *	@details Returns a string representation of the gate object.
		 */
		public function __toString()
		{
			$params = $this->params;
			array_walk($params, create_function('&$val, $key',
				'$val = span("$key", array(\'class\' => \'code-array-key\')) . ' .
				'span(\' => \', array(\'class\' => \'code-delimiter\')) . ' .
				'span("\'$val\'", array(\'class\' => \'code-literal\'));'));
			$params = empty($params) ? '' : implode(span(', ', array('class' => 'code-delimiter')), $params);
			return span("{$this->controller}Controller", array('class' => 'code-class')) .
				span('::', array('class' => 'code-operator')) .
				span($this->action, array('class' => 'code-method')) .
				span('(', array('class' => 'code-delimiter')) .
				span($params, array('class' => 'code-method-params')) .
				span(')', array('class' => 'code-delimiter'));
		}
	}

?>