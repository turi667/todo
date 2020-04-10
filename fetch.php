<?php
include_once 'resource/session.php';
include_once 'resource/Database.php';
include_once 'function.php';
$query = '';
$output = array();
$query .= "select * from task WHERE user_id='" . $_SESSION['id'] . "'";
if (isset($_POST["search"]["value"]))       // searching todolist by taskname,description , priority and status
{
    $query .= '
 AND (taskname LIKE "%' . $_POST["search"]["value"] . '%"
 OR taskdescription LIKE "%' . $_POST["search"]["value"] . '%" OR taskstatus LIKE "%' . $_POST["search"]["value"] . '%" OR taskpriority LIKE "%' . $_POST["search"]["value"] . '%")
 ';
}
if (isset($_POST["order"]))
{
    $query .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
}
else
{
    $query .= 'ORDER BY id ASC ';
}

if ($_POST["length"] != - 1)
{
    $query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $db->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach ($result as $row)
{
    $sub_array = array();

    $sub_array[] = $row["id"];
    $sub_array[] = $row["taskname"];
    $sub_array[] = $row["taskdescription"];
    $sub_array[] = $row["taskpriority"];
    $sub_array[] = $row["taskstatus"];
    $sub_array[] = '<button type="button" name="update" id="' . $row["id"] . '" class="btn btn-primary btn-sm update">Edit</button>';
    $sub_array[] = '<button type="button" name="delete" id="' . $row["id"] . '" class="btn btn-danger btn-sm delete">Delete</button>';
    $data[] = $sub_array;
}
$output = array(
    "draw" => intval($_POST["draw"]) ,
    "recordsTotal" => $filtered_rows,
    "recordsFiltered" => get_total_all_records() ,
    "data" => $data
);
echo json_encode($output);
?>
