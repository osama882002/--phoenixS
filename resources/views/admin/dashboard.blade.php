@extends('layouts.app')

@section('content')
<div class="flex flex-col md:flex-row min-h-screen">
    {{-- Sidebar --}}
    <x-admin.sidebar active="dashboard" />

    {{-- Main Content --}}
    <main class="flex-1 p-6 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
        {{-- العنوان --}}
        <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-8">📊 لوحة تحكم المشرف</h1>

        {{-- البطاقات --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-gradient-to-r from-green-100 to-green-50 dark:from-green-700 dark:to-green-800 p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
                <div class="text-4xl mb-2">👥</div>
                <h2 class="text-lg font-semibold">عدد المستخدمين</h2>
                <p class="text-3xl font-bold text-green-700 dark:text-green-300 mt-1">{{ $usersCount }}</p>
            </div>

            <div class="bg-gradient-to-r from-blue-100 to-blue-50 dark:from-blue-700 dark:to-blue-800 p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
                <div class="text-4xl mb-2">📚</div>
                <h2 class="text-lg font-semibold">إجمالي المقالات</h2>
                <p class="text-3xl font-bold text-blue-700 dark:text-blue-300 mt-1">{{ $postsCount }}</p>
            </div>

            <div class="bg-gradient-to-r from-red-100 to-red-50 dark:from-red-700 dark:to-red-800 p-6 rounded-xl shadow-lg flex flex-col items-center text-center">
                <div class="text-4xl mb-2">⏳</div>
                <h2 class="text-lg font-semibold">مقالات قيد المراجعة</h2>
                <p class="text-3xl font-bold text-red-700 dark:text-red-300 mt-1">{{ $pendingPosts }}</p>
            </div>
        </div>

        {{-- الرسوم البيانية --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-indigo-600 dark:text-indigo-300">🧾 حالة المقالات</h3>
                <canvas id="statusChart"></canvas>
            </div>

            <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-indigo-600 dark:text-indigo-300">📅 النشر خلال الأسبوع</h3>
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        {{-- أكثر مقال تفاعلاً --}}
        @if($topPost)
        <div class="bg-white dark:bg-gray-700 p-6 rounded-xl shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-indigo-600 dark:text-indigo-300">🔥 أكثر مقال تفاعلاً</h3>
            <div class="text-gray-700 dark:text-gray-200 space-y-2">
                <p><strong>المحتوى:</strong> {{ Str::limit($topPost->body, 200) }}</p>
                <p><strong>الإعجابات:</strong> {{ $topPost->likes_count }}</p>
                <p><strong>التعليقات:</strong> {{ $topPost->comments_count }}</p>
                <a href="{{ route('posts.show', $topPost->id) }}" class="inline-block mt-2 text-indigo-600 dark:text-indigo-400 hover:underline">👁️ عرض المقال</a>
            </div>
        </div>
        @endif
    </main>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const statusChart = new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['منشور', 'قيد المراجعة'],
            datasets: [{
                data: [{{ $postsByStatus['approved'] ?? 0 }}, {{ $postsByStatus['pending'] ?? 0 }}],
                backgroundColor: ['#10b981', '#f59e0b']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    const weeklyChart = new Chart(document.getElementById('weeklyChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($weeklyPosts->pluck('date')) !!},
            datasets: [{
                label: 'عدد المقالات',
                data: {!! json_encode($weeklyPosts->pluck('count')) !!},
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.3)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endsection
