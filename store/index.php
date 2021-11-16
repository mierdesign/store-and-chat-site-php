<?php
session_start();
require_once("../header.php");
if(!isset($_SESSION['user_id']))
{
echo"<script>window.location.href='../login.php'</script>";
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <script src="./script.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <header class="top">
        <div class="nav-left"><a class="logo" href="#"><img src="./logo.png"></a></div>
        <div class="nav-right"><a href="#"><i class="material-icons">shopping_cart</i></a><a href="#"><i class="material-icons">search</i></a></div>
        <div class="nav-searchbar">
          <form action="" method="post" >
                  <input name="valueToSearch" value="<?php if (isset($_POST['valueToSearch'])) echo $_POST['valueToSearch'];?>" class="searchbar" type="text" placeholder="Search">
                  <input type="submit" name="search" value="Search Record..">
           </form>
        </div>
      </header>
  <main class="middle">
<?php
require("./db.php");
if(isset($_POST['valueToSearch'])){
$valueToSearch = $_POST['valueToSearch'];

$sql = "SELECT * FROM items WHERE itemname LIKE '%$valueToSearch%' ORDER BY itemid DESC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data one by one
while($row = $result->fetch_assoc()) {
$ownerid = $row["ownerid"];

echo '<div class="box"><img class="itemimage" src="'.$row['imagesrc'].'"/><div class="items"><div class="itemname">'.$row["itemname"].'</div><br><div class="itemdec">description: '.$row["itemdesc"].'</div><br><div class="owner">by '.$row["owner"].'</div><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['ownerid'].'" data-tousername="'.$row['username'].'">Start Chat</button></div></div>';
















//fetch_user.php $query = " SELECT * FROM login WHERE user_id != '".$_SESSION['user_id']."'"; $statement = $connect->prepare($query); $statement->execute(); $result = $statement->fetchAll(); foreach($result as $row){ if($row['user_id'] = $ownerid){ $status = ''; $current_timestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second'); $current_timestamp = date('Y-m-d H:i:s', $current_timestamp); $user_last_activity = fetch_user_last_activity($row['user_id'], $connect); if($user_last_activity > $current_timestamp) { $status = '<span class="label label-success">Online</span>'; } else { $status = '<span class="label label-danger">Offline</span>'; } $output .= ' <tr> <td>'.$row['username'].' '.count_unseen_message($row['user_id'], $_SESSION['user_id'], $connect).' '.fetch_is_type_status($row['user_id'], $connect).'</td> <td>'.$status.'</td> <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Start Chat</button></td> </tr> '; } } $output .= '</table>';










    }
} else {
$sql = "SELECT * FROM items WHERE itemdesc LIKE '%$valueToSearch%' ORDER BY itemid DESC";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data one by one
      while($row = $result->fetch_assoc()) {
        $ownerid = $row["ownerid"];
        echo '<div class="box"><img class="itemimage" src="'.$row['imagesrc'].'"/><div class="items"><div class="itemname">'.$row["itemname"].'</div><br><div class="itemdec">description: '.$row["itemdesc"].'</div><br><div class="owner">by '.$row["owner"].'</div><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['to_user_id'].'" data-tousername='.$row['from_user_id'].'>Start Chat</button></div></div>';



}
}else{
$sql = "SELECT * FROM items WHERE owner LIKE '%$valueToSearch%' ORDER BY itemid DESC";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data one by one
      while($row = $result->fetch_assoc()) {
        $ownerid = $row["ownerid"];
        echo '<div class="box"><img class="itemimage" src="'.$row['imagesrc'].'"/><div class="items"><div class="itemname">'.$row["itemname"].'</div><br><div class="itemdec">description: '.$row["itemdesc"].'</div><br><div class="owner">by '.$row["owner"].'</div><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['ownerid'].'" data-tousername="'.$row['username'].'">Start Chat</button></div></div>';

}
}
}
}
$conn->close();
}else {
$sql = "SELECT * FROM items ORDER BY itemid DESC";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    // output data one by one
      while($row = $result->fetch_assoc()) {
        $ownerid = $row["ownerid"];
        echo '<div class="box"><img class="itemimage" src="'.$row['imagesrc'].'"/><div class="items"><div class="itemname">'.$row["itemname"].'</div><br><div class="itemdec">description: '.$row["itemdesc"].'</div><br><div class="owner">by '.$row["owner"].'</div><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$row['ownerid'].'" data-tousername="'.$row['username'].'">Start Chat</button></div></div>';

}
}
}

      ?>
      </main>
    </div>
  </body>
</html>















<html>  
    <body>  
        <div style="display:none;" class="container">
	    <div class="table-responsive">
		<div id="user_model_details"></div>
            </div>
	</div>	
    </body>  
</html>

<style>

.chat_message_area
{
	position: relative;
	width: 100%;
	height: auto;
	background-color: #FFF;
    border: 1px solid #CCC;
    border-radius: 3px;
}

</style> 

<script> 
$(document).ready(function(){


	setInterval(function(){
		update_last_activity();
		update_chat_history_data();
	}, 5000);

	function update_last_activity()
	{
		$.ajax({
			url:"../update_last_activity.php",
			success:function()
			{

			}
		})
	}

	function make_chat_dialog_box(to_user_id, to_user_name)
	{
		var modal_content = '<div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
		modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
		modal_content += fetch_user_chat_history(to_user_id);
		modal_content += '</div>';
		modal_content += '<div class="form-group">';
		modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control chat_message"></textarea>';
		modal_content += '</div><div class="form-group" align="right">';
		modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div></div>';
		$('#user_model_details').html(modal_content);
	}

	$(document).on('click', '.start_chat', function(){
		var to_user_id = $(this).data('touserid');
		var to_user_name = $(this).data('tousername');
		make_chat_dialog_box(to_user_id, to_user_name);
		$("#user_dialog_"+to_user_id).dialog({
			autoOpen:false,
			width:400
		});
		$('#user_dialog_'+to_user_id).dialog('open');
		$('#chat_message_'+to_user_id).emojioneArea({
			pickerPosition:"top",
			toneStyle: "bullet"
		});
	});
        $(function () {
            $(".chat_message").keypress(function (e) {
                var code = (e.keyCode ? e.keyCode : e.which);
                //alert(code);
                if (code == 13) {
                    $(".send_chat").attr("id").trigger('click');
                    return true;
                }
            });
        });
	$(document).on('click', '.send_chat', function() {
		var to_user_id = $(this).attr('id');
		var chat_message = $.trim($('#chat_message_'+to_user_id).val());
		if(chat_message != '')
		{
			$.ajax({
				url:"../insert_chat.php",
				method:"POST",
				data:{to_user_id:to_user_id, chat_message:chat_message},
				success:function(data)
				{
					//$('#chat_message_'+to_user_id).val('');
					var element = $('#chat_message_'+to_user_id).emojioneArea();
					element[0].emojioneArea.setText('');
					$('#chat_history_'+to_user_id).html(data);
				}
			})
		}
		else
		{
			alert('Type something');
		}
	});

	function fetch_user_chat_history(to_user_id)
	{
		$.ajax({
			url:"../fetch_user_chat_history.php",
			method:"POST",
			data:{to_user_id:to_user_id},
			success:function(data){
				$('#chat_history_'+to_user_id).html(data);
			}
		})
	}

	function update_chat_history_data()
	{
		$('.chat_history').each(function(){
			var to_user_id = $(this).data('touserid');
			fetch_user_chat_history(to_user_id);
		});
	}

	$(document).on('click', '.ui-button-icon', function(){
		$('.user_dialog').dialog('destroy').remove();
		$('#is_active_group_chat_window').val('no');
	});

	$(document).on('focus', '.chat_message', function(){
		var is_type = 'yes';
		$.ajax({
			url:"../update_is_type_status.php",
			method:"POST",
			data:{is_type:is_type},
			success:function()
			{

			}
		})
	});

	$(document).on('blur', '.chat_message', function(){
		var is_type = 'no';
		$.ajax({
			url:"../update_is_type_status.php",
			method:"POST",
			data:{is_type:is_type},
			success:function()
			{
				
			}
		})
	});

	$(document).on('click', '.remove_chat', function(){
		var chat_message_id = $(this).attr('id');
		if(confirm("Are you sure you want to remove this chat?"))
		{
			$.ajax({
				url:"../remove_chat.php",
				method:"POST",
				data:{chat_message_id:chat_message_id},
				success:function(data)
				{
					update_chat_history_data();
				}
			})
		}
	});
	
});  
</script>