<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';
include_once 'function.php';
if (isset($_POST["task_id"])) //When Update button of Task is pressed shows the data of selected row 
{
    $output = array();
    $statement = $db->prepare("SELECT * FROM task WHERE id = '" . $_POST["task_id"] . "' LIMIT 1");
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row)
    {
        $output["id"] = $row["id"];
        $output["taskname"] = $row["taskname"];
        $output["taskdescription"] = $row["taskdescription"];
        $output["taskpriority"] = $row["taskpriority"];
        $output["taskstatus"] = $row["taskstatus"];
    }
    echo json_encode($output);
}
?>
