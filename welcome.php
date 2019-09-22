<?php
require_once 'config/init.php';
// Initialize the session
//session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}


include 'include/header.php';
include 'include/nav.php';


?>

<!---------------------------------- pdo -------------------------------->

<?php 


// get group name, this needs to be put in a function
$groupname = $pdo->query("
SELECT groups.name, groups.id
FROM groups
INNER JOIN user 
ON user.groupid = groups.id
WHERE user.id ='{$_SESSION['id']}';
")->fetch();

// insert list item

if (isset($_POST['submit'])) {
  if (empty($_POST['taskname'])) {
    $errors = "You must fill in the task";
  }else{
    try{
      echo '1111';
      // Prepare an insert statement
      $sql = "INSERT INTO usertask (userid, groupid, taskname) VALUES (:userid, :groupid, :taskname)";
      $stmt = $pdo->prepare($sql);
      
      // Bind parameters to statement
      $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
      $stmt->bindParam(':groupid', $groupid, PDO::PARAM_STR);
      $stmt->bindParam(':taskname', $taskname, PDO::PARAM_STR);  
      /* Set the parameters values and execute
      the statement again to insert another row */
      $userid = $_SESSION['id'];
      $groupid = $groupname['id'];
      $taskname = $_POST['taskname'];
      
      $stmt->execute();

      echo "Records inserted successfully.";
    } catch(PDOException $e){
        die("ERROR: Could not prepare/execute query: $sql. " . $e->getMessage());
    }
     
    // Close statement
    unset($stmt);
    
    // does this have to refresh?
    header('location: #yourlist');
  }
}	




// show tasks 

// prepare the statement. the place holders allow PDO to handle substituting
// the values, which also prevents SQL injection
$stmtgettask = $pdo->prepare("SELECT userid, taskname FROM usertask WHERE userid=:userid");

// bind the parameters
$stmtgettask->bindValue(":userid", $useridget = $_SESSION['id']);

// initialise an array for the results 
$results = array();


?>


<!-------------------------opening ----------------------------------------------------->
    
    
<header class="masthead">
        <div class="container">
          <div class="intro-text">
            <div class="intro-lead-in"><h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1></div>
          </div>
        </div>
      </header>
  
      <section class="bg-light" id="avatarline1">
        <div class="container">
          
          <h2>Your group: 
            <?php 
            echo $groupname['name'];
           ?>
          </h2>
          <!--<div class="row">
            <div class="col-lg-12 text-center">
              <h2 class="section-heading text-uppercase">Portfolio</h2>
              <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
            </div>
          </div>-->
              <div class="row text-center">
                  <div class="col">
                   <div class="avatarboxes">
                      <img class="img-fluid" src="images/exampleimage.JPG">
                    group id 1
                   </div>
                  </div>
                  <div class="col">
                  <div class="avatarboxes">
                      <img class="img-fluid" src="images/exampleimage1.JPG">
                   2 of 3
                  </div>
                  </div>
                  <div class="col">
                   <div class="avatarboxes">
                      3 of 3
                   </div>
                  </div>
              </div>
          </div>
      </section>
      <section class="bg-light" id="avatarline2">
        <div class="container">          
              <div class="row text-center">
                  <div class="col">
                   <div class="avatarboxes">
                   <img class="img-fluid" src="images/exampleimage1.JPG">
                   </div>
                  </div>
                  <div class="col">
                  <div class="avatarboxes">
                   2 of 3
                  </div>
                  </div>
                  <div class="col">
                   <div class="avatarboxes">
                   <img class="img-fluid" src="images/exampleimage.JPG">
                   </div>
                  </div>
              </div>
          </div>
      </section>
      <!---------------- to try with the smll boxes--------------------------------------------->
          <!-- Portfolio Grid -->
          <section class="bg-light" id="claimedlist">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 text-center">
              <h2 class="section-heading text-uppercase">Claimed List</h2>
              <h3 class="section-subheading text-muted">This is your claimed list</h3>
            </div>
          </div>
          <div class="col-lg-12 text-center">
              Claimed list goes here
          </div>
        </div>
      </section>
  
  
  
      <!--------------- to put in later ---->
     
      <!-- Portfolio Grid -->
      <section class="bg-light" id="yourlist">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 text-center">
              <h2 class="section-heading text-uppercase">Your List</h2>
              <h3 class="section-subheading text-muted">This is your list</h3>
            </div>
          </div>
          <div class="col-lg-12 text-center">
              Your list goes here
              <div class="row">
                    <div class="col-12">
                      <form method="post" action="welcome.php" class="input_form">
                        <input type="text" maxlength="27" name="taskname" placeholder="New item..." class="task_input" id="userInput" userInput>
                        <button type="submit" name="submit"  id="add_btn" class="add_btn">+</button>
                      </form>
                    </div>
              </div>

             <!-- old js needs reworking into the new form -->
                      <!--  <input id="userInput" type="text" placeholder="New item..." maxlength="27">
                        <button id="enter">+</i></button>
                      -->
        
                <!-- Empty List -->
                <div class="row">
                    <div class="listItems col-12">
                        <ul class="col-12 offset-0 col-sm-8 offset-sm-2">
                          <?php
                            if ($stmtgettask->execute()) {
                              foreach ($stmtgettask->fetch(PDO::FETCH_ASSOC)as $results)
                                {
                                  echo $results["taskname"];
                                }
                            }
                           /* if ($stmtgettask->execute()) {
                              echo 'we made it' ;
                              
                                while ($row = $stmtgettask->fetch(PDO::FETCH_ASSOC)) {
                                    //echo $products['taskname'];
                                    echo $products['taskname'];
                                    var_dump($products["taskname"]=$row);

                                    
                                }
                            }*/

                          ?>
                        </ul>
                    </div>
                </div>
  
             
          </div>
        </div>
      </section>

<!-- original end -->

        <!-- body begin -->
<!--<body>
	<div class="container">
		<div class="row">
			<div class="intro col-12">
				<h1>To-Do</h1>
				<div>
					<div class="border1"></div>
					<div c
				</div>
			</div>
		</div>

		<div class="row">
			<div class="helpText col-12">
				<p id="first">Enter text into the input field to add items to your list.</p>
				<p id="second">Click the item to mark it as complete.</p>
				<p id="third">Click the "X" to remove the item from your list.</p>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<input id="userInput" type="text" placeholder="New item..." maxlength="27">
				<button id="enter">+</i></button>
			</div>
		</div>

		<!-- Empty List 
		<div class="row">
			<div class="listItems col-12">
				<ul class="col-12 offset-0 col-sm-8 offset-sm-2">
				</ul>
			</div>
		</div>

	</div>
	
</body> -->

<?php
 include 'include/footer.php';
 ?>