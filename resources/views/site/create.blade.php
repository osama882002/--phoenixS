{{-- resources/views/site/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6">
        {{-- Header Banner --}}
        <div class="bg-indigo-100 dark:bg-indigo-900 border border-indigo-300 dark:border-indigo-700 text-indigo-800 dark:text-indigo-200 p-4 sm:p-6 rounded-lg shadow text-center mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold mb-2">✨ شارك قصتك أو وصفك الآن</h1>
            <p class="text-xs sm:text-sm dark:text-gray-300">
                اكتب لنا عن تجربتك أو أبدع بوصفة مميزة، وسنقوم بمراجعتها ونشرها قريبًا ❤️
            </p>
        </div>

        {{-- Form Container --}}
        <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-lg shadow">
            <h2 class="text-xl sm:text-2xl font-bold text-indigo-700 dark:text-indigo-300 mb-4 sm:mb-6">
                إضافة مقال جديد
            </h2>
            
            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                {{-- Username Field --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        اسم المستخدم
                    </label>
                    <input type="text" value="{{ auth()->user()->name }}" disabled
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200 text-xs sm:text-sm p-2">
                </div>

                {{-- Idea/Content Field --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        فكرة المقال / النص
                    </label>
                    <textarea name="idea" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200 text-xs sm:text-sm p-2">{{ old('idea') }}</textarea>
                    @error('idea')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category Field --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        القسم
                    </label>
                    <select name="category_id"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200 text-xs sm:text-sm p-2">
                        <option value="">اختر القسم</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="hidden" name="media_persisted" id="mediaPersisted">

                {{-- Media Upload --}}
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        تحميل صورة أو فيديو (اختياري)
                    </label>
                    <input type="file" name="media" accept="image/*,video/*"
                        class="mt-1 block w-full text-xs sm:text-sm text-gray-500 dark:text-gray-400 p-2 border rounded"
                        id="mediaInput">
                    <div id="mediaPreview" class="mt-4"></div>
                    @error('media')
                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="text-center pt-2">
                    <button type="submit"
                        class="bg-indigo-600 text-white px-6 sm:px-8 py-2 rounded-full text-sm sm:text-lg hover:bg-indigo-700 transition duration-200">
                        🚀 إرسال المقال
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('mediaInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('mediaPreview');
            preview.innerHTML = ''; // إفراغ المعاينة السابقة

            if (file) {
                const fileType = file.type;

                if (fileType.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.classList = "max-w-full sm:max-w-xs rounded shadow mx-auto";
                    preview.appendChild(img);
                } else if (fileType.startsWith('video/')) {
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.controls = true;
                    video.classList = "max-w-full sm:max-w-xs rounded shadow mx-auto";
                    preview.appendChild(video);
                } else {
                    preview.textContent = 'الملف غير مدعوم للمعاينة.';
                    preview.classList.add('text-red-500', 'text-xs', 'sm:text-sm');
                }
            }
        });
    </script>
@endsection