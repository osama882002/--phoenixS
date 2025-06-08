// js/posts/error-image.js

document.addEventListener('DOMContentLoaded', function () {
    const mediaInput = document.querySelector('input[name="media"]');
    if (mediaInput) {
        mediaInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file && file.size > 50 * 1024 * 1024) { // 50MB
                toastr.error("⚠️ حجم الملف كبير جدًا. الحد الأقصى المسموح هو 50 ميغابايت.");
                this.value = ""; // يمسح الملف من الحقل
            }
        });
    }
});