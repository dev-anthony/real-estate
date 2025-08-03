<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="/Authentication/Frontend/css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
  
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>La Maison <i class="fa-solid fa-house"></i></h2>
            <a href="#" class="nav-link">Dashboard</a>
            <a href="/Authentication/Frontend/html/properties.html" class="nav-link">Properties</a>
            <a href="/Authentication/Frontend/html/application.html" class="nav-link">Applications</a>
            <a href="/Authentication/Frontend/php/admin-inbox.php" class="nav-link">Messages</a>
            <a href="/Authentication/Frontend/php/add-admin.php" class="nav-link">Add Admin</a>
            <a href="/Authentication/backend/logout.php" class="nav-link" id="logout" class="logout">Logout</a>
        </aside>

        <div class="main-content">
             <!-- Topbar -->
            <div class="topbar">
                <div class="search-bar-button-con">
                <div class="search-bar">
                    <input  id="searchInput" type="text" placeholder="Search properties..." />
                </div>
                <button id="search-btn">Search</button>
                </div>
                <button id="menubutton">
                  <i class="fa fa-bars" ></i>
                </button>
            </div>

            <div class="text">
                <h2>Properties</h2>
                <a href="/Authentication/Frontend/html/admin-add-house.html">Add Property <i class="fa fa-plus"></i></a>
            </div>

           <div class="house-section">
           <div class="house-list" id="house-list"></div>
           </div>
        </div>
    </div>
<script>

  let houseData = [];

  function fetchHouses(){
  fetch("/Authentication/backend/get-houses.php")
    .then(res => res.json())
    .then(houses => {
      houseData = houses;
      displayHouses(houseData);
    });
  }
  //fetch houses after some seconds
  fetchHouses();
  setInterval(fetchHouses, 2000);



function displayHouses(houses) {
  const container = document.getElementById("house-list");
  container.innerHTML = "";

  if (!houses.length) {
    container.innerHTML = "No houses available at the moment";
    return;
  }

  houses.forEach(house => {
    const card = document.createElement('div');
    card.className = 'house-card';
    card.innerHTML = `
      <div class="image-container">
      <img src="/Authentication/assets/${house.image}" alt="House image" >
      </div>
      <div class="card-contents">
      <div class="flex">
      <h3>${house.title}, ${house.location}</h3>
      <span class="price">$${house.price}</span>
      </div>
      <p class="details">${house.description}</p>
      </div>
    `;
    container.appendChild(card);
  });
}

function filterHouses() {
  const query = document.getElementById("searchInput").value.toLowerCase();
  const filtered = houseData.filter(house => 
    house.location.toLowerCase().includes(query) ||
    house.title.toLowerCase().includes(query) ||
    house.price.toLowerCase().includes(query)
  );

  displayHouses(filtered); 
}
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("search-btn").addEventListener("click", ()=>{
    document.getElementById("searchInput").value = "";
    filterHouses
  });
  document.getElementById("searchInput").addEventListener("input", filterHouses);
});

const menubtn = document.getElementById("menubutton")
const sidebar = document.querySelector('.sidebar');
menubtn.addEventListener('click', ()=>{
  const icon = menubtn.querySelector("i");
  sidebar.classList.toggle('active');

  if(sidebar.classList.contains('active')){
    icon.classList.remove('fa-bars');
    icon.classList.add('fa-times');
  }else{
    icon.classList.remove('fa-times');
    icon.classList.add('fa-bars');
  }
})
  
</script>
</body>
</html>