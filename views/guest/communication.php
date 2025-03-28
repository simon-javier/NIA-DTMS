


<?php require 'template/top-template.php'; ?>
<?php 
    require '../../connection.php';
    $convoid = $_GET['convoid'];

    $user_id = $_SESSION['userid'];
    try {
        $getReceiverId = "SELECT user_id from tbl_conversation where user_id != :user_id and conversation_id = :conversation_id";
        $stmt = $pdo->prepare($getReceiverId);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':conversation_id', $convoid);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$result){
            echo 'This conversation not exists.';
            exit;
        }
        // $receiverId = $result['user_id'];

        // $receiverInfo = "SELECT * from tbl_userinformation where id = :receiverId";
        // $stmt = $pdo->prepare($receiverInfo);
        // $stmt->bindParam(':receiverId', $receiverId);
        // $stmt->execute();
        // $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // if(!$result){
        //     echo 'This receiver not exists.';
        //     exit;
        // }
        $receiverFullname = "Admin";
        $userProfile = "user-default.jpg";

        $update = "UPDATE tbl_messages set status = 'read' where conversation_id = :con_id";
        $stmt = $pdo->prepare($update);
        $stmt->bindParam(':con_id', $convoid);
        $stmt->execute();

    } catch (\Throwable $th) {
        
        echo "Error fetching the receiver info: " .$th;
        exit;
    }

    
    // try {
        
    //     $getAllConversation = "SELECT * FROM tbl_messages where conversation_id = :conversation_id ORDER BY timestamp ASC";
    //     $stmt = $pdo->prepare($getAllConversation);
    //     $stmt->bindParam(':conversation_id', $convoid);
    //     $stmt->execute();
    //     $allConvo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // } catch (\Throwable $th) {
    
    //     echo "Error getting the messages: " .$th;
    //     exit;
    // }

?>
<style>
     :root {
    --primary-color: #069734;
    --lighter-primary-color: #07b940;
    --white-color: #FFFFFF;
    --black-color: #181818;
    --bold: 600;
    --transition: all 0.5s ease;
    --box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.2);
    }
    ::-webkit-scrollbar {
        width: 4px;
        height: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #009933; 
        border-radius: 6px;
    }

    .container{
        padding: 2.5rem;
        background-color: #fff;
        box-shadow: var(--box-shadow);
        height: 85vh;
    }
    .main-content{
        position: relative;
        background-color: white;
        top: 0;
        max-height: 90vh;
        overflow-y: scroll;
        left: 90px;
        transition: var(--transition);
        width: calc(100% - 90px);
        padding: 1rem;

    }
    .conversation-list {
        padding: 0;
    }

    .conversation-list-item {
        display: flex;
        align-items: center;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        cursor: pointer;
    }

    .conversation-list-item img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }
    .message-timestamp{
        font-size: 12px
    }

    .chat-bubble {
        padding: 10px;
        margin: 10px 0;
        border-radius: 10px;
    }

    .receive-chat-bubble {
        background-color: #e0e0e0;
        margin-left: 10px;
    }

    .sender-chat-bubble {
        background-color: #007bff;
        color: #fff;
        margin-right: 10px;
        text-align: right;
    }
    .input-container {
        display: flex;
        margin-top: 10px;
    }
    #messageInput {
        flex: 1;
        margin-right: 10px;
    }

    #sendButton {
        width: 80px; /* Adjust the width as needed */
    }
</style>

    <div class="container">
    <div class="chat-container" id="chatContainer">
            <div class="receiver-info d-flex align-item-center p-3">
            <img src="<?php echo $env_basePath; ?>assets/user-profile/<?php echo $userProfile; ?>" alt="User Image" style="border-radius: 50%; height: 50px; width: 50px">
            <h4 style="margin-top: 10px; margin-left: 10px"><?php echo $receiverFullname ?></h4>
            </div>
            <div id="chats" style="max-height: 51vh; overflow-y:scroll;">
                
            </div>
            
            
        </div>
        <form id="send-message-form">
                <div class="input-container">
                    <input type="hidden" value="<?php echo $convoid; ?> " name="conversation_id">
                    <textarea id="messageInput" class="form-control" name="message" rows="3" placeholder="Type your message..."></textarea>
                    <button id="sendButton" class="btn btn-primary">Send</button>
                </div>
            </form>
    </div>


<?php require 'template/bottom-template.php'; ?>
<script>
  
    window.onload = function () {
        fetchMessages();
    };
</script>


<script>
    $("#sendButton").click(function(e){
        var messageInput = $("#messageInput").val();
        
        if(messageInput.trim() !== ''){
            if($("#send-message-form")[0].checkValidity()){
            e.preventDefault();

            $('.loader-container').fadeIn();
            var formData = new FormData($("#send-message-form")[0]);
            formData.append("action", "send_message");

            $.ajax({
                url: "../../controller/conversation-controller.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success:function(response){

                    setTimeout(function() {

                    $('.loader-container').fadeOut();
                    }, 500);
                
                    if(response.status === "failed"){
                        Swal.fire({
                            title: 'Something went wrong!',
                            text: response.message,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }else if(response.status === "error"){
                        Swal.fire({
                            title: 'Error!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                    }
                    else if(response.status === "success"){
                        // location.reload();
                        fetchMessages();
                    }
                    
                   
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    var errorMessage = 'An error occurred while processing your request.';
                    if (xhr.statusText) {
                        errorMessage += ' ' + xhr.statusText;
                    }
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage + '<br><br>' + JSON.stringify(xhr, null, 2), // Include the entire error object for debugging
                        icon: 'error',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        // Check if the user clicked the "OK" button
                        if (result.isConfirmed) {
                            // Reload the page
                            location.reload();
                        }
                    });
                }
            });
        } 
        }else{
            e.preventDefault();
            return;
        }
    });
    function fetchMessages() {
    var chatContainer = document.getElementById('chats');
    
    $.ajax({
        url: "../../controller/conversation-controller.php",
        type: "POST",
        data: { convoid: <?php echo $convoid; ?>, action: 'retrieve' }, 
        success: function(response) {
       
            var isScrolledToBottom = chatContainer.scrollHeight - chatContainer.clientHeight <= chatContainer.scrollTop + 10000;


            chatContainer.innerHTML = '';

            if (response.status === 'success') {
        
                response.data.forEach(function(message) {
                    var messageContent = message.message; 
                    var timestamp = message.timestamp; 

                    var bubbleClass = (message.user_id == <?php echo $_SESSION['userid']; ?>) ? 'sender-chat-bubble' : 'receive-chat-bubble';

                    // Create a new chat bubble and append it to the chat container
                    var chatBubble = document.createElement('div');
                    chatBubble.className = bubbleClass + ' chat-bubble';
                    chatBubble.innerHTML = '<p>' + messageContent + '</p>' +
                        '<p class="message-timestamp">' + timestamp + '</p>';
                    
                    chatContainer.appendChild(chatBubble);
                });

                // Scroll to the bottom after adding new messages
                if (isScrolledToBottom) {
                    chatContainer.lastChild.scrollIntoView(false);
                }

                // Update the form, e.g., clear the input field
                document.getElementById('messageInput').value = '';
            } else {
                console.error('Error fetching messages:', response.message);
            }
        },
        error: function(xhr, status, error) {
            // Handle the error here
            console.error('Error fetching messages:', error);
        }
    });
}
</script>

