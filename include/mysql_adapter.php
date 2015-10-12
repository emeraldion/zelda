<?php

	require_once(dirname(__FILE__) . "/../config/db.conf.php");
	require_once(dirname(__FILE__) . "/db_adapter.php");

	/**
	 *	@class MysqlAdapter
	 *	@short MySQL Database adapter.
	 */
	class MysqlAdapter implements DbAdapter
	{
		/**
		 *	@attr NAME
		 *	@short Name of this adapter
		 */
		const NAME = "mysql";

		/**
		 *	@attr queries_count
		 *	@short Counter for queries executed.
		 */
		static $queries_count = 0;

		/**
		 *	@attr link
		 *	@short Connection link to the database.
		 */
		public $link;

		/**
		 *	@attr query
		 *	@short Query for the database.
		 */
		public $query;

		/**
		 *	@attr result
		 *	@short The result of the last query.
		 */
		public $result;

		/**
		 *	@fn connect
		 *	@short Connects to the database.
		 */
		public function connect()
		{
			if (!is_resource($this->link) || get_resource_type($this->link) != "mysql link")
			{
				$this->link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
				mysql_select_db(DB_NAME) or die("Cannot connect: " . mysql_error());
			}
		}

		/**
		 *	@fn select_db($database_name)
		 *	@short Selects the desired database.
		 *	@param database_name The name of the database.
		 */
		public function select_db($database_name)
		{
			$this->connect();
			return mysql_select_db($database_name, $this->link);
		}

		/**
		 *	@fn close
		 *	@short Closes the connection to the database.
		 */
		public function close()
		{
			mysql_close($this->link);
		}

		/**
		 *	@fn prepare($query)
		 *	@short Prepares a query for execution
		 *	@param query The query to execute.
		 */
		public function prepare($query)
		{
			$this->connect();

			$args = func_get_args();
			$args_len = func_num_args();
			if ($args_len > 1)
			{
				for ($i = 1; $i < $args_len; $i++)
				{
					$query = str_replace('{' . $i . '}', mysql_real_escape_string($args[$i], $this->link), $query);
				}
			}
			$this->query = $query;

			if (DB_DEBUG)
				$this->print_query();
		}

		/**
		 *	@fn exec
		 *	@short Executes a query.
		 */
		public function exec()
		{
			$this->connect();
			$this->result = mysql_query($this->query, $this->link) or die("DB unavailable");//die("Error ({$this->query}): " . mysql_error());

			self::$queries_count++;

			return  $this->result;
		}

		/**
		 *	@fn insert_id
		 *	@short Returns the id generated by the last INSERT query.
		 */
		public function insert_id()
		{
			return mysql_insert_id($this->link);
		}

		/**
		 *	@fn escape($value)
		 *	@short Escapes the given value to avoid SQL injections.
		 *	@param value The value to escape.
		 */
		public function escape($value)
		{
			$this->connect();
			return mysql_real_escape_string($value, $this->link);
		}


		/**
		 *	@fn result($pos, $colname)
		 *	@short Returns a single result of the last SELECT query.
		 *	@param row The row of the resultset.
		 *	@param colname The name (or the alias, if applicable) of the desired row.
		 */
		public function result($pos = 0, $colname = NULL)
		{
			return mysql_result($this->result, $pos, $colname);
		}

		/**
		 *	@fn num_rows
		 *	@short Returns the number of rows returned by a previous SELECT query.
		 */
		public function num_rows()
		{
			return mysql_num_rows($this->result);
		}

		/**
		 *	@fn affected_rows
		 *	@short Returns the number of rows affected by a previous INSERT, UPDATE or DELETE query.
		 */
		public function affected_rows()
		{
			return mysql_affected_rows($this->result);
		}

		/**
		 *	@fn fetch_assoc
		 *	@short Returns the current row of the resultset as an associative array.
		 */
		public function fetch_assoc()
		{
			return mysql_fetch_assoc($this->result);
		}

		/**
		 *	@fn free_result
		 *	@short Releases the result of the last query.
		 */
		public function free_result()
		{
			mysql_free_result($this->result);
		}

		/**
		 *	@fn print_query
		 *	@short Prints the last query for debug.
		 */
		public function print_query()
		{
			echo <<<EOT
			<pre class="db-debug">{$this->query}</pre>
EOT;
		}
	}

	Db::register_adapter(new MysqlAdapter(), MysqlAdapter::NAME);
?>
