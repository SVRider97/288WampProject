<?PHP
	require_once('./configure.php');

	$ID_student = $_POST['ID_student'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
        $phone = $_POST['phone'];
	$email = $_POST['email'];
        $status = $_POST['status'];
	$start_dte = $_POST['start_dte'];
        $end_dte = $_POST['end_dte'];
 

	$option = $_POST["option"];
    if ($option == "Search Student"){
	$select_statement_valid = 1;
	/*search for the student*/
	echo "Searching for <b>Student ID:</b> $ID_student <b>First Name:</b> $fname <b>Last Name:</b> $lname <b>Phone Number:</b> $phone 
	<b>Email:</b> $email <b>Status:</b> $status <b>Start Date:</b> $start_dte <b>End Date: </b> $end_dte <br />";
	if($ID_student == NULL AND $fname == NULL AND $lname == NULL){
		echo "Must include student information to search<br />";
		echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Student'/></form>";
		echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		$select_statement_valid = 0;
	}
	elseif($ID_student != NULL){
		$SELECT = "SELECT * FROM t_students WHERE t_students.ID_student=$ID_student";
	}
	elseif($fname != NULL AND $lname == NULL){
		$SELECT = "SELECT * FROM t_students WHERE t_students.fname LIKE '$fname'";
	}
	elseif($lname == NULL AND $lname != NULL){
		echo "Last Name=  '$lname'"; 
		$SELECT = "SELECT * FROM t_students WHERE t_students.lname LIKE '%$lname%'";
	}
	else{
		echo "An error constructing SELECT statement.";
		$select_statement_valid = 0;
	}
	if($select_statement_valid == 1){
		$resultSet = $conn->query($SELECT);
		if($resultSet->num_rows > 0){
			echo "Search Results Found Records Listed. <br>Click student to pre-fill information form.<br />";
			while($rows = $resultSet->fetch_assoc()){
				$ID_student = $rows['ID_student'];
				$fname = $rows['fname'];
				$lname = $rows['lname'];
                                $phone = $rows['phone'];
				$email = $rows['email'];
				$status = $rows['status'];
				$start_dte = $rows['start_dte'];
				$end_dte = $rows['end_dte'];

				$post_string = $ID_student; 
				$post_string = $post_string . "&" . "fname=" . $fname; 
				$post_string = $post_string . "&" . "lname=" . $lname;
                                $post_string = $post_string . "&" . "phone=" . $phone;
				$post_string = $post_string . "&" . "email=" . $email;
				$post_string = $post_string . "&" . "status=" . $status;
				$post_string = $post_string . "&" . "start_dte=" . $start_dte;
				$post_string = $post_string . "&" . "end_dte=" . $end_dte;

				/*value='$ID_student +'*/
				echo "<br/br/><form action='./students.html' method='GET'><button type='submit' name='ID_student' id='ID_student' value='$post_string'>Student ID: $ID_student, First Name: $fname, Last Name: $lname,
				Phone Number : $phone, Email: $email, Status: $status, Start Date: $start_dte, End Date: $end_dte </button></form>";	
			}
			echo "<br/><br/><form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
 		}
		else{
			echo "Error in searching for student record(s).";
			echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
		}
	}
		
     mysqli_close($conn);
    }
    else if ($option == "Add Student"){
        /* For inserting a student record */
	if($fname != "" && $lname != ""){
		$INSERT = "INSERT INTO t_students (fname, lname, phone, email, status, start_dte, end_dte) VALUES ('$fname', '$lname','$phone', '$email','$status','$start_dte', '$end_dte')";
		$stmt = $conn->prepare($INSERT);
                	$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "New record inserted successfully";
			echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
                		echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Insert record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}

		mysqli_close($conn);
	}
	else {
		echo "All fields (except student ID) are required";
		echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
		die();
	}
     }
     else if ($option == "Edit Student"){
               /*Update Editing a student*/
	if($ID_student != ""){
$UPDATE = "UPDATE t_students SET fname='$fname', lname='$lname', phone='$phone', email='$email',status='$status',start_dte='$start_dte', end_dte='$end_dte'
	 WHERE ID_student='$ID_student'";

		$stmt = $conn->prepare($UPDATE);
		$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "Updated student successfully.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Update record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}

		mysqli_close($conn);
	}
	else {
		echo "Error in updating student must include student ID to edit record.";
		echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
		die();
	}
     }
     else if ($option == "Delete Student"){
	/*Deleting a student*/
	if($ID_student != ""){

		$DELETE = "DELETE FROM t_students WHERE ID_student='$ID_student'";
		$stmt = $conn->prepare($DELETE);
		$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "Deleted student successfully.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Delete record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		mysqli_close($conn);
	}
	else {
		echo "Error in deleting student must include student ID to delete record.";
		echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
		die();
	}

     }
     else{
	echo "Error: Option not found.";
	echo "<form action='./students.html' method='get'><input type='submit' value='Go Back to Manage Students'/></form>";
    }
?>