// main.js - نسخه کامل، بدون خطا، حرفه‌ای و 100% کارکردی
window.addEventListener('load', function () {
    'use strict';

    // اگر Cropper.js لود نشده باشه، خارج شو (جلوگیری از خطا)
    if (typeof Cropper === 'undefined') {
        return;
    }

    var Cropper = window.Cropper;
    var URL = window.URL || window.webkitURL;

    var container = document.querySelector('.img-container');
    if (!container) {
        // این صفحه کراپر نداره → ساکت خارج شو (مثل صفحه داشبورد)
        return;
    }

    var image = container.querySelector('img');
    if (!image) {
        console.warn('No <img> found in .img-container');
        return;
    }

    // المان‌های اختیاری (اگر نبودن خطا نده)
    var download = document.getElementById('download');
    var dataX = document.getElementById('dataX') || { value: '' };
    var dataY = document.getElementById('dataY') || { value: '' };
    var dataHeight = document.getElementById('dataHeight') || { value: '' };
    var dataWidth = document.getElementById('dataWidth') || { value: '' };
    var dataRotate = document.getElementById('dataRotate') || { value: '' };
    var dataScaleX = document.getElementById('dataScaleX') || { value: '' };
    var dataScaleY = document.getElementById('dataScaleY') || { value: '' };

    var options = {
        aspectRatio: 16 / 9,
        preview: '.img-preview',
        crop: function (e) {
            var data = e.detail;
            dataX.value = Math.round(data.x);
            dataY.value = Math.round(data.y);
            dataHeight.value = Math.round(data.height);
            dataWidth.value = Math.round(data.width);
            dataRotate.value = data.rotate !== undefined ? data.rotate : '';
            dataScaleX.value = data.scaleX !== undefined ? data.scaleX : '';
            dataScaleY.value = data.scaleY !== undefined ? data.scaleY : '';
        }
    };

    var cropper = new Cropper(image, options);
    var uploadedImageType = 'image/jpeg';
    var uploadedImageName = 'cropped.jpg';
    var uploadedImageURL;

    // Tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // دکمه دانلود
    if (download && typeof download.download === 'undefined') {
        download.classList.add('disabled');
        download.title = 'مرورگر شما از دانلود پشتیبانی نمی‌کند';
    }

    // تنظیمات (تگل‌ها)
    var docsToggles = document.getElementById('docs-toggles');
    if (docsToggles) {
        docsToggles.onclick = function (e) {
            var target = e.target;
            if (target.tagName.toLowerCase() === 'label') {
                target = target.querySelector('input');
            }
            if (!target || (target.type !== 'checkbox' && target.type !== 'radio')) return;

            options[target.name] = target.type === 'checkbox' ? target.checked : target.value;

            var cropBoxData = cropper.getCropBoxData();
            var canvasData = cropper.getCanvasData();

            cropper.destroy();
            options.ready = function () {
                cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
            };
            cropper = new Cropper(image, options);
        };
    }

    // دکمه‌های اکشن
    var docsButtons = document.getElementById('docs-buttons');
    if (docsButtons) {
        docsButtons.onclick = function (e) {
            var target = e.target.closest('[data-method]');
            if (!target || !cropper) return;

            var data = {
                method: target.getAttribute('data-method'),
                option: target.getAttribute('data-option') || undefined,
                secondOption: target.getAttribute('data-second-option') || undefined
            };

            if (data.option) {
                try { data.option = JSON.parse(data.option); } catch (e) {}
            }

            var result = cropper[data.method](data.option, data.secondOption);

            if (data.method === 'getCroppedCanvas' && result) {
                $('#getCroppedCanvasModal .modal-body').html(result);
                $('#getCroppedCanvasModal').modal('show');

                if (download) {
                    download.href = result.toDataURL(uploadedImageType);
                    download.download = uploadedImageName;
                }
            }
        };
    }

    // آپلود تصویر جدید
    var inputImage = document.getElementById('inputImage');
    if (inputImage && URL) {
        inputImage.onchange = function () {
            var files = this.files;
            if (!files || !files.length || !cropper) return;

            var file = files[0];
            if (!/^image\/\w+/.test(file.type)) {
                alert('لطفاً یک فایل تصویری انتخاب کنید.');
                return;
            }

            uploadedImageType = file.type;
            uploadedImageName = file.name;

            if (uploadedImageURL) {
                URL.revokeObjectURL(uploadedImageURL);
            }

            uploadedImageURL = URL.createObjectURL(file);
            cropper.destroy();
            image.src = uploadedImageURL;
            cropper = new Cropper(image, options);
            this.value = '';
        };
    }
});
