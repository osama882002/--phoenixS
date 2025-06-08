// js/posts/post-interactions.js

// دالة لعرض/إخفاء التعليقات
function toggleComments(postId) {
    const el = document.getElementById('comments-' + postId);
    if (el) {
        el.classList.toggle('hidden');
    }
}

// دالة لتوسيع التعليقات
function toggleCommentsExpand(postId) {
    const items = document.querySelectorAll('.comment-item-' + postId);
    const loadMoreBtn = document.getElementById('load-more-btn-' + postId);
    const collapseBtn = document.getElementById('collapse-comments-btn-' + postId);

    let hiddenItems = 0;
    items.forEach(item => {
        if (item.classList.contains('hidden')) {
            item.classList.remove('hidden');
            hiddenItems++;
        }
    });

    if (hiddenItems === 0) {
        loadMoreBtn.classList.add('hidden');
    } else {
        collapseBtn.classList.remove('hidden');
    }
}

// دالة لطي التعليقات
function collapseComments(postId) {
    const items = document.querySelectorAll('.comment-item-' + postId);
    const loadMoreBtn = document.getElementById('load-more-btn-' + postId);
    const collapseBtn = document.getElementById('collapse-comments-btn-' + postId);

    items.forEach((item, index) => {
        if (index > 2) {
            item.classList.add('hidden');
        }
    });

    collapseBtn.classList.add('hidden');
    loadMoreBtn.classList.remove('hidden');
}

// دالة الإعجاب
function toggleLike(postId) {
    fetch('/posts/' + postId + '/like', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        const likeButton = document.getElementById('like-button-' + postId);
        const likeCount = document.getElementById('like-count-' + postId);

        likeButton.innerHTML = (data.liked ? '💔 إلغاء الإعجاب' : '❤️ أعجبني') +
            ` (<span id="like-count-${postId}">${data.likes_count}</span>)`;

        window.showToast(data.liked ? '✅ تم تسجيل الإعجاب' : '❌ تم إلغاء الإعجاب', true);
    })
    .catch(error => {
        console.error(error);
        window.showToast('❌ حدث خطأ أثناء تسجيل الإعجاب', false);
    });
}

// دالة إضافة تعليق
async function submitComment(event, postId) {
    event.preventDefault();

    const body = document.getElementById('comment-body-' + postId).value;
    const token = document.querySelector('meta[name="csrf-token"]').content;

    try {
        const response = await fetch(`/posts/${postId}/comment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ body })
        });

        const result = await response.json();

        const commentsContainer = document.getElementById('comments-container-' + postId);
        const newComment = document.createElement('div');
        newComment.className = `mb-4 border-b pb-3 border-gray-200 comment-item-${postId}`;
        newComment.setAttribute('data-comment-id', result.comment_id);
        newComment.innerHTML = `
            <p class="text-sm text-gray-800">${result.body}</p>
            <span class="text-xs text-gray-500">بواسطة ${result.user_name} - قبل لحظات</span>
            ${result.can_delete ? `<button onclick="deleteComment(event, '${result.comment_id}', '${postId}')" class="text-xs text-red-600 hover:underline ml-2">🗑️ حذف</button>` : ''}
        `;

        commentsContainer.prepend(newComment);
        updateCommentsCounter(postId, 1);
        document.getElementById('comment-body-' + postId).value = '';

        window.showToast('✅ تم إضافة التعليق بنجاح', true);
    } catch (error) {
        console.error(error);
        window.showToast('❌ حدث خطأ أثناء إضافة التعليق', false);
    }
}

// دالة حذف تعليق
async function deleteComment(event, commentId, postId) {
    const deleteButton = event.target;
    deleteButton.disabled = true;
    deleteButton.textContent = 'جاري الحذف...';

    try {
        const response = await fetch('/comments/' + commentId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();

        if (!result.success) {
            window.showToast(result.message || '❌ فشل حذف التعليق', false);
            return;
        }

        const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
        if (commentElement) {
            commentElement.style.transition = 'all 0.3s';
            commentElement.style.opacity = '0';
            commentElement.style.height = '0';
            commentElement.style.margin = '0';
            commentElement.style.padding = '0';

            setTimeout(() => {
                commentElement.remove();
                updateCommentsCounter(postId, -1);
                checkIfCommentsEmpty(postId);
            }, 300);
        }

        window.showToast(result.message || '✅ تم حذف التعليق بنجاح', true);
    } catch (error) {
        console.error('Error:', error);
        window.showToast('❌ حدث خطأ أثناء حذف التعليق', false);
    } finally {
        deleteButton.disabled = false;
        deleteButton.textContent = '🗑️ حذف';
    }
}

// تحديث العداد
function updateCommentsCounter(postId, change) {
    const commentsLink = document.querySelector(`#post-${postId} a[onclick*="toggleComments(${postId})"]`);
    if (commentsLink) {
        const currentText = commentsLink.textContent;
        const countMatch = currentText.match(/\((\d+)\)/);
        if (countMatch) {
            const newCount = parseInt(countMatch[1]) + change;
            commentsLink.textContent = currentText.replace(/\(\d+\)/, `(${newCount})`);
        }
    }
}

// مشاركة المقال
function sharePost(title, url) {
    if (navigator.share) {
        navigator.share({ title: title, url: url }).catch(err => {
            console.error('Error sharing:', err);
            window.showToast('❌ فشل مشاركة الرابط', false);
        });
    } else {
        const input = document.createElement('input');
        input.value = url;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        window.showToast('✅ تم نسخ رابط المقال!', true);
    }
}

// التحقق من وجود تعليقات
function checkIfCommentsEmpty(postId) {
    const commentsContainer = document.getElementById(`comments-container-${postId}`);
    if (commentsContainer && commentsContainer.children.length === 0) {
        document.getElementById(`comments-${postId}`).classList.add('hidden');
    }
}