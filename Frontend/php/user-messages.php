<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="/Authentication/Frontend/css/message.css">
        <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0"/>
</head>
<body>
    <div class="container">
        <div class="header-container">
        <h3 id="chat-header"></h3>
        </div>
        <div class="chat-container">
        <div id="chat-box"></div>
        </div>

        <div class="chat-footer">
            <form id="chat-form" class="chat-form">
                    <textarea type="text" id="message" placeholder="Type your message..." class="message-input"> </textarea>
                    <div class="chat-controls">
                        <button id="file-cover"  class="material-symbols-rounded">attach_file</button>
                    <input type="file" id="file"  class="file"/>
                    <button type="submit" class="material-symbols-rounded">
					arrow_upward
					</button>
                    </div>
            </form>
        </div>
        
    </div>
    <script src="/Authentication/Frontend/js/chat.js">
       
    </script>
</body>
</html>