<?php
include_once 'resource/Database.php';
include_once 'function.php';
if (isset($_POST["task_id"])) //Deleting the row of task after delete button is pressed
{
    $statement = $db->prepare("DELETE FROM task WHERE id = :id ");
    $result = $statement->execute(

    array(
        ':id' => $_POST["task_id"]
    )
);
}

?>
