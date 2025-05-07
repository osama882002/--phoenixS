// public/js/admin/users.js
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
            showToast('تم حذف المستخدم بنجاح ✅');
            // إزالة الصف دون تحديث الصفحة
            document.querySelector(`tr[data-user-id="${userId}"]`)?.remove();
        } else {
            showToast(data.message || '❌ حدث خطأ، لم يتم الحذف.');
        }
    })
    .catch(error => {
        console.error(error);
        showToast('❌ فشل الاتصال بالخادم.');
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
            showToast('تم تحديث الدور بنجاح ✅');
        } else {
            showToast(data.message || '❌ حدث خطأ أثناء التحديث.');
            // إعادة تعيين القيمة السابقة
            if (selectElement) {
                const previousRole = selectElement.dataset.previousRole;
                selectElement.value = previousRole;
            }
        }
    })
    .catch(error => {
        console.error(error);
        showToast('❌ فشل الاتصال بالخادم.');
    })
    .finally(() => {
        if (selectElement) selectElement.disabled = false;
    });
}

// يمكن استيراد هذه الدالة من ملف مشترك لاحقًا
function showToast(message, isSuccess = true) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `fixed bottom-5 right-5 px-4 py-2 rounded hidden z-50 ${
        isSuccess ? 'bg-green-500' : 'bg-red-500'
    } text-white`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 2000);
}