
document.getElementById('houseForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = document.getElementById('houseForm');
    const formData = new FormData(form);
    // formData.append('admin_id', 2); 

    const res = await fetch('/Authentication/backend/add-house.php', {
        method: 'POST',
        body: formData
    });

    const result = await res.json();
    const msgBox = document.getElementById("msg");
    // .then(res => {
    //     if (!res.ok) {
    //       throw new Error('Not logged in or server error');
    //     }
    //     return res.json();
    //   })

    if (result.success) {
        msgBox.textContent = "House added successfully!";
        msgBox.style.color = "green";
        form.reset();
    } else {
        msgBox.textContent = result.error || "Something went wrong!";
        msgBox.style.color = "red";
    }
});

