// تأكد من تحميل Toastr أولًا في layout (قبل هذا الملف)
window.showToast = function (message, isSuccess = true) {
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            positionClass: 'toast-top-left',
            timeOut: 3000
        };
        isSuccess ? toastr.success(message) : toastr.error(message);
    } else {
        alert(message);
    }
};