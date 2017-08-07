<?php
/**
 * EmployeeStore persistence class
 *
 * @author Sagar Sudhakar
 */
class EmployeeStore {
	
	// database connection info
	function connect() {
		$servername = "blitz.cs.niu.edu";
		$username = "demo";
		$password = "demo";
		$dbname = "Payroll";
		
		// Create persistent connection connection
		$conn = new mysqli ( 'p:' . $servername, $username, $password, $dbname );
		
		// Check connection
		if ($conn->connect_error) {
			die ( "Connection failed: " . $conn->connect_error );
		}
		trace ( "EmployeeStore: connected successfully to: " . $conn->host_info );
		
		/* change character set to utf8 */
		$conn->set_charset ( "utf8" );
		return $conn;
	}
	
	// access functions
	public function findEmployee($name) {
		$conn = $this->connect ();
		
		// Collects data from "employees" table
		$sql = "SELECT * FROM Employees WHERE name LIKE '%" . $name . "%';";
		trace ( $sql );
		$result = $conn->query ( $sql );
		
		$empList = array ();
		
		if ($result->num_rows > 0) {
			while ( $row = $result->fetch_assoc () ) {
				$empList [$row ['id']] = new Employee ( $row );
			}
		} else {
			trace ( "0 employee records found" );
		}
		return $empList;
	}
	public function getEmployee($id) {
		$conn = $this->connect ();
		// look up employee in "employees" table
		$sql = "SELECT * FROM Employees WHERE id = " . $id . ";";
		trace ( $sql );
		$result = $conn->query ( $sql );
		$row = $result->fetch_assoc ();
		return new Employee ( $row );
	}
	public function updateEmployee($emp) {
		$conn = $this->connect ();
		// id -1 indicates to create new employee in DB
		if ($emp->id == - 1) {
			// insert new employee
			$sql = "INSERT INTO Employees (name, address, salary, project, routingnumber, accountnumber) VALUES (";
			$sql .= "'" . $emp->name . "', ";
			$sql .= "'" . $emp->address . "', ";
			$sql .= "'" . $emp->salary . "', ";
			$sql .= "'" . $emp->project . "', ";
			$sql .= "'" . $emp->routingnumber . "', ";
			$sql .= "'" . $emp->accountnumber . "');";
		} else {
			// update employee in "employees" table
			$sql = "UPDATE Employees SET name = '" . $emp->name . "', ";
			$sql .= "address = '" . $emp->address . "', ";
			$sql .= "salary = '" . $emp->salary . "', ";
			$sql .= "project = '" . $emp->project . "', ";
			$sql .= "routingnumber = '" . $emp->routingnumber . "', ";
			$sql .= "accountnumber = '" . $emp->accountnumber . "' WHERE id = " . $emp->id . ";";
		}
		trace ( $sql );
		if ($conn->query ( $sql ) === TRUE) {
			return "Employee record updated successfully";
		} else {
			trace ( "Error updating record: " . $conn->error );
		}
	}
	public function deleteEmployee($id) {
		$conn = $this->connect ();
		// delete employee
		$sql = "DELETE FROM Employees WHERE id = " . $id . ";";
		trace ( $sql );
		if ($conn->query ( $sql ) === TRUE) {
			return "Employee record deleted successfully";
		} else {
			trace ( "Error updating record: " . $conn->error );
		}
	}
}
class Employee {
	var $id;
	var $name;
	var $salary;
	var $project;
	var $address;
	var $routingnumber;
	var $accountnumber;
	// create employee from array
	function __construct($row) {
		$this->id = $row ['id'];
		$this->name = $row ['name'];
		$this->salary = $row ['salary'];
		$this->project = $row ['project'];
		$this->address = $row ['address'];
		$this->routingnumber = $row ['routingnumber'];
		$this->accountnumber = $row ['accountnumber'];
	}
}
