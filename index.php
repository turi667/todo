<?php
$page_title = "Todo List";
include_once 'partials/headers.php';
include_once 'function.php'; ?>

    <?php if(!(isset($_SESSION['username']))): ?>

        <div class="container">
            <div class="flag">
                <h1>Welcome  to our App</h1>
                <p class="lead">Todo List
                    <br>
                    <br>
                    <br> Create unlimited tasks .Add descriptions , priority and status of the list .
                    <br>
                    <br>
                    <br>
                    <br>
                    <br> If you have already an account please <a href="login.php">Login</a> or <a href="signup.php">Signup</a> </p>

                <?php else: ?>
                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
                    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
                    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
                    <style type="text/css">
                        .header {
                            text-align: center;
                        }
                        
                        .content {
                            max-width: 100px;
                            margin: auto;
                        }
                        
                        h1 {
                            text-align: center;
                            padding-bottom: 60px;
                        }
                    </style>
                    <h1>My Todo List</h1>

                    <body>

                        <table id="task_table" class="table table-striped">
                            <thead bgcolor="#6cd8dc">
                                <tr class="table-primary">
                                    <th width="5%">ID</th>
                                    <th width="20%">Name</th>
                                    <th width="30%">Description</th>
                                    <th width="10%">Priority</th>
                                    <th width="10%">Done</th>
                                    <th scope="col" width="5%"></th>
                                    <th scope="col" width="5%"></th>
                                </tr>
                            </thead>
                        </table>

                        <div>

                            <div align="left">
                                <button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-success">Add Todo</button>
                            </div>

                        </div>

                        <div id="userModal" class="modal fade">
                            <div class="modal-dialog">
                                <form method="post" id="task_form" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                            <h4 class="modal-title">Add List To Do</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label>Enter Task Name</label>
                                            <input type="text" name="taskname" id="taskname" class="form-control" />
                                            <br>
                                            <br>
                                            <label>Enter Description of Task</label>
                                            <input type="text" name="taskdescription" id="taskdescription" class="form-control" />
                                            <br>
                                            <br>
                                            <br>
                                            <div>
                                                <label for="taskpriority" class="col-sm-40 control-label">Priority</label>
                                                <div class="col-sm-40">
                                                    <select class="form-control" name="taskpriority" id="taskpriority">
                                                        <option value="">Select Priority</option>
                                                        <option value="High">High</option>
                                                        <option value="Medium">Medium</option>
                                                        <option value="Low">Low</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <label for="taskstatus" class="col-sm-40 control-label"> Done Or Not</label>
                                            <div class="col-sm-40">
                                                <select class="form-control" name="taskstatus" id="taskstatus">
                                                    <option value="">Select Status of task</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="modal-footer">
                                                <input type="hidden" name="task_id" id="task_id" />
                                                <input type="hidden" name="operation" id="operation" />
                                                <input type="submit" name="action" id="action" class="btn btn-primary" value="Add" />
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                </form>
                                </div>
                            </div>

                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#add_button').click(function() {
                                        $('#task_form')[0].reset();
                                        $('.modal-title').text("Add TODO");
                                        $('#action').val("Add");
                                        $('#operation').val("Add")
                                    });

                                    var dataTable = $('#task_table').DataTable({
                                        "paging": true,
                                        "processing": true,
                                        "serverSide": true,
                                        "order": [],
                                        "info": true,
                                        "ajax": {
                                            url: "fetch.php",
                                            type: "POST"
                                        },
                                        "columnDefs": [{
                                            "target": [0, 3, 4],
                                            "orderable": false,
                                        }, ],
                                    });

                                    $(document).on('submit', '#task_form', function(event) {
                                        event.preventDefault();
                                        var id = $('#id').val();
                                        var taskname = $('#taskname').val();
                                        var taskdescription = $('#taskdescription').val();
                                        var taskpriority = $('#taskpriority').val();
                                        var taskstatus = $('#taskstatus').val();

                                        if (taskname != '') {
                                            $.ajax({
                                                url: "insert.php",
                                                method: 'POST',
                                                data: new FormData(this),
                                                contentType: false,
                                                processData: false,
                                                success: function(data) {
                                                    $('#task_form')[0].reset();
                                                    $('#userModal').modal('hide');
                                                    dataTable.ajax.reload();
                                                }
                                            });
                                        } else {
                                            alert("Please Insert  the task name ! ");
                                        }
                                    });
                                    $(document).on('click', '.update', function() {
                                        var task_id = $(this).attr("id");
                                        $.ajax({
                                            url: "fetch_single.php",
                                            method: "POST",
                                            data: {
                                                task_id: task_id
                                            },
                                            dataType: "json",
                                            success: function(data) {
                                                $('#userModal').modal('show');
                                                $('#id').val(data.id);
                                                $('#taskname').val(data.taskname);
                                                $('#taskdescription').val(data.taskdescription);
                                                $('#taskpriority').val(data.taskpriority);
                                                $('#taskstatus').val(data.taskstatus);
                                                $('.modal-title').text("Edit task Details");
                                                $('#task_id').val(task_id);
                                                $('#action').val("Save");
                                                $('#operation').val("Edit");
                                            }
                                        });
                                    });

                                    $(document).on('click', '.delete', function() {

                                        var task_id = $(this).attr("id");
                                        if (confirm("Are you sure want to delete this task?")) {
                                            $.ajax({
                                                url: "delete.php",
                                                method: "POST",
                                                data: {
                                                    task_id: task_id
                                                },
                                                success: function(data) {
                                                    dataTable.ajax.reload();
                                                }
                                            });
                                        } else {
                                            return false;
                                        }
                                    });

                                });
                            </script>

                            <?php endif ?>