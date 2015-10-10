<?php
	require_once(dirname(__FILE__) . "/unit_test.php");

	// Active assert and make it quiet
	assert_options(ASSERT_ACTIVE, 1);
	assert_options(ASSERT_WARNING, 0);
	assert_options(ASSERT_QUIET_EVAL, 1);
	
	$assertions_total = 0;
	$assertions_failed = 0;
	$assertions_errors = 0;
	
	function assertion_increase($success)
	{
		global $assertions_total;
		global $assertions_failed;
		$assertions_total++;
		if ($success)
		{
			echo "*\n";
		}
		else
		{
			$assertions_failed++;
		}
	}
	
	function ERAssertOfClass($expr, $class, $description)
	{
		$expression = get_class($expr);
		assert_options(ASSERT_CALLBACK, create_function('$file, $line, $code',
			"echo \"{$description}; expecting ($class) but found ($expression)\n" .
			//"File '\$file', Line '\$line', Code '\$code'\n" .
			'";'));
		$success = assert($expr instanceof $class);
		assertion_increase($success);
	}

	function ERAssertTrue($expr, $description)
	{
		$expression = (bool)eval("return $expr;");
		assert_options(ASSERT_CALLBACK, create_function('$file, $line, $code',
			"echo \"{$description}; expecting TRUE but found ($expression)\n" .
			//"File '\$file', Line '\$line', Code '\$code'\n" .
			'";'));
		$success = assert("$expr");
		assertion_increase($success);
	}
	
	function ERAssertFalse($expr, $description)
	{
		$expression = (bool)eval("return $expr;");
		assert_options(ASSERT_CALLBACK, create_function('$file, $line, $code',
			"echo \"{$description}; expecting FALSE but found ($expression)\n" .
			//"File '\$file', Line '\$line', Code '\$code'\n" .
			'";'));
		$success = assert("!$expr");
		assertion_increase($success);
	}
	
	function ERAssertEqual($expr, $val, $description)
	{
		$s_val = addslashes($val);
		$expression = eval("return $expr;");
		assert_options(ASSERT_CALLBACK, create_function('$file, $line, $code',
			"echo \"{$description}; expecting ($s_val) but found ($expression)\n" .
			//"File '\$file', Line '\$line', Code '\$code'\n" .
			'";'));
		$success = assert("(($expr) == ($val))");
		assertion_increase($success);
	}
	
	function ERAssertEqualStrict($expr, $val, $description)
	{
		$expression = eval("return $expr;");
		assert_options(ASSERT_CALLBACK, create_function('$file, $line, $code',
			"echo \"{$description}; expecting ($val) but found ($expression)\n" .
			//"File '\$file', Line '\$line', Code '\$code'\n" .
			'";'));
		$success = assert("(($expr) === ($val))");
		assertion_increase($success);
	}
	
	function ERAssertInRange($expr, $min, $max, $description)
	{
		$expression = eval("return $expr;");
		assert_options(ASSERT_CALLBACK, create_function('$file, $line, $code',
			"echo \"{$description}; expected in range ($min),($max) but found ($expression)\n" .
			//"File '\$file', Line '\$line', Code '\$code'\n" .
			'";'));
		$success = assert("(($expr) >= ($min)) && (($expr) <= ($max))");
		assertion_increase($success);
	}
	
	// Create a handler function
	function my_assert_handler($file, $line, $code)
	{
		echo "<hr>Assertion Failed:
			File '$file'<br />
			Line '$line'<br />
			Code '$code'<br /><hr />";
	}
	
	// Set up the callback
	assert_options(ASSERT_CALLBACK, 'my_assert_handler');
?>