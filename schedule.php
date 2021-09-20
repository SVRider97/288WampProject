<?PHP
	require_once('./configure.php');

	$ID_schedule = $_POST['ID_schedule'];
	$ID_student = $_POST['ID_student'];
	$ID_course = $_POST['ID_course'];
        $sched_yr = $_POST['sched_yr'];
	$sched_sem = $_POST['sched_sem'];
        $grade_letter = $_POST['grade_letter'];
 

	$option = $_POST["option"];
    if ($option == "Search Schedule"){
	$select_statement_valid = 1;
	/*search for the schedule*/
	echo "Searching for <b>Schedule ID:</b> $ID_schedule <b>Student ID:</b> $ID_student <b>Course ID:</b> $ID_course <b>Schedule Year:</b> $sched_yr 
	<b>Schedule Semester:</b> $sched_sem <b>Letter Grade:</b> $grade_letter  <br />";
	if($ID_schedule == NULL AND $ID_student == NULL AND $ID_course == NULL){
		echo "Must include schedule information to search<br />";
		echo "<form action='./schedule.html' method='get'><input type='submit' value='Go Back to Manage Schedule'/></form>";
		echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		$select_statement_valid = 0;
	}
	elseif($ID_schedule != NULL){
		$SELECT = "SELECT * FROM t_schedules WHERE t_schedules.ID_schedule=$ID_schedule";
	}
	elseif($ID_student != NULL AND $ID_course == NULL){
		$SELECT = "SELECT * FROM t_schedules WHERE t_schedules.ID_student LIKE '$ID_student'";
	}
	elseif($ID_course == NULL AND $ID_course != NULL){
		echo "Course ID=  '$ID_course'"; 
		$SELECT = "SELECT * FROM t_schedules WHERE t_schedules.ID_course LIKE '%$ID_course%'";
	}
	else{
		echo "An error constructing SELECT statement.";
		$select_statement_valid = 0;
	}
	if($select_statement_valid == 1){
		$resultSet = $conn->query($SELECT);
		if($resultSet->num_rows > 0){
			echo "Search Results Found Records Listed. <br>Click schedule to pre-fill information form.<br />";
			while($rows = $resultSet->fetch_assoc()){
				$ID_schedule = $rows['ID_schedule'];
				$ID_student = $rows['ID_student'];
				$ID_course = $rows['ID_course'];
                                $sched_yr = $rows['sched_yr'];
				$sched_sem = $rows['sched_sem'];
				$grade_letter = $rows['grade_letter'];
			

				$post_string = $ID_schedule; 
				$post_string = $post_string . "&" . "ID_student=" . $ID_student; 
				$post_string = $post_string . "&" . "ID_course=" . $ID_course;
                                $post_string = $post_string . "&" . "sched_yr=" . $sched_yr;
				$post_string = $post_string . "&" . "sched_sem=" . $sched_sem;
				$post_string = $post_string . "&" . "grade_letter=" . $grade_letter;


			/*value='$ID_schedule +'*/
			echo "<br/br/><form action='./schedule.html' method='GET'><button type='submit' name='ID_schedule' id='ID_schedule' value='$post_string'>Schedule ID: $ID_schedule, Student ID: $ID_student,
 			Course ID: $ID_course, Schedule Semester: $sched_sem, Letter Grade: $grade_letter </button></form>";	
			}
			echo "<br/><br/><form action='./schedule.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
 		}
		else{
			echo "Error in searching for schedule record(s).";
			echo "<form action='./schedule.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
		}
	}
		
     mysqli_close($conn);
    }
    else if ($option == "Add Schedule"){
        /* For inserting a schedule record */
	if($ID_student != "" && $ID_course != ""){
		$INSERT = "INSERT INTO t_schedules (ID_student, ID_course, sched_yr, sched_sem, grade_letter) VALUES ('$ID_student', '$ID_course','$sched_yr', '$sched_sem','$grade_letter')";
		$stmt = $conn->prepare($INSERT);
                	$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "New record inserted successfully";
			echo "<form action='./schedule.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
                		echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Insert record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}

		mysqli_close($conn);
	}
	else {
		echo "All fields (except schedule ID) are required";
		echo "<form action='./schedule.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
		die();
	}
     }
     else if ($option == "Edit Schedule"){
               /*Update Editing a schedule*/
	if($ID_schedule != ""){
$UPDATE = "UPDATE t_schedules SET ID_schedule='$ID_schedule', ID_course='$ID_course', sched_yr='$sched_yr', sched_sem='$sched_sem',grade_letter='$grade_letter'
	 WHERE ID_schedule='$ID_schedule'";

		$stmt = $conn->prepare($UPDATE);
		$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "Updated schedule successfully.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Update record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}

		mysqli_close($conn);
	}
	else {
		echo "Error in updating schedule must include schedule ID to edit record.";
		echo "<form action='./schedule.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
		die();
	}
     }
     else if ($option == "Delete Schedule"){
	/*Deleting a schedule*/
	if($ID_schedule != ""){

		$DELETE = "DELETE FROM t_schedules WHERE ID_schedule='$ID_schedule'";
		$stmt = $conn->prepare($DELETE);
		$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "Deleted schedule successfully.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Delete record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		mysqli_close($conn);
	}
	else {
		echo "Error in deleting schedule must include schedule ID to delete record.";
		echo "<form action='./schedule.html' method='get'><input type='submit' value='Go Back to Manage schedules'/></form>";
		die();
	}

     }
     else{
	echo "Error: Option not found.";
	echo "<form action='./schedule.html' method='get'><input type='submit' value='Go Back to Manage Schedules'/></form>";
    }
?>