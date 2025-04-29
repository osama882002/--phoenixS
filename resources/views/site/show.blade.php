@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white rounded-xl shadow">

    {{-- عنوان المقال --}}
    <h1 class="text-3xl font-bold text-indigo-700 mb-4">{{ $post->title }}</h1>

    {{-- معلومات إضافية --}}
    <p class="text-sm text-gray-600 mb-2">
        بواسطة: {{ $post->user->name }} |
        القسم: {{ $post->category->name }} |
        منذ: {{ $post->created_at->diffForHumans() }}
    </p>

    {{-- عرض صورة أو فيديو --}}
    @if ($post->media_path)
        <div class="my-6">
            @if(Str::endsWith($post->media_path, ['.mp4']))
                <video controls class="w-full rounded-lg shadow">
                    <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                </video>
            @else
                <img src="{{ asset('storage/' . $post->media_path) }}" class="w-full rounded-lg shadow object-contain" alt="media">
            @endif
        </div>
    @endif

    {{-- نص المقال الكامل --}}
    <div class="text-gray-800 leading-relaxed mb-8 whitespace-pre-line">
        {{ $post->body }}
    </div>

    {{-- التفاعل (إعجاب، عدد التعليقات) --}}
    <div class="flex gap-6 items-center text-sm text-gray-600 mb-8">
        <form method="POST" action="{{ route('posts.like', $post) }}">
            @csrf
            <button type="submit" class="hover:text-red-500">
                {!! $post->likes->contains(auth()->id()) ? '💔 إلغاء الإعجاب' : '❤️ أعجبني' !!}
                ({{ $post->likes()->count() }})
            </button>
        </form>

        <span>💬 التعليقات ({{ $post->comments()->count() }})</span>
    </div>

    {{-- التعليقات --}}
    <div class="bg-gray-50 p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">💬 التعليقات</h3>

        {{-- نموذج إضافة تعليق --}}
        @auth
            <form action="{{ route('posts.comment', $post) }}" method="POST" class="mb-6">
                @csrf
                <textarea name="body" rows="2" class="w-full border rounded p-2 text-sm" placeholder="اكتب تعليقك..." required></textarea>
                <button type="submit" class="mt-2 bg-indigo-600 text-white px-4 py-1 rounded hover:bg-indigo-700 text-sm">
                    إرسال التعليق
                </button>
            </form>
        @endauth

        {{-- عرض التعليقات --}}
        @if ($post->topLevelComments->count())
            @foreach ($post->topLevelComments as $index => $comment)
                <div class="mb-4 pb-2 border-b border-gray-300 {{ $index >= 3 ? 'hidden comment-item' : '' }}">
                    <p class="text-gray-800 text-sm">{{ $comment->body }}</p>
                    <span class="text-xs text-gray-500">
                        بواسطة {{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}
                    </span>

                    {{-- الردود --}}
                    @if ($comment->replies->count())
                        <div class="ml-4 mt-2 pl-4 border-l-2 border-blue-300">
                            @foreach ($comment->replies as $reply)
                                <div class="bg-blue-50 p-2 rounded shadow-inner mb-2">
                                    <p class="text-sm text-blue-800">🔁 {{ $reply->body }}</p>
                                    <span class="text-xs text-gray-500">بواسطة {{ $reply->user->name }} - {{ $reply->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            @if($post->topLevelComments->count() > 3)
                <div class="text-center mt-4">
                    <button onclick="showAllComments()" id="show-more-btn" class="text-indigo-600 hover:underline text-sm">
                        🔽 عرض المزيد
                    </button>
                </div>
            @endif
        @else
            <div class="text-gray-500 text-sm">
                لا توجد تعليقات بعد.
            </div>
        @endif
    </div>

    {{-- العودة --}}
    <div class="mt-6 text-center">
        <a href="{{ route('home') }}" class="text-indigo-600 hover:underline text-sm">
            ⬅️ العودة للصفحة الرئيسية
        </a>
    </div>
</div>

<script>
    function showAllComments() {
        document.querySelectorAll('.comment-item').forEach(el => el.classList.remove('hidden'));
        document.getElementById('show-more-btn').remove();
    }
</script>
@endsection
