function getLocation() {
    console.log("جارٍ محاولة تحديد الموقع...");
    const weatherContainer = document.getElementById('weather-container');
    if (!navigator.geolocation) {
        showErrorMessage("المتصفح الخاص بك لا يدعم خدمة تحديد الموقع");
        return;
    }
    if (weatherContainer) {
        weatherContainer.innerHTML = `
            <div class="flex flex-col items-center justify-center p-4">
                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-blue-600 mb-3"></div>
                <p class="text-blue-800">جاري الحصول على بيانات الطقس...</p>
            </div>
        `;
    }
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            window.location.href = "/weather-tips?lat=" + lat + "&lon=" + lon;
        },
        function(error) {
            let errorMessage = "حدث خطأ أثناء تحديد الموقع";
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage = "يرجى تمكين الوصول إلى الموقع.";
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage = "بيانات الموقع غير متاحة حالياً.";
                    break;
                case error.TIMEOUT:
                    errorMessage = "انتهاء وقت الطلب للحصول على الموقع.";
                    break;
                default:
                    errorMessage = "فشل في تحديد الموقع.";
            }
            if (weatherContainer) {
                weatherContainer.innerHTML = `
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4">
                        <p>${errorMessage}</p>
                        <button onclick="getLocation()" class="mt-2 bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700">
                            حاول مرة أخرى
                        </button>
                    </div>
                `;
            } else {
                alert(errorMessage);
            }
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

function showErrorMessage(message) {
    const weatherContainer = document.getElementById('weather-container');
    if (weatherContainer) {
        weatherContainer.innerHTML = `
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4">
                <p>${message}</p>
                <button onclick="getLocation()" class="mt-2 bg-yellow-600 text-white px-3 py-1 rounded text-sm hover:bg-yellow-700">
                    حاول مرة أخرى
                </button>
            </div>
        `;
    } else {
        alert(message);
    }
}
