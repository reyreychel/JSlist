<?php



function get_group_name($groupname){

}

?>




function get_group_name($groupname){
// get group name, this needs to be put in a function
$groupname = $pdo->query("
SELECT group.name
FROM group
INNER JOIN users 
ON users.groupid = groups.id
WHERE users.id ='{$_SESSION['id']}';
")->fetch();

}


function get_group_name()
$groupname 