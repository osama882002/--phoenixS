// js/admin/notifications.js

// دالة حذف الإشعار
function deleteNotification(id) {
    if (!confirm('هل أنت متأكد من حذف هذا الإشعار؟')) return;

    fetch(`/admin/notifications/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const notificationElement = document.getElementById(`notification-${id}`);
            if (notificationElement) {
                notificationElement.style.transition = 'opacity 0.3s ease';
                notificationElement.style.opacity = '0';
                setTimeout(() => notificationElement.remove(), 300);
            }
        }
        window.showToast(data.message || '✅ تم حذف الإشعار بنجاح', data.success);
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('❌ فشل حذف الإشعار', false);
    });
}

// دالة تعليم الكل كمقروء (إذا كانت موجودة في الصفحة)
function markAllAsRead(event) {
    event.preventDefault();
    
    fetch(event.target.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelectorAll('.notification-item').forEach(item => {
                item.classList.add('opacity-60');
            });
        }
        window.showToast(data.message || '✅ تم تعليم جميع الإشعارات كمقروءة', data.success);
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('❌ فشل تحديث حالة الإشعارات', false);
    });
}

// دالة حذف الإشعارات المقروءة (إذا كانت موجودة في الصفحة)
function clearReadNotifications(event) {
    event.preventDefault();
    if (!confirm('هل أنت متأكد من حذف جميع الإشعارات المقروءة؟')) return;

    fetch(event.target.action, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelectorAll('.notification-item.opacity-60').forEach(item => {
                item.style.transition = 'opacity 0.3s ease';
                item.style.opacity = '0';
                setTimeout(() => item.remove(), 300);
            });
        }
        window.showToast(data.message || '✅ تم حذف الإشعارات المقروءة', data.success);
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast('❌ فشل حذف الإشعارات المقروءة', false);
    });
}

// تهيئة الصفحة عند التحميل
document.addEventListener('DOMContentLoaded', function() {
    // إضافة كلاس notification-item لكل إشعار
    document.querySelectorAll('[id^="notification-"]').forEach(item => {
        item.classList.add('notification-item');
    });

    // ربط أحداث النماذج إذا وجدت
    const readAllForm = document.querySelector('form[action*="notifications/readAll"]');
    const clearReadForm = document.querySelector('form[action*="notifications/clearRead"]');

    if (readAllForm) {
        readAllForm.addEventListener('submit', markAllAsRead);
    }

    if (clearReadForm) {
        clearReadForm.addEventListener('submit', clearReadNotifications);
    }

    // إزالة عنصر Toast المدمج إذا كان Toastr موجوداً
    if (typeof toastr !== 'undefined') {
        const builtInToast = document.getElementById('toast');
        if (builtInToast) builtInToast.remove();
    }
});