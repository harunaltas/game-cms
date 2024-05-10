document.addEventListener('DOMContentLoaded', function() {
    updateNotification();

    // Notification güncelleme fonksiyonunu tetikleme
// MutationObserver için callback fonksiyonu
var observerCallback = function(mutationsList, observer) {
    mutationsList.forEach(function(mutation) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'data-success') {
            updateNotification();
        }
    });
};

// MutationObserver konfigürasyonu
var observerConfig = {
    attributes: true, // attribute değişikliklerini izle
    attributeFilter: ['data-success'], // sadece 'data-success' attribute değişikliklerini izle
    subtree: true // hedef elementin altındaki tüm elementlerdeki değişiklikleri izle
};

// Hedef element için MutationObserver'ı başlat
var targetNode = document.getElementById('notification-messages');
var observer = new MutationObserver(observerCallback);
observer.observe(targetNode, observerConfig);

    function updateNotification() {
        const messagesContainer = document.getElementById('notification-messages');
        const successMessage = messagesContainer.getAttribute('data-success');
        const errorMessage = messagesContainer.getAttribute('data-error');
        const notification = document.createElement('div');
            
        // Stil ayarlamaları ve gösterme işlemi devam eder...
        notification.style.display = 'none'; // Başlangıçta gizle
        notification.style.position = 'fixed';
        notification.style.left = '50%';
        notification.style.top = '20px'; // Ekranın çok üstünde olmaması için
        notification.style.transform = 'translateX(-50%)';
        notification.style.padding = '15px';
        notification.style.borderRadius = '5px';
        notification.style.zIndex = '1000'; // Diğer içeriklerin üzerinde görünsün
        notification.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)'; // Box shadow ekleyin
        notification.style.border = '1px solid transparent'; // Varsayılan çerçeve

        // Başarı mesajı varsa
        if (successMessage) {
            notification.style.backgroundColor = '#fff';
            notification.style.color = 'green';
            notification.innerText = successMessage;
            document.body.appendChild(notification);
            notification.style.display = 'block';
        }

        // Hata mesajı varsa
        if (errorMessage) {
            notification.style.backgroundColor = '#fff';
            notification.style.color = 'red';
            notification.style.border = '1px solid red';
            notification.innerText = errorMessage;
            document.body.appendChild(notification);
            notification.style.display = 'block';
        }

        // 2 saniye sonra bildirimi gizle
        if (notification.style.display === 'block') {
            setTimeout(function() {
                notification.style.display = 'none';
            }, 2000);
        }
    }
});
