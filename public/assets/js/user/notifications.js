// js/user/notifications.js

window.deleteNotification = function (id) {
    fetch('/notifications/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            removeNotificationElement(id);
            window.showToast('✅ تم حذف الإشعار بنجاح', true);
        } else {
            window.showToast('❌ حدث خطأ أثناء الحذف', false);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('❌ فشل الاتصال بالخادم', false);
    });
};

function removeNotificationElement(id) {
    const element = document.getElementById(`notification-${id}`);
    if (element) {
        element.style.transition = 'all 0.3s ease';
        element.style.opacity = '0';
        element.style.height = '0';
        element.style.margin = '0';
        element.style.padding = '0';
        setTimeout(() => element.remove(), 300);
    }
}