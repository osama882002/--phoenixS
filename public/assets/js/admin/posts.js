// public/js/admin/posts.js
function deletePost(postId) {
    if (!confirm('هل تريد بالتأكيد حذف هذا المقال؟')) return;

    fetch(`/admin/posts/${postId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`tr[data-post-id="${postId}"]`)?.remove();
            }
            window.showToast(data.message, data.success);
        })

        .catch(error => {
            console.error(error);
            showToast('❌ فشل الحذف.');
        });
}

function showToast(message) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 2000);
}