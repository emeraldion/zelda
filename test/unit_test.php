<?php
	
	/**
	 *	@class UnitTest
	 *	@short Base class for Unit Testing.
	 *	@details Unit testing allows you to run custom tests focused on validating the functionality
	 *	of model objects. It is recommended that you create a test case for every method of the object.
	 */
	class UnitTest
	{
		/**
		 *	@fn set_up
		 *	@short Sets up fixtures required by test cases.
		 *	@details This method is called before every test case in order
		 *	to setup custom fixtures. Subclassers may override it to perform
		 *	all operations required before running test cases.
		 */
		protected function set_up()
		{
		}
		
		/**
		 *	@fn tear_down
		 *	@short Tears down fixtures used by test cases.
		 *	@details This method is called after every test case in order
		 *	to remove custom fixtures. Subclassers may override it to perform
		 *	all operations required after running test cases.
		 */
		protected function tear_down()
		{
		}
		
		/**
		 *	@fn report
		 *	@short Returns a detailed report of the test case previously run.
		 */
		protected function report()
		{
			global $assertions_total;
			global $assertions_failed;
			global $assertions_errors;
			
			if ($assertions_failed > 0)
			{
				$str = "Test failed. ";
			}
			else
			{
				$str = "Test passed. ";
			}
			$str .= "{$assertions_total} total assertions, {$assertions_failed} failed, {$assertions_errors} errors.\n";
			return $str;
		}
		
		/**
		 *	@fn run
		 *	@short Runs all the test cases.
		 *	@details This method automatically invokes all methods that start with <tt>test*</tt>.
		 *	Before and after each test case, the <tt>set_up</tt> and <tt>tear_down</tt> methods are
		 *	invoked, respectively.
		 */
		public function run()
		{
			global $assertions_total;
			global $assertions_failed;
			
			$class_methods = get_class_methods(get_class($this));
			foreach ($class_methods as $method_name)
			{
				if (strpos($method_name, 'test') === 0)
				{
					echo "$method_name\n";
					$this->set_up();
					$this->$method_name();
					$this->tear_down();
				}
			}
			print $this->report();
			
			exit($assertions_failed);
		}
	}

?>