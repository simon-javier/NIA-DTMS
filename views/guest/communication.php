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

<div class="self-center bg-neutral-50 mt-5 p-10 w-[95%] rounded-md shadow-xl flex flex-col gap-5">
    <div class="flex items-center gap-2">
        <img class="drop-shadow-2xl size-9 object-cover rounded-full" src="<?php echo $env_basePath; ?>assets/user-profile/<?php echo $userProfile; ?>" alt="User Image">
        <h1 class="font-bold text-gray-800 flex gap-1 items-baseline"><span class="text-xs">To:</span> <?php echo strtoupper($receiverFullname)?></h1>
    </div>
    <div id="chats" class="flex-1 basis-[500px] overflow-y-auto flex flex-col gap-2">

    </div>
    <form id="send-message-form">
            <div class="flex gap-3">
                <input type="hidden" value="<?php echo $convoid; ?> " name="conversation_id">
                <textarea id="messageInput" class="w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-green-600 sm:text-sm/6" name="message" rows="3" placeholder="Type your message..."></textarea>
                <button id="sendButton" class="bg-green-600 rounded-md p-3 text-neutral-50">Send</button>
            </div>
    </form>
</div>

</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    window.onload = function () {
        fetchMessages();
    };
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
                            `<p class="${bubbleClass}-timestamp">` + timestamp + '</p>';

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
})
</script>

