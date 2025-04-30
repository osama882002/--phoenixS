{{-- (resources/views/components/post-card.blade.php) --}}
<div class="bg-white p-4 rounded-xl shadow mb-6" id="post-{{ $post->id }}">
    
    {{-- تفاصيل المقال --}}
    <div class="col-span-4 flex flex-col justify-between space-y-3">
    <h2 class="text-xl font-bold text-indigo-700">{{ $post->title }}</h2>

    <p class="text-sm text-gray-600 mt-1">
        بواسطة: {{ $post->user->name }} | القسم: {{ $post->category->name }} | {{ $post->created_at->diffForHumans() }}
    </p>

    {{-- <p class="mt-3 text-gray-800">{{ Str::limit($post->body, 200) }}</p> --}}
    @if (!empty($showStatus) && isset($post->status))
        <p class="text-sm mt-2 font-medium">
            الحالة:
            @switch($post->status)
                @case('approved')
                    <span class="text-green-600">منشور ✅</span>
                @break

                @case('pending')
                    <span class="text-yellow-600">قيد المراجعة ⏳</span>
                @break

                @case('rejected')
                    <span class="text-red-600">مرفوض ❌</span>
                @break

                @default
                    <span class="text-gray-600">غير معروف</span>
            @endswitch
        </p>
    @endif
    </div>
    {{-- صورة الوسائط --}}
    <div class="col-span-1 flex justify-center">
            @if ($post->media_path)
                <div class="mt-4 flex justify-center">
                    @if (Str::endsWith($post->media_path, ['.mp4']))
                        <video controls class="rounded-lg shadow w-[200px] h-[200px] object-cover">
                            <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                        </video>
                    @else
                    <img src="{{ asset('storage/' . $post->media_path) }}" alt="media"
                    class="rounded-lg shadow w-[200px] h-[200px] object-cover" />
                    @endif
                </div>
            
            @else
                    <div class="w-[200px] h-[200px] bg-gray-100 rounded shadow flex items-center justify-center text-gray-400 text-sm">
                        لا توجد صورة
                    </div>
            @endif
    </div>
    @if ($post->status === 'approved')
        <div class="mt-4 flex gap-6 items-center text-sm text-gray-600">
            <div class="flex items-center gap-1 cursor-pointer hover:text-red-500"
                onclick="toggleLike({{ $post->id }})" id="like-button-{{ $post->id }}">
                {!! $post->likes->contains(auth()->id()) ? '💔 إلغاء الإعجاب' : '❤️ أعجبني' !!}
                (<span id="like-count-{{ $post->id }}">{{ $post->likes_count ?? $post->likes()->count() }}</span>)
            </div>

            <a href="javascript:void(0);" onclick="toggleComments({{ $post->id }})" class="hover:underline">
                💬 التعليقات ({{ $post->topLevelComments->count() }})
            </a>
        </div>

        @auth
            @if (auth()->user()->unreadNotifications->where('data.post_id', $post->id)->count())
                <div class="mt-2 text-xs text-green-600">📌 لديك تفاعل جديد على هذا المقال</div>
            @endif

            <form onsubmit="submitComment(event, {{ $post->id }})" class="mt-4"
                id="comment-form-{{ $post->id }}">
                @csrf
                <textarea id="comment-body-{{ $post->id }}" rows="2" class="w-full border rounded p-2 text-sm"
                    placeholder="اكتب تعليقك..." required></textarea>
                <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-1 rounded text-sm hover:bg-indigo-700">
                    إرسال التعليق
                </button>
            </form>
        @endauth
    @endif
    
        <div class="mt-6 bg-gray-50 p-4 rounded shadow-sm hidden" id="comments-{{ $post->id }}">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">💬 التعليقات:</h3>

            <div id="comments-container-{{ $post->id }}" class="space-y-4">
                @foreach ($post->topLevelComments as $index => $comment)
        <div class="comment-item-{{ $post->id }} {{ $index > 2 ? 'hidden' : '' }}">
            <div class="mb-4 border-b pb-3 border-gray-200" data-comment-id="{{ $comment->id }}">
                <p class="text-sm text-gray-800">{{ $comment->body }}</p>
                <span class="text-xs text-gray-500">بواسطة {{ $comment->user->name }} -
                    {{ $comment->created_at->diffForHumans() }}</span>
                @can('delete', $comment)
                    <button onclick="deleteComment('{{ $comment->id }}', '{{ $post->id }}')" 
                        class="text-xs text-red-600 hover:underline ml-2">🗑️ حذف</button>
                @endcan
            </div>
        </div>
                @endforeach
        </div>

        @if ($post->topLevelComments->count() > 3)
            <div class="mt-2 text-center">
                <button id="load-more-btn-{{ $post->id }}" onclick="toggleCommentsExpand({{ $post->id }})"
                    class="text-indigo-600 hover:underline text-sm">
                    🔽 عرض المزيد
                </button>

                <button id="collapse-comments-btn-{{ $post->id }}" onclick="collapseComments({{ $post->id }})"
                    class="text-indigo-600 hover:underline text-sm hidden">
                    🔼 إخفاء التعليقات
                </button>
            </div>
        @endif
    </div>

    @if (!empty($showActions))
        <div class="flex gap-3 mt-4">
            <a href="{{ route('posts.edit', $post) }}" class="text-sm text-indigo-600 hover:underline">تعديل</a>
            <form action="{{ route('posts.destroy', $post) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm text-red-600 hover:underline">حذف</button>
            </form>
        </div>
    @endif
</div>
<script>
    function toggleComments(postId) {
        const el = document.getElementById('comments-' + postId);
        if (el) {
            el.classList.toggle('hidden');
        }
    }

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

    function toggleLike(postId) {
        fetch('/posts/' + postId + '/like', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                const likeButton = document.getElementById('like-button-' + postId);
                const likeCount = document.getElementById('like-count-' + postId);
                likeButton.innerHTML = (data.liked ? '💔 إلغاء الإعجاب' : '❤️ أعجبني') +
                    ` (<span id="like-count-${postId}">${data.likes_count}</span>)`;
            })
            .catch(error => console.error(error));
    }

    async function submitComment(event, postId) {
        event.preventDefault();

        const body = document.getElementById('comment-body-' + postId).value;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
            newComment.setAttribute('data-id', result.comment_id);
            newComment.innerHTML = `
                <p class="text-sm text-gray-800">${result.body}</p>
                <span class="text-xs text-gray-500">بواسطة ${result.user_name} - قبل لحظات</span>
                ${result.can_delete ? `<button onclick="deleteComment('${result.comment_id}')" class="text-xs text-red-600 hover:underline ml-2">🗑️ حذف</button>` : ''}
            `;

            commentsContainer.prepend(newComment);

            // تحديث العداد
            const countSpan = document.querySelector(`#post-${postId} a[href="javascript:void(0);"]`);
            if (countSpan) {
                const match = countSpan.textContent.match(/\d+/);
                let count = match ? parseInt(match[0]) : 0;
                count++;
                countSpan.innerHTML = `💬 التعليقات (${count})`;
            }

            document.getElementById('comment-body-' + postId).value = '';
        } catch (error) {
            console.error(error);
        }
    }

    function deleteComment(commentId, postId) {
        // if (!confirm('هل أنت متأكد من حذف هذا التعليق؟')) return;

        fetch('/comments/' + commentId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error();
            
            // 1. حذف التعليق من الواجهة
            const commentElement = document.querySelector(`[data-id="${commentId}"]`);
            if (commentElement) {
                commentElement.closest('.comment-item-' + postId).remove();
            }
            
            // 2. تحديث عداد التعليقات
            const commentsCountElement = document.querySelector(`#post-${postId} a[onclick="toggleComments(${postId})"]`);
            if (commentsCountElement) {
                const currentCount = parseInt(commentsCountElement.textContent.match(/\d+/)[0]);
                commentsCountElement.textContent = `💬 التعليقات (${currentCount - 1})`;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            window.location.reload();
            // alert('حدث خطأ أثناء حذف التعليق');
        });
    }
</script>