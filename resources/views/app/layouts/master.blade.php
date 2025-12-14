<!DOCTYPE html>
<html lang="{{ $settings->default_language ?? 'fa' }}" dir="rtl" data-bs-theme="dark">
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', $settings->site_name ?? ' — آموزش رایگان برنامه‌نویسی به فارسی')</title>
    <meta name="description" content="{{ $settings->meta_description ?? '' }}" />
    <meta name="keywords" content="UnderDevelops, تحت توسعه, آموزش رایگان برنامه نویسی, آموزش برنامه‌نویسی, ترجمه مستندات, W3Schools فارسی, Tutorialspoint فارسی, مقاله آموزشی, ویدیو آموزشی, آموزش C#, آموزش جاوااسکریپت, آموزش پایتون, دات نت" />
    <meta name="robots" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1" />
    <link rel="canonical" href="index.html" />
    <link rel="next" href="about.html" />
    <link rel="icon" href="{{ $settings->favicon_path ?? '' }}" type="image/x-icon">
    <meta property="og:site_name" content="{{ $settings->site_name ?? '' }}" />
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $settings->site_name ?? ''}} — آموزش رایگان برنامه‌نویسی" />
    <meta property="og:description" content="{{ $settings->meta_description ?? ''}}" />
    <meta property="og:url" content="index.html" />
    <meta property="og:image" content="images/og/default-1200x630.html" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $settings->site_name ?? ''}} — آموزش رایگان برنامه‌نویسی" />
    <meta name="twitter:description" content="{{ $settings->meta_description ?? ''}}" />
    <meta name="twitter:image" content="images/og/default-1200x630.html" />
    <script>
        const storedTheme = localStorage.getItem('theme')
        const getPreferredTheme = () => {
            if (storedTheme) {
                return storedTheme
            }
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        }
        const setTheme = function (theme) {
            if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.setAttribute('data-bs-theme', 'dark')
            } else {
                document.documentElement.setAttribute('data-bs-theme', theme)
            }
        }
        setTheme(getPreferredTheme())
        window.addEventListener('DOMContentLoaded', () => {
            var el = document.querySelector('.theme-icon-active');
            if (el != 'undefined' && el != null) {
                const showActiveTheme = theme => {
                    const activeThemeIcon = document.querySelector('.theme-icon-active use')
                    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
                    const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')
                    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
                        element.classList.remove('active')
                    })
                    btnToActive.classList.add('active')
                    activeThemeIcon.setAttribute('href', svgOfActiveBtn)
                }
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                    if (storedTheme !== 'light' || storedTheme !== 'dark') {
                        setTheme(getPreferredTheme())
                    }
                })
                showActiveTheme(getPreferredTheme())
                document.querySelectorAll('[data-bs-theme-value]')
                    .forEach(toggle => {
                        toggle.addEventListener('click', () => {
                            const theme = toggle.getAttribute('data-bs-theme-value')
                            localStorage.setItem('theme', theme)
                            setTheme(theme)
                            showActiveTheme(theme)
                        })
                    })
            }
        })
    </script>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com/" crossorigin>
    <link rel="stylesheet" type="text/css" href="{{ asset('app/assets/vendor/font-awesome/css/all.minc74b.css?v=6fnf9K7jzMc68QzgpIJCVPY_jNQ-wskxIAgLIRho8H0') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app/assets/vendor/bootstrap-icons/bootstrap-icons9a04.css?v=cKs41vL6H84DqDpUvRCfSaiCLfpjNkQuA-9HZqwRlDU') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app/assets/vendor/tiny-slider/tiny-slider1b21.css?v=1CXVlacnwYLmg9X2AhCKvYcSgR53GWiU3z4qZJDrb68') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app/assets/vendor/glightbox/css/glightboxd790.css?v=yMoCTayb6wccTz561YN_R0qkP756JifYXnA40MUtR-k') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app/assets/css/style-rtlde33.css?v=_LiaJmssPW9ho0X5aF_Je6hvr2_xqHuofrk9iTrDOhI') }}">
</head>
<body>

@include('app.layouts.header')

@yield('content')

@include('app.layouts.footer')

<div b-4he9412dhs class="back-top"><i b-4he9412dhs class="bi bi-arrow-up-short position-absolute top-50 start-50 translate-middle"></i></div>

<script src="{{ asset('app/assets/vendor/bootstrap/dist/js/bootstrap.bundle.mine634.js?v=gvZPYrsDwbwYJLD5yeBfcNujPhRoGOY831wwbIzz3t0') }}" defer></script>
<script src="{{ asset('app/assets/vendor/tiny-slider/tiny-slider-rtl0f0f.js?v=k-em-LAc1fpO9_rjzgJN6vdtDZjtKCNGlFg_zvStwyg') }}" defer></script>
<script src="{{ asset('app/assets/vendor/glightbox/js/glightbox71ad.js?v=y5UGfqUEDlOshy15lIjsxYWSeNPV7tIXdsOJ2vMetgI') }}" defer></script>
<script src="{{ asset('app/assets/vendor/purecounterjs/dist/purecounter_vanilla23ed.js?v=QS4WC03UpIUx8aByHrcPlhCTwRzB4BgHZ5-K1P9PKXI') }}" defer></script>
<script src="{{ asset('app/assets/js/functionse8bb.js?v=nwi5Tl0l6drAcq_2yDVeejD07PNutyjSIw5a33p4X04') }}" defer></script>
<script src="{{ asset('app/assets/_content/NToastNotify/toastrf461.js?8.0.0.0') }}" type="text/javascript"></script>

<script>
    if (nToastNotify) {
        nToastNotify.init({
            firstLoadEvent: 'DOMContentLoaded',
            messages: [],
            responseHeaderKey: 'X-NToastNotify-Messages',
            requestHeaderKey: 'X-Requested-With',
            libraryDetails: { "varName": "toastr", "scriptSrc": "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js", "styleHref": "https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css", "options": { "positionClass": "toast-bottom-center", "timeOut": 5000, "titleClass": "toast-title", "messageClass": "toast-message", "preventDuplicates": true, "progressBar": true, "type": "success" } },
            disableAjaxToasts: false
        });
    };
</script>

</body>
</html>
