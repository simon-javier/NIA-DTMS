<?php require 'template/top-template.php'; ?>
<?php
require '../../connection.php';
    $user_id = $_SESSION['userid'];
    $myConversationListQuery = "SELECT * from tbl_conversation where user_id = 'recordoffice'";
    $stmt = $pdo->prepare($myConversationListQuery);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $listOfreceiver = [];

    foreach($results as $result){
        $conversationListQuery = "SELECT * from tbl_conversation where user_id != 'recordoffice' and conversation_id = :conversation_id";
        $stmt = $pdo->prepare($conversationListQuery);
        $stmt->bindParam(':conversation_id', $result['conversation_id']);
        $stmt->execute();
        $receiver = $stmt->fetch(PDO::FETCH_ASSOC);

        $receiverId = $receiver['user_id'];

        $receiverInfoq = "SELECT * from tbl_userinformation where id = :receiverId";
        $stmt = $pdo->prepare($receiverInfoq);
        $stmt->bindParam(':receiverId', $receiverId);
        $stmt->execute();
        $receiverInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        $listOfreceiver[] = [
            'fullname' => $receiverInfo['firstname'] . ' ' . $receiverInfo['lastname'],
            'userProfile' => $receiverInfo['user_profile'],
            'conversationId' => $result['conversation_id']
        ];
    }

    if(isset($_GET['convoid'])){
        try {
            $convoid = $_GET['convoid'];
            $getReceiverId = "SELECT user_id from tbl_conversation where user_id != 'recordoffice' and conversation_id = :conversation_id";
            $stmt = $pdo->prepare($getReceiverId);
            $stmt->bindParam(':conversation_id', $convoid);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$result){
                echo 'This conversation not exists.';
                exit;
            }
            $receiverId = $result['user_id'];
    
            $receiverInfo = "SELECT * from tbl_userinformation where id = :receiverId";
            $stmt = $pdo->prepare($receiverInfo);
            $stmt->bindParam(':receiverId', $receiverId);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$result){
                echo 'This receiver not exists.';
                exit;
            }
            $receiverFullname = $result['firstname'] . ' ' . $result['lastname'];
            $userProfile = $result['user_profile'];
        } catch (\Throwable $th) {
            
            echo "Error fetching the receiver info: " .$th;
            exit;
        }
    }

    
    
?>

<div class="flex self-center bg-neutral-50 mt-5 px-10 pl-0 w-[95%] min-h-[700px] rounded-xl shadow-xl gap-1">
    <div class="flex flex-col basis-[300px] m-5 border-r-2 border-r-neutral-200">
        <?php if (empty($listOfreceiver)) { ?>
            <!-- Display a message when the list is empty -->
            <p class="m-auto">No conversations yet</p>
            <?php } else {
            foreach ($listOfreceiver as $row) { ?>
                <a href="communication.php?convoid=<?php echo $row['conversationId']; ?>">
                    <div class="conversation-list-item flex gap-3 p-3 border-y-1 border-neutral-200">
                        <img src="<?php echo $env_basePath ?>assets/user-profile/<?php echo $row['userProfile'] ?>"
                            alt="User Image" class="rounded-full w-10 h-10 drop-shadow-2xl">
                        <p style="margin-top: 10px">
                            <?php echo $row['fullname']; ?>
                        </p>
                    </div>
                </a>
        <?php }
        } ?>
    </div>
    <?php if (isset($_GET['convoid'])) {  ?>
        <div class="flex flex-col gap-5 p-3 flex-1 m-5 chat-container" id="chatContainer">
            <div class="flex items-center gap-2 receiver-info">
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
    <?php } ?>
</div>

</main>

<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.2.1.slim.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jquery/jquery-3.6.4.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/popper.min.js"></script>
<script src="<?php echo $env_basePath; ?>assets/jsdelivr/sweetalert2.all.min.js"></script>

<script>

    // Scroll the chat container to the bottom when the page is fully loaded
    window.onload = function () {
        var chatContainer = document.getElementById('chatContainer');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    };

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

                        var bubbleClass = (message.user_id == 'recordoffice') ? 'sender-chat-bubble' : 'receive-chat-bubble';

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
</script>

