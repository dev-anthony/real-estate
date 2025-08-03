
function loadInbox() {
  fetch('/Authentication/backend/get-inbox.php')
    .then(res => res.json())
    .then(data => {
      const inboxContainer = document.getElementById('inbox-list');
      inboxContainer.innerHTML = '';

      if (data.length === 0) {
        inboxContainer.innerHTML = '<p>No messages found.</p>';
        return;
      }

      data.forEach(msg => {
        const div = document.createElement('div');
        div.classList.add('inbox-message');

        const unreadBadge = msg.is_read == '0' && msg.receiver_type === session_user_type && msg.receiver_id === session_user_id
          ? '<span class="unread-indicator">New</span>' : '';

        const displayName = msg.sender_type + ' ' + msg.sender_id;

        div.innerHTML = `
          <h3>${displayName}</h3>
          <br>
          <p> ${msg.message || '[File]'} ${unreadBadge}</p>
          <br>
          <small>${msg.timestamp}</small>
        `;

        const userId = msg.sender_type === 'user' ? msg.sender_id : msg.receiver_id;
        const adminId = msg.sender_type === 'admin' ? msg.sender_id : msg.receiver_id;

        div.addEventListener('click', () => {
          window.location.href = `/Authentication/Frontend/php/user-messages.php?user_id=${userId}&admin_id=${adminId}`;
        });

        inboxContainer.appendChild(div);
      });
    });
}

setInterval(loadInbox, 2000);


