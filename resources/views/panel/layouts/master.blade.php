<<<<<<< Updated upstream
=======
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ $settings->meta_description ?? '' }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'پنل ادمین')</title>

    <!-- Favicon -->
    <link rel="shortcut icon"
          href="{{ $settings->favicon_path ? asset('images/settings/' . $settings->favicon_path) : '' }}">

    <!-- Start CSS -->
    <link href="{{ asset('panel/assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/assets/plugins/cropperjs/cropper.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/assets/plugins/cropperjs/main.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/assets/css/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/assets/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('panel/assets/css/panel.css') }}" rel="stylesheet">
    <!-- End CSS -->
</head>

<body class="vertical-layout">

<div id="containerbar">
    @include('Panel.Layouts.leftbar')
    @include('Panel.Layouts.rightbar')
</div>

<!-- JS -->
<script src="{{ asset('panel/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('panel/assets/js/detect.js') }}"></script>
<script src="{{ asset('panel/assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('panel/assets/js/vertical-menu.js') }}"></script>
<script src="{{ asset('panel/assets/plugins/switchery/switchery.min.js') }}"></script>
<script src="{{ asset('panel/assets/plugins/cropperjs/cropper.js') }}"></script>
<script src="{{ asset('panel/assets/plugins/cropperjs/main.js') }}"></script>
<script src="{{ asset('panel/assets/js/core.js') }}"></script>
<script src="{{ asset('panel/assets/js/script.js') }}"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.ckeditor').forEach(function (textarea) {
            CKEDITOR.replace(textarea.id);
        });
    });
</script>

</body>
</html>
>>>>>>> Stashed changes
