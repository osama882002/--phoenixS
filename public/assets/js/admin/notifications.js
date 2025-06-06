// public/js/admin/notifications.js

function deleteNotification(id) {
    // if (!confirm('هل أنت متأكد من حذف هذا الإشعار؟')) return;
    fetch('/admin/notifications/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('notification-' + id)?.remove();
            }
            window.showToast(data.message, data.success);
        })

        .catch(() => showToast('❌ فشل حذف الإشعار', false));
}

function showToast(message, success = true) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className =
        `fixed bottom-5 right-5 px-4 py-2 rounded shadow z-50 ${success ? 'bg-green-500' : 'bg-red-500'} text-white`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 2000);
}
