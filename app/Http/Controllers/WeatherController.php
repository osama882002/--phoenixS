<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Post;

class WeatherController extends Controller
{
    public function showWeatherTips(Request $request)
    {
        // dd('✅ دالة showWeatherTips يتم تنفيذها فعلاً');
        $weather = null;
        $weatherError = false;
        $posts = [];
    
        try {
            $posts = Post::where('status', 'approved')->latest()->take(3)->get();
        } catch (\Exception $e) {
            Log::warning('فشل في جلب المقالات:', ['error' => $e->getMessage()]);
        }
    
        if ($request->has(['lat', 'lon'])) {
            try {
                $lat = $request->input('lat');
                $lon = $request->input('lon');
                $weather = $this->fetchWeatherData($lat, $lon);
            } catch (\Exception $e) {
                Log::error('فشل في جلب بيانات الطقس:', ['message' => $e->getMessage()]);
                $weatherError = true;
            }
        }
    
        // تمرير كل المتغيرات دائمًا
        return view('site.weather-tips')->with([
            'weather' => $weather,
            'weatherError' => $weatherError,
            'posts' => $posts,
        ]);
    }
    
    
    


    private function fetchWeatherData($lat, $lon)
    {
        $apiKey = env('OPENWEATHERMAP_API_KEY');

        if (!$apiKey) {
            throw new \Exception('مفتاح OpenWeatherMap غير مُعرّف في ملف .env');
        }

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'ar'
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // اختياري: التحقق من وجود بعض الحقول المهمة
            if (!isset($data['main']['temp']) || !isset($data['weather'][0]['main'])) {
                throw new \Exception('بيانات الطقس غير مكتملة أو غير متوقعة');
            }

            return $data;
        }

        throw new \Exception('فشل في جلب بيانات الطقس من OpenWeatherMap. كود الاستجابة: ' . $response->status());
    }

    public function index()
    {
        return response()->json(['message' => 'استخدم /weather-tips مع الموقع']);
    }
}
