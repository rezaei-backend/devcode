<!-- header.blade.php -->
<header class="navbar-light navbar-sticky header-static">
    <nav class="navbar navbar-expand-xl">
        <div class="container-fluid px-3 px-xl-5">
            <a class="navbar-brand" href="{{route('home.index')}}">
                <img class="light-mode-item navbar-brand-item" src="{{ $settings->logo_path ?? ''}}" alt="لوگوی {{ $settings->site_name ?? ''}}" fetchpriority="high" decoding="async">
                <img class="dark-mode-item navbar-brand-item" src="{{ $settings->logo_path ?? ''}}" alt="لوگوی {{ $settings->site_name ?? ''}}" fetchpriority="high" decoding="async">
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-animation">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>
            <div class="navbar-collapse w-100 collapse" id="navbarCollapse">
                <ul class="navbar-nav navbar-nav-scroll me-auto">
                </ul>
                <ul class="navbar-nav navbar-nav-scroll me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home.index')}}">صفحه اصلی {{ $settings->site_name ?? ''}}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="docsMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">مستندات و راهنماها</a>
                        <ul class="dropdown-menu" aria-labelledby="docsMenu">
                            <li><span class="dropdown-item-text text-muted">به زودی تکمیل‌تر…</span></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="coursesMenu" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">دوره‌ها و آزمون‌ها</a>
                        <ul class="dropdown-menu" aria-labelledby="coursesMenu">
                            <li> <a class="dropdown-item" href="course/html-zero-to-pro.html">دوره + آزمون HTML</a></li>
                            <li> <a class="dropdown-item" href="course/javascript-zero-to-pro.html">دوره + آزمون JavaScript</a></li>
                            <li> <a class="dropdown-item" href="course/python-zero-to-pro.html">دوره + آزمون Python</a></li>
                            <li> <a class="dropdown-item" href="course/ui-ux-zero-to-pro.html">دوره UI/UX (به‌همراه تمرین)</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html">درباره {{ $settings->site_name ?? ''}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.html">تماس با ما</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
