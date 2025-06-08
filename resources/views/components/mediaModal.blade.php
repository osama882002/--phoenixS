{{-- Lightbox Modal --}}
<div id="mediaModal"
     class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden overflow-hidden">
    <div class="relative w-full max-w-4xl p-4">
        <button onclick="closeMediaModal()"
                class="absolute top-2 left-2 text-white text-2xl font-bold z-50 hover:text-red-400">✕</button>
        <div id="mediaContainer"
             class="flex items-center justify-center bg-gray-900 rounded-lg max-h-[80vh]">
            {{-- يتم تعبئة الصورة أو الفيديو هنا --}}
        </div>
    </div>
</div>



{{-- Script --}}
<script src="{{ asset('assets/js/media/media-lightbox.js') }}"></script>
