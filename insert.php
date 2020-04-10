<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';
include ('function.php');

if (isset($_POST["operation"])) //Adding todolist to Database including $_SESSION["id"] of logged in user
{
    if ($_POST["operation"] == "Add")
    {
        $statement = $db->prepare("INSERT INTO task (taskname,taskdescription,taskpriority,taskstatus,user_id) VALUES (:taskname, :taskdescription,:taskpriority,:taskstatus,:user_id)");
        $result = $statement->execute(array(
            ':taskname' => $_POST["taskname"],
            ':taskdescription' => $_POST["taskdescription"],
            ':taskpriority' => $_POST["taskpriority"],
            ':taskstatus' => $_POST["taskstatus"],
            ':user_id' => $_SESSION["id"],

        ));
    }
    if ($_POST["operation"] == "Edit") //editing todo list
    {
        $statement = $db->prepare("UPDATE task SET taskname = :taskname, taskdescription = :taskdescription,taskpriority= :taskpriority, taskstatus= :taskstatus WHERE id = :id");
        $result = $statement->execute(array(
            ':taskname' => $_POST["taskname"],
            ':taskdescription' => $_POST["taskdescription"],
            ':taskpriority' => $_POST["taskpriority"],
            ':taskstatus' => $_POST["taskstatus"],
            ':id' => $_POST["task_id"],
        ));
    }

}
?>
