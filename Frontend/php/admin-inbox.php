<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }
        body{
            background-color: #e3e1e1;
            font-family:"Inter", sans-serif;
        }
    .unread-indicator {
    background: red;
    color: white;
    font-size: 10px;
    border-radius: 50%;
    padding: 2px 6px;
    margin-left: 5px;
  }
.inbox-message{
  background-color: white;
  padding: 10px 15px;
  border-radius: 13px;
  margin-bottom: 10px ;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  
}
.inbox-message small{
    font-size:12px;
    color:#ccc; 
}
.inbox-message p{
    font-size:15px;
    text-align:left;
    
 
}
.inbox-list{
 padding:10px
}
    </style>
</head>
<body>
    <div class="inbox-list" id="inbox-list"></div>

    <script>
          const session_user_type = "<?php echo $_SESSION['user_type']; ?>";
  const session_user_id = "<?php echo $_SESSION['user_id']; ?>";
    </script>
    <script src="/Authentication/Frontend/js/inbox.js"></script>
</body>
</html>