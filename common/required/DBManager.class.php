<?php
/**
 * Ensure that only one DB connection exists per PHP session.
 */

class DBManager
{
	/**
	* Connection for the session.
	*/
	private static $conn;
	
	/**
	*=---------------------------------------------------------=
	* getConnection
	*=---------------------------------------------------------=
	* Static method to create a connection to the database server.
	*
	* Returns:
	*    mysqli object for the connection.
	*	Throws error on failure.
	*/
	public static function getConnection()
	{
		if (DBManager::$conn === NULL)
		{
			/**
			* Create a new mysqli object, throw error on failure.
			*/
			$mysqli = @new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
			if (mysqli_connect_errno() !== 0)
				throw new Exception(mysqli_connect_error());

			/**
			* Make sure the connection is set up for utf8
			* communications.
			*/
			@$mysqli->query('SET NAMES \'utf8\'');
			DBManager::$conn = $mysqli;
		}
		return DBManager::$conn;
	}
	
	/**
	*=---------------------------------------------------------=
	* getConnection
	*=---------------------------------------------------------=
	* Static method to close a connection to the database server.
	*
	*/
	public static function closeConnection()
	{
		if (DBManager::$conn !== NULL)
		{
			DBManager::$conn->close();
		}
	}
}
?>