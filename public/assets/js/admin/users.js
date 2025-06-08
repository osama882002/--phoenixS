// js/admin/users.js

// دالة حذف المستخدم
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
            window.showToast(data.message || '❌ حدث خطأ أثناء الحذف.', false);
        }
    })
    .catch(error => {
        console.error(error);
        window.showToast('❌ فشل الاتصال بالخادم.', false);
    });
}

// دالة تحديث دور المستخدم
function updateUserRole(userId, role) {
    const selectElement = document.querySelector(`select[data-user-id="${userId}"]`);
    if (!selectElement) return;

    // منع تعيين super-admin من الواجهة
    if (role === 'super-admin') {
        showToast('❌ لا يمكن تعيين مستخدم كسوبر أدمن من هذه الواجهة.', false);
        selectElement.value = selectElement.dataset.previousRole;
        return;
    }

    selectElement.disabled = true;

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
            showToast(data.message || '✅ تم تحديث الدور بنجاح', true);
            selectElement.dataset.previousRole = role;

            // تحديث خانة "خيارات"
            if (role === 'super-admin') {
                const optionsCell = document.querySelector(`tr[data-user-id="${userId}"] td:last-child`);
                if (optionsCell) {
                    optionsCell.innerHTML = `<span class="text-gray-400 dark:text-gray-500 text-sm">غير متاح</span>`;
                }
            }
        } else {
            showToast(data.message || '❌ حدث خطأ أثناء التحديث.', false);
            selectElement.value = selectElement.dataset.previousRole;
        }
    })
    .catch(error => {
        console.error(error);
        showToast('❌ فشل الاتصال بالخادم.', false);
        selectElement.value = selectElement.dataset.previousRole;
    })
    .finally(() => {
        selectElement.disabled = false;
    });
}

// دالة تصفية المستخدمين
function filterUsers() {
    const value = document.getElementById('userSearch').value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        const name = row.cells[1].textContent.toLowerCase();
        const email = row.cells[2].textContent.toLowerCase();
        row.style.display = (name.includes(value) || email.includes(value)) ? '' : 'none';
    });
}

// تهيئة العناصر عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    // إضافة سمة data-user-id لجميع عناصر select
    document.querySelectorAll('td select').forEach(select => {
        const userId = select.closest('tr').dataset.userId;
        select.dataset.userId = userId;
        select.dataset.previousRole = select.value;
    });

    // إزالة عنصر Toast المدمج إذا كان Toastr موجوداً
    if (typeof toastr !== 'undefined') {
        const builtInToast = document.getElementById('toast');
        if (builtInToast) builtInToast.remove();
    }
});