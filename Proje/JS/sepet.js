document.addEventListener('DOMContentLoaded', () => {
    fetchCartItems();

    const sepetToggle = document.querySelector('.sepet-toggle');
    const sepetPanel = document.querySelector('.sepet-panel');

    if (sepetToggle && sepetPanel) {
        sepetToggle.addEventListener('click', () => {
            sepetPanel.classList.toggle('open');
            fetchCartItems();
        });
    }
});

function handleCartClick(baslik) {
        if (!window.userLoggedIn) {
        alert("Bilet almak için lütfen önce giriş yapın.");
        return;
    }
    fetch('/Proje/sepeteEkle.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'başlık=' + encodeURIComponent(baslik)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'ok') {
            alert("Ürün sepete eklendi.");
            fetchCartItems();
        } else {
            alert(data.message || "Bir hata oluştu.");
        }
    })
    .catch(err => console.error("Sepete ekleme hatası:", err));
}

function fetchCartItems() {
    fetch('/Proje/sepet_veri.php')
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector('.sepet-panel .sepet-icerik');
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = '<p>Sepet boş</p>';
                return;
            }

            data.forEach((item, index) => {
                const div = document.createElement('div');
                div.classList.add('sepet-urun');

                div.innerHTML = `
                    <p><strong>${item['başlık']}</strong></p>
                    <p>Fiyat: ${item['fiyat']} TL</p>
                    <p>Adet: 
                        <input type="number" value="${item.adet}" min="1" onchange="updateItem(${index}, this.value)">
                        <button onclick="removeItem(${index})" class='sepet-button'>Sil</button>
                    </p>
                    <hr>
                `;
                container.appendChild(div);
            });

            const button = document.createElement('button');
            button.classList.add('sepet-button');
            button.textContent = "Ödeme Sayfasına Git";
            button.onclick = () => window.location.href = "/Proje/ödeme.php";
            container.appendChild(button);
        })
        .catch(err => console.error("Sepet verileri alınamadı:", err));
}

function removeItem(index) {
    fetch('/Proje/sepet_veri.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'remove', index })
    }).then(fetchCartItems);
}

function updateItem(index, newQuantity) {
    if (newQuantity <= 0) {
        removeItem(index);
        return;
    }

    fetch('/Proje/sepet_veri.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ 
            action: 'update', 
            index, 
            adet: newQuantity 
        })
    }).then(fetchCartItems);
}
