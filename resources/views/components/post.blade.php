{{-- resources/views/components/post.blade.php --}}
<div class="bg-white p-4 rounded shadow mb-6">
    <h2 class="text-xl font-semibold mb-2">{{ $post->title }}</h2>
    <p class="text-sm text-gray-500 mb-1">بقلم {{ $post->user->name }} | {{ $post->created_at->diffForHumans() }}</p>
    <p class="mb-3 text-gray-700">{{ $post->body }}</p>

    @if($post->media_path)
        <div class="mb-3">
            @if(Str::endsWith($post->media_path, ['.mp4']))
                <video controls class="w-full rounded">
                    <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                </video>
            @else
                <img src="{{ asset('storage/' . $post->media_path) }}" alt="صورة المقال" class="rounded w-full">
            @endif
        </div>
    @endif

    <div class="flex items-center justify-between">
        <form action="{{ route('posts.like', $post) }}" method="POST">
            @csrf
            <button type="submit" class="text-sm text-indigo-600 hover:underline">
                ❤️ إعجاب ({{ $post->likes_count }})
            </button>
        </form>
    </div>

    <div class="mt-4">
        <h3 class="font-semibold mb-2">💬 التعليقات:</h3>
        @foreach($post->comments as $comment)
            <div class="border p-2 rounded mb-2 text-sm">
                <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->body }}</p>
            </div>
        @endforeach

        @auth
        <form action="{{ route('posts.comment', $post) }}" method="POST" class="mt-2">
            @csrf
            <textarea name="body" rows="2" class="w-full p-2 border rounded text-sm" placeholder="أضف تعليقًا..."></textarea>
            <button type="submit" class="mt-2 px-4 py-1 bg-indigo-600 text-white rounded text-sm">إرسال</button>
        </form>
        @endauth
    </div>
</div>
