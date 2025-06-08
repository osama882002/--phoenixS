// resources/js/app.js

import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();



/**
 * دالة عالمية لإظهار التنبيهات
 * @param {string} message
 * @param {boolean} isSuccess
 */

// إعدادات Toastr

window.showToast = function(message, isSuccess = true) {
    if (typeof toastr !== 'undefined') {
        const isRTL = document.documentElement.getAttribute('dir') === 'rtl';
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: isRTL ? "toast-top-left" : "toast-top-right",
            timeOut: 3000,
            rtl: isRTL
        };
        isSuccess ? toastr.success(message) : toastr.error(message);
    } else {
        alert(message);
    }
};

