document.addEventListener("DOMContentLoaded", function() {
    const searchInput = document.getElementById("searchInput");
    const cardContainer = document.getElementById("cardContainer");

    searchInput.addEventListener("input", function() {
        const searchTerm = searchInput.value.toLowerCase();
        fetch("get_pharmacies.php?search=" + searchTerm)
            .then(response => response.json())
            .then(data => {
                cardContainer.innerHTML = "";
                data.forEach(pharmacy => {
                    const card = `
                        <div class="card">
                            <img src="${pharmacy.GorselPath}" alt="${pharmacy.EczaneAdi}">
                            <h3>${pharmacy.EczaneAdi}</h3>
                            <p><strong>Şehir:</strong> ${pharmacy.Sehir}</p>
                            <p><strong>İlçe:</strong> ${pharmacy.Ilce}</p>
                            <p><strong>Açıklama:</strong> ${pharmacy.Aciklama}</p>
                        </div>
                    `;
                    cardContainer.innerHTML += card;
                });
            })
            .catch(error => console.error("Hata:", error));
    });
});
