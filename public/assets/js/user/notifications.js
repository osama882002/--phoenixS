window.deleteNotification = function (id) {
    // if (!confirm('هل أنت متأكد من حذف هذا الإشعار؟')) return;

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

window.showToast = function (message, isSuccess) {
    const toast = document.getElementById('toast');
    if (!toast) return;

    toast.textContent = message;
    toast.className = `fixed bottom-5 right-5 px-4 py-2 rounded shadow-lg z-50 ${isSuccess ? 'bg-green-600' : 'bg-red-600'} text-white transition-opacity duration-500`;

    toast.classList.remove('hidden', 'opacity-0');
    toast.classList.add('opacity-100');

    setTimeout(() => {
        toast.classList.add('opacity-0');
        setTimeout(() => toast.classList.add('hidden'), 500);
    }, 2000);
};
