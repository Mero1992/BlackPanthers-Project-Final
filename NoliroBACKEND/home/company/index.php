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
        <h1>Administrate Company Table</h1>
        <div class="col-sm-8">
		<div class="well clearfix">
			<div class="pull-right"><button type="button" class="btn btn-xs btn-primary" id="command-add" data-row-id="0">
			<span class="glyphicon glyphicon-plus"></span> Record</button></div></div>
		<table id="company_grid" class="table table-condensed table-hover table-striped" width="60%" cellspacing="0" data-toggle="bootgrid">
			<thead>
				<tr>
					<th data-column-id="companyID" data-type="numeric" data-identifier="true">CompanyID</th>
                    <th data-column-id="companyName">CompanyName</th>
                    <th data-column-id="street">Street</th>
					<th data-column-id="postnr">PostNr</th>
                    <th data-column-id="city">City</th>
					<th data-column-id="description">Description</th>
					<th data-column-id="website">Website</th>
					<th data-column-id="facebook">Facebook</th>
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
                <h4 class="modal-title">Add Company</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_add">
				<input type="hidden" value="add" name="action" id="action">
                  <div class="form-group">
                    <label for="companyName" class="control-label">CompanyName:</label>
                    <input type="text" class="form-control" id="companyName" name="companyName"/>
                  </div>
                  <div class="form-group">
                    <label for="street" class="control-label">Street</label>
                    <input type="text" class="form-control" id="street" name="street"/>
                  </div>
				  <div class="form-group">
                    <label for="postnr" class="control-label">Postnr:</label>
                    <input type="number" class="form-control" id="postnr" name="postnr"/>
                  </div>
                    <div class="form-group">
                    <label for="city" class="control-label">City:</label>
                    <input type="text" class="form-control" id="city" name="city"/>
                  </div>
                    <div class="form-group">
                    <label for="description" class="control-label">Description:</label>
                    <input type="text" class="form-control" id="description" name="description"/>
                  </div>
                     <div class="form-group">
                    <label for="website" class="control-label">Website:</label>
                    <input type="text" class="form-control" id="website" name="website"/>
                  </div>
                     <div class="form-group">
                    <label for="facebook" class="control-label">Facebook:</label>
                    <input type="text" class="form-control" id="facebook" name="facebook"/>
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
                <h4 class="modal-title">Edit Company</h4>
            </div>
            <div class="modal-body">
                <form method="post" id="frm_edit">
				<input type="hidden" value="edit" name="action" id="action">
				<input type="hidden" value="0" name="edit_companyID" id="edit_companyID">
                   <div class="form-group">
                    <label for="companyName" class="control-label">CompanyName:</label>
                    <input type="text" class="form-control" id="edit_companyName" name="edit_companyName"/>         
                  </div>
                  <div class="form-group">
                    <label for="street" class="control-label">Street</label>
                    <input type="text" class="form-control" id="edit_street" name="edit_street"/>     
                  </div>
				  <div class="form-group">
                    <label for="postnr" class="control-label">Postnr:</label>
                    <input type="number" class="form-control" id="edit_postnr" name="edit_postnr"/>   
                  </div>
                    <div class="form-group">
                    <label for="city" class="control-label">City:</label>
                    <input type="text" class="form-control" id="edit_city" name="edit_city"/>
                  </div>
                    <div class="form-group">
                    <label for="description" class="control-label">Description:</label>
                    <input type="text" class="form-control" id="edit_description" name="edit_description"/>
                  </div>
                     <div class="form-group">
                    <label for="website" class="control-label">Website:</label>
                    <input type="text" class="form-control" id="edit_website" name="edit_website"/>
                  </div>
                     <div class="form-group">
                    <label for="facebook" class="control-label">Facebook:</label>
                    <input type="text" class="form-control" id="edit_facebook" name="edit_facebook"/>
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
	var grid = $("#company_grid").bootgrid({
		ajax: true,
		rowSelect: true,
		post: function ()
		{
			/* To accumulate custom parameter with the request object */
			return {
				id: "b0df282a-0d67-40e5-8558-c9e93b7befed"
			};
		},
		
		url: "response.php",
		formatters: {
		        "commands": function(column, row)
		        {
		            return "<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.companyID + "\"><span class=\"glyphicon glyphicon-edit\"></span></button> " + 
		                "<button type=\"button\" class=\"btn btn-xs btn-default command-delete\" data-row-id=\"" + row.companyID + "\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
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
                                $('#edit_companyID').val(ele.siblings(':first').html()); // in case we're changing the key
                                $('#edit_companyName').val(ele.siblings(':nth-of-type(2)').html());
                                $('#edit_street').val(ele.siblings(':nth-of-type(3)').html());
                                $('#edit_postnr').val(ele.siblings(':nth-of-type(4)').html());
                                $('#edit_city').val(ele.siblings(':nth-of-type(5)').html());
                                $('#edit_description').val(ele.siblings(':nth-of-type(6)').html());
                                $('#edit_website').val(ele.siblings(':nth-of-type(7)').html());
                                $('#edit_facebook').val(ele.siblings(':nth-of-type(8)').html());
					} else {
					 alert('No row selected! First select row, then click edit button');
					}
    }).end().find(".command-delete").on("click", function(e)
    {
	
		var conf = confirm('Delete item with companyID: ' + $(this).data("row-id") + ' ?');
					alert(conf);
                    if(conf){
                                $.post('response.php', { id: $(this).data("row-id"), action:'delete'}
                                    , function(){
                                        // when ajax returns (callback), 
										$("#company_grid").bootgrid('reload');
                                }); 
								//$(this).parent('tr').remove();
								//$("#company_grid").bootgrid('remove', $(this).data("row-id"))
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
					$("#company_grid").bootgrid('reload');
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
