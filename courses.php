<?PHP
	require_once('./configure.php');

	$ID_course = $_POST['ID_course'];
	$course_code = $_POST['course_code'];
	$course_desc = $_POST['course_desc'];

     /*if($course_code == ""){
	$course_code ="none given";}
     if($course_desc == ""){
	$course_desc = "none given";}
     */
	$option = $_POST["option"];
    if ($option == "Search Course"){
	$select_statement_valid = 1;
	/*search for the course*/
	echo "Searching for <b>Course ID:</b> $ID_course <b>Course Code:</b> $course_code <b>Course Description:</b> $course_desc<br />";
	if($ID_course == NULL AND $course_code == NULL AND $course_desc == NULL){
		echo "Must include course information to search<br />";
		echo "<form action='./courses.html' method='get'><input type='submit' value='Go Back to Manage Courses'/></form>";
		echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		$select_statement_valid = 0;
	}
	elseif($ID_course != NULL){
		$SELECT = "SELECT * FROM t_courses WHERE t_courses.ID_course=$ID_course";
	}
	elseif($course_code != NULL AND $course_desc == NULL){
		$SELECT = "SELECT * FROM t_courses WHERE t_courses.course_code LIKE '$course_code'";
	}
	elseif($course_code == NULL AND $course_desc != NULL){
		echo "desc=  '$course_desc'"; 
		$SELECT = "SELECT * FROM t_courses WHERE t_courses.course_desc LIKE '%$course_desc%'";
	}
	elseif($course_code != NULL AND $course_desc != NULL){
		$SELECT = "SELECT * FROM t_courses WHERE t_courses.course_code LIKE '$course_code' AND t_courses.course_desc LIKE '$course_desc'";
	}
	else{
		echo "An error constructing SELECT statement.";
		$select_statement_valid = 0;
	}
	if($select_statement_valid == 1){
		$resultSet = $conn->query($SELECT);
		if($resultSet->num_rows > 0){
			echo "Search Results Found Records Listed. <br>Click course to pre-fill information form.<br />";
			while($rows = $resultSet->fetch_assoc()){
				$ID_course = $rows['ID_course'];
				$course_code = $rows['course_code'];
				$course_desc = $rows['course_desc'];

				$post_string = $ID_course; 
				$post_string = $post_string . "&" . "course_code=" . $course_code; 
				$post_string = $post_string . "&" . "course_desc=" . $course_desc;

				/*value='$ID_course +'*/
				echo "<br/br/><form action='./courses.html' method='GET'><button type='submit' name='ID_course' id='ID_course' value='$post_string'>Course ID: $ID_course, Course Code: $course_code $course_desc</button></form>";	
			}
			echo "<br/><br/><form action='./courses.html' method='get'><input type='submit' value='Go Back to Manage Courses'/></form>";
 		}
		else{
			echo "Error in searching for course record(s).";
			echo "<form action='./courses.html' method='get'><input type='submit' value='Go Back to Manage Courses'/></form>";
		}
	}
		
     mysqli_close($conn);
    }
    else if ($option == "Add Course"){
        /* For inserting a course record */
	if($course_code != "" && $course_desc != ""){
		$INSERT = "INSERT INTO t_courses (course_code, course_desc) VALUES ('$course_code', '$course_desc')";
		$stmt = $conn->prepare($INSERT);
                	$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "New record inserted successfully";
			echo "<form action='./courses.html' method='get'><input type='submit' value='Go Back to Manage Courses'/></form>";
                		echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Insert record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}

		mysqli_close($conn);
	}
	else {
		echo "All fields (except course ID) are required";
		echo "<form action='./courses.html' method='get'><input type='submit' value='Go Back to Manage Courses'/></form>";
		die();
	}
     }
     else if ($option == "Edit Course"){
               /*Update Editing a course*/
	if($ID_course != ""){
$UPDATE = "UPDATE t_courses SET course_code='$course_code', course_desc='$course_desc' WHERE ID_course='$ID_course'";

		$stmt = $conn->prepare($UPDATE);
		$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "Updated course successfully.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Update record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}

		mysqli_close($conn);
	}
	else {
		echo "Error in updating course must include course ID to edit record.";
		echo "<form action='./courses.html' method='get'><input type='submit' value='Go Back to Manage Courses'/></form>";
		die();
	}
     }
     else if ($option == "Delete Course"){
	/*Deleting a course*/
	if($ID_course != ""){

		$DELETE = "DELETE FROM t_courses WHERE ID_course='$ID_course'";
		$stmt = $conn->prepare($DELETE);
		$stmt->execute();
		$rnum = $stmt->affected_rows;
		printf("Number of rows effected: %d and %d.\n", $stmt->affected_rows, $rnum);
		if($rnum == 1){
			echo "Deleted course successfully.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		else{
			echo "Failure to Delete record.";
			echo "<form action='./index.html' method='get'><input type='submit' value='Go Back to Main Menu'/></form>";
		}
		mysqli_close($conn);
	}
	else {
		echo "Error in deleting course must include course ID to delete record.";
		echo "<form action='./courses.html' method='get'><input type='submit' value='Go Back to Manage Courses'/></form>";
		die();
	}

     }
     else{
	echo "Error: Option not found.";
	echo "<form action='./courses.html' method='get'><input type='submit' value='Go Back to Manage Courses'/></form>";
    }
?>