function deleteUser(userId) {
    if (!confirm('هل تريد بالتأكيد حذف هذا المستخدم؟')) return;

    fetch(`/admin/users/${userId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('✅ تم حذف المستخدم بنجاح', true);
            document.querySelector(`tr[data-user-id="${userId}"]`)?.remove();
        } else {
            window.showToast(data.message || '❌ حدث خطأ، لم يتم الحذف.', false);
        }
    })
    .catch(error => {
        console.error(error);
        window.showToast('❌ فشل الاتصال بالخادم.', false);
    });
}

function updateUserRole(userId, role) {
    const selectElement = document.querySelector(`select[data-user-id="${userId}"]`);
    if (selectElement) selectElement.disabled = true;

    fetch(`/admin/users/${userId}/role`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ role })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.showToast('✅ تم تحديث الدور بنجاح', true);
        } else {
            window.showToast(data.message || '❌ حدث خطأ أثناء التحديث.', false);
            if (selectElement) {
                const previousRole = selectElement.dataset.previousRole;
                selectElement.value = previousRole;
            }
        }
    })
    .catch(error => {
        console.error(error);
        window.showToast('❌ فشل الاتصال بالخادم.', false);
    })
    .finally(() => {
        if (selectElement) selectElement.disabled = false;
    });
}
