


document.addEventListener('DOMContentLoaded', function() {
    updateNotification();

    var observerCallback = function(mutationsList, observer) {
        for(var mutation of mutationsList) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'data-success') {
                updateNotification();
            }
        }
    };

    var observerConfig = {
        attributes: true,
        attributeFilter: ['data-success'],
        subtree: true
    };

    var targetNode = document.getElementById('notification-messages');
    var observer = new MutationObserver(observerCallback);
    observer.observe(targetNode, observerConfig);

    function updateNotification() {
        const messagesContainer = document.getElementById('notification-messages');
        const successMessage = messagesContainer.getAttribute('data-success');
        const errorMessage = messagesContainer.getAttribute('data-error');
        
        // Varolan bildirimleri temizle
        const existingAlerts = document.querySelectorAll('.dynamic-alert');
        existingAlerts.forEach(function(alert) {
            alert.remove();
        });

        let alertClass = '';
        let message = '';
        let iconHtml = '';

        if (successMessage) {
            alertClass = 'alert-success t';
            message = `<strong>Başarılı!</strong> ${successMessage}`;
            iconHtml = '<i class="fas fa-check-circle"></i>';
        } else if (errorMessage) {
            alertClass = 'alert-danger';
            message = `<strong>Hata!</strong> ${errorMessage}`;
            iconHtml = '<i class="fas fa-exclamation-circle"></i>';
        }

        if (message) {
            const notification = document.createElement('div');
            notification.className = `alert ${alertClass} alert-dismissible text-white fade show dynamic-alert fixed-top custom-right`;
            notification.setAttribute('role', 'alert');
            notification.innerHTML = `
                <span class="alert-icon align-middle">${iconHtml}</span>
                <span class="alert-text">${message}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            `;

            document.body.appendChild(notification);

            // 2 saniye sonra bildirimi gizle
            setTimeout(function() {
                notification.remove();
            }, 2000);
        }
    }
});

