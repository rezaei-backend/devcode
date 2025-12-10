<div class="rightbar">
    <!-- Start Topbar -->
    @include('panel.layouts.topbar')
    <!-- End Topbar -->

    <!-- Start Breadcrumbbar -->
    <div class="breadcrumbbar rightbar-breadcrumbbar shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">{{ $settings->site_name ?? 'پنل مدیریت' }}</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb" id="breadcrumb">
                        <li class=""><a href="{{ route('Admin') }}"></a></li>
                        <!-- جاوااسکریپت بقیه موارد را اضافه می‌کند -->
                    </ol>
                </div>
            </div>
        </div>

        <script>
            // ساخت بریدکرامب به صورت داینامیک (دقیقاً مثل ویو مرجع)
            const path = window.location.pathname;
            const segments = path.split('/').filter(segment => segment); // حذف مقادیر خالی
            const breadcrumb = document.getElementById('breadcrumb');

            segments.forEach((segment, index) => {
                // نادیده گرفتن بخش "panel" در URL
                if (segment.toLowerCase() === 'panel') return;

                const li = document.createElement('li');
                li.classList.add('breadcrumb-item');

                // آخرین آیتم = فعال
                if (index === segments.length - 1) {
                    li.classList.add('active');
                    li.setAttribute('aria-current', 'page');
                    li.textContent = segment.charAt(0).toUpperCase() + segment.slice(1);
                } else {
                    const a = document.createElement('a');
                    const linkPath = '/' + segments.slice(0, index + 1).join('/');
                    a.href = linkPath;
                    a.textContent = segment.charAt(0).toUpperCase() + segment.slice(1);

                    // جلوگیری از رفرش صفحه و هدایت صحیح
                    a.addEventListener('click', function (e) {
                        e.preventDefault();
                        window.location.href = linkPath;
                    });

                    li.appendChild(a);
                }

                breadcrumb.appendChild(li);
            });
        </script>
    </div>
    <!-- End Breadcrumbbar -->

    <!-- Start Contentbar -->
    @yield('content')
    <!-- End Contentbar -->
</div>
