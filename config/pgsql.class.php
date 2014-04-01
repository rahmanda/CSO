<?php
class pgsql {
	private $linkid; // PostgreSQL link identifier
	private $host; // PostgreSQL server host
	private $user; // PostgreSQL user
	private $passwd; // PostgreSQL password
	private $db; // PostgreSQL database
	private $result; // Query result
	private $querycount; // Total queries executed
	/* Class constructor. Initializes the $host, $user, $passwd
	and $db fields. */
	function __construct($host, $db, $user, $passwd) {
		$this->host = $host;
		$this->user = $user;
		$this->passwd = $passwd;
		$this->db = $db;
	}
	/* Connects to the PostgreSQL Database */
	function connect(){
		try{
			$this->linkid = @pg_connect("host=$this->host dbname=$this->db
			user=$this->user password=$this->passwd");
		if (! $this->linkid)
		throw new Exception("Could not connect to PostgreSQL server.");
		}
		catch (Exception $e) {
			die($e->getMessage());
		}
	}
	/* Execute database query. */
	function query($query){
		try{
			$this->result = @pg_query($this->linkid,$query);
			if(! $this->result)
			throw new Exception("The database query failed.");
	}
		catch (Exception $e){
			echo $e->getMessage();
		}
		$this->querycount++;
		return $this->result;
	}
	/* Determine total rows affected by query. */
	function affectedRows(){
		$count = @pg_affected_rows($this->linkid);
		return $count;
	}
	/* Determine total rows returned by query */
	function numRows(){
		$count = @pg_num_rows($this->result);
		return $count;
	}
	/* Return the number of fields in a result set */
	function numberFields() {
		$count = @pg_num_fields($this->result);
		return $count;
	}
	/* Return a field name given an integer offset. */
	function fieldName($offset){
		$field = @pg_field_name($this->result, $offset);
		return $field;
	}
	/* Return query result row as an object. */
	function fetchObject(){
		$row = @pg_fetch_object($this->result);
		return $row;
	}
	/* Return query result row as an indexed array. */
	function fetchRow(){
		$row = @pg_fetch_row($this->result);
		return $row;
	}
	/* Return query result row as an associated array. */
	function fetchArray(){
		$row = @pg_fetch_array($this->result);
		return $row;
	}
	/* Return total number of queries executed during
	lifetime of this object. Not required, but
	interesting nonetheless. */
	function numQueries(){
		return $this->querycount;
	}
	function getResultAsTable($actions) {
		if ($this->numrows() > 0) {
			// Start the table
			$resultHTML = "<table id='table' border='1'>\n<thead>\n<tr>\n";
			// Output the table headers
			$fieldCount = $this->numberFields();
			for ($i=1; $i < $fieldCount; $i++){
				$rowName = $this->fieldName($i);
				$resultHTML .= "<th>$rowName</th>";
			} // end for
			// Close the row
			$resultHTML .= "</tr>\n</thead>\n<tbody>\n";
			// Output the table data
			while ($row = $this->fetchRow()){
				$resultHTML .= "\n<tr>\n";
				for ($i = 0; $i < $fieldCount; $i++)
					$resultHTML .= "<td>".htmlentities($row[$i])."</td>";
				// Replace VALUE with the correct primary key
				$action = str_replace("VALUE", $row[0], $actions);
				// Add the action cell to the end of the row
				$resultHTML .= "<td nowrap>&nbsp;$action</td>\n</tr>\n";
			}
		// Close the table
		$resultHTML .= "</tbody>\n</table>";
		} else {
			$resultHTML = "<p>No Results Found</p>";
		}
		return $resultHTML;
	}
}

