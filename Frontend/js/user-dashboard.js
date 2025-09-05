fetch("/Authentication/backend/get-anyuser-info.php")
.then(res=>res.json())
.then((data)=>{console.log(data)
const user = document.getElementById('user')
user.innerText = `Welcome ${data.user_name}!`});


let houseData = [];

function loadHouses(){
  fetch("/Authentication/backend/get-houses.php")
  .then(res => res.json())
  .then(houses => {
    houseData = houses;
    displayHouses(houseData);
  });
}
loadHouses();
// setInterval(loadHouses, 2000);

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
      <span class="price">₦${house.price}</span>
      </div>
      <p class="details">${house.description}</p>
      <a href="/Authentication/Frontend/php/house-details.php?id=${house.id}">View Details</a>
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

  displayHouses(filtered); // ✅ Actually display the filtered results
}

// ✅ Add event listeners after DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("search-btn").addEventListener("click", filterHouses);
  document.getElementById("searchInput").addEventListener("input", filterHouses);
});
