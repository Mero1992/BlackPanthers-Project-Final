<?php
session_start();
include_once '../../dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: ../../index.php");
}

$query = $conn->query("SELECT * FROM user WHERE userID=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome</title>
<link rel="stylesheet" href="../dist/bootstrap.min.css" type="text/css" media="all">
<link href="../dist/jquery.bootgrid.css" rel="stylesheet" />
 <link href="../home.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
<script src="../dist/jquery-1.11.1.min.js"></script>
<script src="../dist/bootstrap.min.js"></script>
<script src="../dist/jquery.bootgrid.min.js"></script>
</head>
<body>
 	<!--Nav bar-->
			<div class="nav-top">
				<a href="../home.php"><strong>Home</strong></a>
                <span class="right">
                <a href="../activity/index.php"><strong>Activity</strong></a>
				<a href="../company/index.php"><strong>Company</strong></a>
                <a href="../community/index.php"><strong>Community</strong></a>
                <a href="../story/index.php"><strong>Story</strong></a> 
                <a href="../user/index.php"><strong>User</strong></a>
		        <a href="../logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></span>
			</div>
        <!--Nav bar -->
	<div class="container">
      <div class="">
        <h1>Administrate Activity Table</h1>
        <div class="col-sm-8">
		<div class="well clearfix">
			<div class="pull-right"><button type="button" class="btn btn-xs btn-primary" id="command-add" data-row-id="0">
			<span class="glyphicon glyphicon-plus"></span> Record</button></div></div>
		<table id="activity_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
			<thead>
				<tr>
					<th data-column-id="activityID" data-type="numeric" data-identifier="true">Actid</th> 
					<th data-column-id="activityName">Name</th>
					<th data-column-id="activityDescription">Description</th>
					<th data-column-id="activityKeyword">Keyword</th>
					<th data-column-id="commands" data-formatter="commands" data-sortable="false">Commands</th>
				</tr>
			</thead>
		</table>
    </div>
      </div>
    </div>
	
<div id="add_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Activity</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add">
				<input type="hidden" value="add" name="action" id="action">
                  <div class="form-group">
                    <label for="name" class="control-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name"/>
                  </div>
                  <div class="form-group">
                    <label for="description" class="control-label">Description:</label>
                    <input type="text" class="form-control" id="description" name="description"/>
                  </div>
				  <div class="form-group">
                    <label for="description" class="control-label">Keyword:</label>
                    <input type="text" class="form-control" id="keyword" name="keyword"/>
                  </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="btn_add" class="btn btn-primary">Save</button>
            </div>
			</form>
        </div>
    </div>
</div>
<div id="edit_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Activity</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit">
				<input type="hidden" value="edit" name="action" id="action">
				<input type="hidden" value="0" name="edit_activityID" id="edit_activityID">
                  <div class="form-group">
                    <label for="name" class="control-label">Name:</label>
                    <input type="text" class="form-control" id="edit_activityName" name="edit_activityName"/>
                  </div>
                  <div class="form-group">
                    <label for="description" class="control-label">Description:</label>
                    <input type="text" class="form-control" id="edit_activityDescription" name="edit_activityDescription"/>
                  </div>
				  <div class="form-group">
                    <label for="description" class="control-label">Keyword:</label>
                    <input type="text" class="form-control" id="edit_activityKeyword" name="edit_activityKeyword"/>
                  </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="btn_edit" class="btn btn-primary">Save</button>
            </div>
			</form>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
$( document ).ready(function() {
	var grid = $("#activity_grid").bootgrid({
		ajax: true,
		rowSelect: true,
		post: function ()
		{
			/* To accumulate custom parameter with the request object */
			return {
				id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
			};
		},
		
		url: "response.php", /* row.id to row.activityID !!!!!!!!!!!!!!!!!!!!!!!!!!*/
		formatters: {
		        "commands": function(column, row)
		        {
		            return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.activityID + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
		                "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.activityID + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
		        }
		    }
   }).on("loaded.rs.jquery.bootgrid", function()
{
    /* Executes after data is loaded and rendered */
    grid.find(".command-edit").on("click", function(e)
    {
        //alert("You pressed edit on row: " + $(this).data("row-id"));
			var ele =$(this).parent();
			var g_id = $(this).parent().siblings(':first').html();
            var g_name = $(this).parent().siblings(':nth-of-type(2)').html();
console.log(g_id);
                    console.log(g_name);

		//console.log(grid.data());//
		$('#edit_model').modal('show');
					if($(this).data("row-id") >0) {
							
                                // collect the data
                                $('#edit_activityID').val(ele.siblings(':first').html()); // in case we're changing the key
                                $('#edit_activityName').val(ele.siblings(':nth-of-type(2)').html());
                                $('#edit_activityDescription').val(ele.siblings(':nth-of-type(3)').html());
                                $('#edit_activityKeyword').val(ele.siblings(':nth-of-type(4)').html());
					} else {
					 alert('No row selected! First select row, then click edit button');
					}
    }).end().find(".command-delete").on("click", function(e)
    {
	
		var conf = confirm('Delete item with Actid: ' + $(this).data("row-id") + ' ?');
					alert(conf);
                    if(conf){
                                $.post('response.php', { id: $(this).data("row-id"), action:'delete'}
                                    , function(){
                                        // when ajax returns (callback), 
										$("#activity_grid").bootgrid('reload');
                                }); 
								//$(this).parent('tr').remove();
								//$("#activity_grid").bootgrid('remove', $(this).data("row-id"))
                    }
    });
});

function ajaxAction(action) {
				data = $("#frm_"+action).serializeArray();
				$.ajax({
				  type: "POST",  
				  url: "response.php",  
				  data: data,
				  dataType: "json",       
				  success: function(response)  
				  {
					$('#'+action+'_model').modal('hide');
					$("#activity_grid").bootgrid('reload');
				  }   
				});
			}
			
			$( "#command-add" ).click(function() {
			  $('#add_model').modal('show');
			});
			$( "#btn_add" ).click(function() {
			  ajaxAction('add');
			});
			$( "#btn_edit" ).click(function() {
			  ajaxAction('edit');
			});
});
</script>
