@extends('app.layouts.master')


@section('style')



    <style>
        /* ===== متغیرهای پویا برای ارتفاع‌ها ===== */
        :root {
            --header-h: 64px; /* با JS آپدیت می‌شود */
            --langbar-h: 44px; /* با JS آپدیت می‌شود */
        }

        /* ===== هدر را همیشه ثابت نگه می‌داریم (مثل W3) ===== */
        header.navbar-sticky {
            position: sticky;
            top: 0;
            z-index: 1040; /* بالاتر از محتوا */
            transform: none !important; /* اگر قالب روی اسکرول کلاس hide می‌زد، بی‌اثر شود */
        }

        header.navbar-sticky[class*="hide"],
        header.navbar-sticky[class*="off"],
        header.navbar-sticky[class*="move"] {
            transform: none !important;
        }

        /* سایدبار داکیومنت‌ها (اورجینال) */
        .docs-sidebar .list-group-item {
            border: 0;
            border-radius: .5rem;
            margin: .125rem 0
        }

        .docs-sidebar .list-group-item:hover {
            background: rgba(25,135,84,.075)
        }

        .docs-sidebar .list-group-item.active {
            background: rgba(25,135,84,.15);
            color: var(--bs-success) !important;
            font-weight: 600
        }

        /* سایدبار چسبان: با درنظر گرفتن هدر و نوار زبان‌ها */
        .sticky-top-100 {
            position: sticky;
            top: calc(var(--header-h) + var(--langbar-h) + 16px);
        }

        .menu-scroll {
            max-height: calc(100vh - 120px);
            overflow: auto
        }

        .docs-sidebar-search-group .form-control {
            box-shadow: none;
        }

        .docs-sidebar-search-group .form-control:focus {
            border-color: rgba(25,135,84,.4);
            box-shadow: 0 0 0 .2rem rgba(25,135,84,.15);
        }

        .docs-sidebar-search-group .input-group-text {
            color: var(--bs-secondary-color);
        }

        .docs-sidebar-search-group .btn {
            min-width: 2.5rem;
        }

        .docs-sidebar [data-docs-search-empty] {
            border-top: 1px solid var(--bs-border-color);
        }

        /* نوار زبان‌ها (الهام از W3) */
        .lang-topbar {
            white-space: nowrap;
            overflow: auto;
            padding: .25rem .5rem;
            border-radius: .5rem
        }

        .lang-topbar a {
            display: inline-block;
            padding: .35rem .75rem;
            border-radius: .5rem;
            margin: .125rem;
            text-decoration: none
        }

        .lang-topbar a:hover {
            background: var(--bs-secondary-bg)
        }

        /* نوار زبان‌ها چسبان، دقیقاً زیر هدر */
        .lang-topbar-wrap {
            position: sticky;
            top: var(--header-h);
            z-index: 9; /* کم تا روی محتوا نیفته */
            background: var(--bs-body-bg);
            padding: .25rem 0 .75rem; /* فاصله‌ی ظریف */
        }

        /* تیترهای داخل محتوای داکیومنت‌ها */
        .docs-article .card-body :is(h1, h2, h3, h4, h5, h6) {
            margin-top: 1.25rem;
            margin-bottom: .75rem;
        }

        .docs-article .card-body :is(h1, h2, h3, h4, h5, h6):first-child {
            margin-top: 0;
        }

        .docs-article .card-body :is(h1, h2, h3, h4, h5, h6) + :is(h1, h2, h3, h4, h5, h6) {
            margin-top: .5rem;
        }

        /* Prism + Copy Button */
        pre[class*="language-"] {
            direction: ltr;
            text-align: left;
            border-radius: .75rem
        }

        .prism-toolbar {
            inset-inline-end: .5rem;
            inset-block-start: .5rem
        }

        .prism-toolbar .toolbar-item button {
            background: rgba(0,0,0,.35);
            color: #fff;
            border: 0;
            padding: .25rem .5rem;
            border-radius: .375rem
        }

        [data-bs-theme=light] .prism-toolbar .toolbar-item button {
            background: rgba(0,0,0,.45)
        }

        [data-bs-theme=dark] .prism-toolbar .toolbar-item button {
            background: rgba(255,255,255,.18)
        }

        /* هماهنگی دارک‌مود با بک‌گراند کدها */
        [data-bs-theme="dark"] pre[class*="language-"] {
            background: #0f172a;
            color: #e2e8f0
        }

        /* Offcanvas موبایل از بالای صفحه */
        .offcanvas {
            top: 0
        }
    </style>
@endsection
@section('content')
    <main class="pt-3 pt-xl-5">

        <section class="pt-3 pt-xl-5">
            <div class="container">

                <!-- نوار زبان‌ها -->
                <div id="langbarWrap" class="lang-topbar-wrap">
                    <div id="langbar" class="lang-topbar bg-body-tertiary">
                        @forelse($languages as $lang)

                        <a href="{{route('language.show',$lang->slug)}}" class="text-body fw-semibold bg-body">{{display_language_name($lang->name)}}</a>
                        @empty
                            <span>زبان یافت نشد</span>
                        @endforelse
                    </div>
                </div>

                <!-- دکمه فهرست (موبایل) -->
                <div class="d-xl-none mb-3">
                    <button class="btn btn-outline-secondary w-100" data-bs-toggle="offcanvas" data-bs-target="#tocDrawer">
                        فهرست سرفصل‌ها
                    </button>
                </div>

                <div class="row g-4">


                    <aside class="col-xl-3 d-none d-xl-block">
                        <div class="sticky-top-100">
                            <div class="card border docs-sidebar" data-docs-sidebar data-language="{{display_language_name($language->name)}}">
                                <div class="card-header border-bottom-0 pb-0">
                                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                                        <div>
                                            <h6 class="mb-1">{{display_language_name($language->name)}}</h6>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm docs-sidebar-search-group mt-3">
                                        <input type="search"
                                               id="docs-sidebar-search-{{display_language_name($language->name)}}"
                                               class="form-control border-start-0"
                                               placeholder="جستجو در سرفصل‌ها"
                                               aria-label="جستجو در سرفصل‌ها"
                                               autocomplete="off"
                                               data-docs-search-input />
                                    </div>
                                </div>
                                <div class="list-group list-group-flush p-2 menu-scroll">
                                    @forelse($subjects as $subject)
                                    <a class="list-group-item list-group-item-action"
                                       href="default.html"
                                       data-docs-nav-item
                                       data-docs-search-key="&#x62E;&#x627;&#x646;&#x647; (HOME) default">{{$subject->title}}
                                    </a>
                                    @empty

                                        <div class="text-center text-muted small py-3 d-none" data-docs-search-empty>
                                            نتیجه‌ای برای جستجو یافت نشد.
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    </aside>

                    <script>
                        (function () {
                            const normalize = (value) => {
                                if (!value) return "";
                                return value
                                    .toLowerCase()
                                    .replace(/[\u200c\u200f]/g, " ")
                                    .replace(/[أإآٱ]/g, "ا")
                                    .replace(/ي/g, "ی")
                                    .replace(/ك/g, "ک")
                                    .replace(/\s+/g, " ")
                                    .trim();
                            };

                            const formatNumber = (value) => {
                                try {
                                    return new Intl.NumberFormat(document.documentElement.lang || "fa-IR").format(value);
                                } catch (err) {
                                    return value.toString();
                                }
                            };

                            const setupSidebar = (sidebar) => {
                                if (!sidebar || sidebar.dataset.docsSidebarInitialized === "1") {
                                    return;
                                }

                                const input = sidebar.querySelector('[data-docs-search-input]');
                                if (!input) {
                                    return;
                                }

                                sidebar.dataset.docsSidebarInitialized = "1";

                                const clearBtn = sidebar.querySelector('[data-docs-search-clear]');
                                const items = Array.from(sidebar.querySelectorAll('[data-docs-nav-item]'));
                                const emptyState = sidebar.querySelector('[data-docs-search-empty]');
                                const countLabel = sidebar.querySelector('[data-docs-search-count]');
                                const totalCount = items.length;

                                items.forEach((item) => {
                                    const raw = item.getAttribute('data-docs-search-key') || item.textContent || "";
                                    item.dataset.docsSearchNormalized = normalize(raw);
                                });

                                const updateCount = (visibleCount, hasTerm) => {
                                    if (!countLabel) return;
                                    if (hasTerm) {
                                        countLabel.textContent = `${formatNumber(visibleCount)} از ${formatNumber(totalCount)} مورد`;
                                    } else {
                                        countLabel.textContent = `${formatNumber(totalCount)} مورد`;
                                    }
                                };

                                const applyFilter = () => {
                                    const normalizedTerm = normalize(input.value);
                                    const parts = normalizedTerm.split(' ').filter(Boolean);
                                    const hasTerm = parts.length > 0;
                                    let visibleCount = 0;

                                    items.forEach((item) => {
                                        const key = item.dataset.docsSearchNormalized || "";
                                        const isVisible = !hasTerm || parts.every(part => key.includes(part));

                                        item.classList.toggle('d-none', !isVisible);
                                        item.setAttribute('aria-hidden', (!isVisible).toString());
                                        item.tabIndex = isVisible ? 0 : -1;

                                        if (isVisible) {
                                            visibleCount += 1;
                                        }
                                    });

                                    if (emptyState) {
                                        emptyState.classList.toggle('d-none', visibleCount !== 0);
                                    }

                                    if (clearBtn) {
                                        clearBtn.classList.toggle('d-none', !hasTerm);
                                    }

                                    updateCount(visibleCount, hasTerm);
                                };

                                if (clearBtn) {
                                    clearBtn.addEventListener('click', () => {
                                        if (!input.value) return;
                                        input.value = '';
                                        input.focus();
                                        applyFilter();
                                    });
                                }

                                input.addEventListener('input', applyFilter);

                                applyFilter();
                            };

                            const init = () => {
                                document.querySelectorAll('[data-docs-sidebar]').forEach(setupSidebar);
                            };

                            if (document.readyState === 'loading') {
                                document.addEventListener('DOMContentLoaded', init);
                            } else {
                                init();
                            }
                        })();
                    </script>


                    <!-- سایدبار موبایل (Offcanvas) -->
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="tocDrawer" aria-labelledby="tocDrawerLabel">
                        <div class="offcanvas-header">
                            <h5 id="tocDrawerLabel" class="mb-0">فهرست سرفصل‌های {{display_language_name($language->name)}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body p-2">
                            <div class="docs-sidebar" data-docs-sidebar data-language="{{display_language_name($language->name)}}">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <label class="form-label small text-muted mb-0" for="docs-sidebar-search-mobile-{{display_language_name($language->name)}}">جستجو در سرفصل‌ها</label>
                                    </div>
                                    <div class="input-group input-group-sm docs-sidebar-search-group mt-2">
                                        <input type="search"
                                               class="form-control border-start-0"
                                               id="docs-sidebar-search-mobile-{{display_language_name($language->name)}}"
                                               placeholder="جستجو..."
                                               aria-label="جستجو در سرفصل‌ها"
                                               autocomplete="off"
                                               data-docs-search-input />
                                    </div>
                                </div>
                                <div class="list-group list-group-flush">
                                    @forelse($subjects as $subject)
                                    <a class="list-group-item list-group-item-action active"
                                       href="default.html"
                                       data-docs-nav-item
                                       data-docs-search-key="&#x62E;&#x627;&#x646;&#x647; (HOME) default">
                                        {{$subject->title }}
                                    </a>
                                    @empty
                                        <div class="text-center text-muted small py-3 d-none" data-docs-search-empty>
                                            نتیجه‌ای برای جستجو یافت نشد.
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- محتوای داکیومنت -->
                    <div class="col-xl-9">
                        <!-- هدر کارت + ناوبری -->
                        <div class="card border mb-3">
                            <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                <img src="{{asset('images/language/'.$language->logo)}}" width="40" height="40" alt="{{display_language_name($language->name)}}">
                                <div class="me-auto">
                                    <h1 class="h4 mb-1">{{display_language_name($language->name)}} (HOME)</h1>
                                    <div class="text-muted small">آخرین بروزرسانی: {{$language->updated_at}}</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4 gap-2 flex-wrap w-100">
                                    <span></span>

                                    <a href="intro.html" class="btn btn-sm btn-danger shadow-sm">
                                        بعدی: &#x645;&#x642;&#x62F;&#x645;&#x647; (Intro) <i class="fas fa-arrow-left me-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- مقاله -->
                        <article class="card border docs-article">
                            <div class="card-body">
                                <h1>خانه (HOME)</h1>
                                <p class="mb-4">اینجا با <strong>آموزش {{display_language_name($language->name)}}</strong> شروع می کنیم. {{display_language_name($language->name)}} یک «زبان اسکریپت نویسی (Scripting Language)» سمت سرور است. یعنی روی سرور می دود و صفحه پویا می سازد. مثل وقتی نمره ها را در سایت مدرسه می بینی.</p>
                                <h2 class="fs-5 mt-4 mb-2">{{display_language_name($language->name)}} چیه؟ ({{display_language_name($language->name)}})</h2>
                                <p class="mb-3">{{display_language_name($language->name)}} ابزار ساخت وب پویاست. «سمت سرور» یعنی پردازش در سرور انجام می شود. سپس نتیجه به مرورگر می رسد. مثل سفارش غذا که در آشپزخانه آماده می شود.</p>
                                <h2 class="fs-5 mt-4 mb-2">اولین اسکریپت {{display_language_name($language->name)}}</h2>
                                <p class="mb-3">این کد یک متن ساده چاپ می کند. «echo» یعنی خروجی گرفتن. فایل را در سرور اجرا کن تا نتیجه را ببینی.</p>
                                <pre class="line-numbers"><code class="language-{{display_language_name($language->name)}}">&lt;!DOCTYPE html&gt;
                                        &lt;html&gt;
                                        &lt;body&gt;
                                          &lt;?{{display_language_name($language->name)}}
                                          echo &quot;My first {{display_language_name($language->name)}} script!&quot;;
                                          ?&gt;
                                        &lt;/body&gt;
                                        &lt;/html&gt;
                                </code>
                                </pre>
                                <p class="mb-3"><a href="https://www.w3schools.com/{{display_language_name($language->name)}}/{{display_language_name($language->name)}}tryit.asp?filename=try{{display_language_name($language->name)}}_intro" rel="noopener nofollow" target="_blank">مشاهده در ادیتور</a></p>
                                <p class="mb-3"><strong>نکته:</strong> متن داخل <code>echo</code> را عوض کن. سپس اجرا را بزن و نتیجه را ببین.</p>
                                <h3 class="fs-6 mt-3 mb-2">گام های سریع اجرا</h3>
                                <ol class="mb-3">
                                    <li>لینک ادیتور را باز کن.</li>
                                    <li>کد را کمی تغییر بده.</li>
                                    <li>Run را بزن و خروجی را ببین.</li>
                                </ol>
                                <h2 class="fs-5 mt-4 mb-2">تمرین، مثال، و آزمون</h2>
                                <p class="mb-3">بعد از یادگیری، با تمرین ها خودت را بسنج. سپس مثال ها را مرور کن. اگر آماده ای، آزمون بده.</p>
                                <p class="mb-3"><a href="{{display_language_name($language->name)}}-intro.html">آموزش {{display_language_name($language->name)}} از کجا شروع کنم؟</a> | <a href="exercises.html">تمرین های {{display_language_name($language->name)}}</a> | <a href="examples.html">مثال های {{display_language_name($language->name)}}</a> | <a href="quiz.html">آزمون {{display_language_name($language->name)}}</a></p>
                                <h2 class="fs-5 mt-4 mb-2">جمع بندی سریع</h2>
                                <ul class="mb-3">
                                    <li>{{display_language_name($language->name)}} روی سرور اجرا می شود.</li>
                                    <li>با echo خروجی چاپ می کنی.</li>
                                    <li>ادیتور Tryit برای تمرین عالی است.</li>
                                    <li>تمرین، مثال، و آزمون مسیر توست.</li>
                                </ul>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4 gap-2 flex-wrap">
                                    <span></span>

                                    <a href="intro.html" class="btn btn-sm btn-danger shadow-sm">
                                        بعدی: &#x645;&#x642;&#x62F;&#x645;&#x647; (Intro) <i class="fas fa-arrow-left me-2"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>


    </main>


@endsection

@section('script')



    <script>
        // محاسبه‌ی ارتفاع هدر و نوار زبان‌ها (چسبندگی دقیق)
        (function(){
            const header   = document.querySelector('header.navbar-sticky');
            const langWrap = document.getElementById('langbarWrap');

            const setHeights = () => {
                if(header){ document.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px'); }
                if(langWrap){ document.documentElement.style.setProperty('--langbar-h', langWrap.offsetHeight + 'px'); }
            };
            setHeights();
            window.addEventListener('load', setHeights);
            window.addEventListener('resize', setHeights);
            if (window.ResizeObserver){
                if(header){ new ResizeObserver(setHeights).observe(header); }
                if(langWrap){ new ResizeObserver(setHeights).observe(langWrap); }
            }
        })();

        // اسکرول خودکار سایدبار به آیتم فعال
        (function () {
            const centerActiveItem = (container) => {
                if (!container) { return; }
                const activeItem = container.querySelector('.list-group-item.active');
                if (!activeItem) { return; }
                const containerRect = container.getBoundingClientRect();
                const activeRect = activeItem.getBoundingClientRect();
                const offset = (activeRect.top - containerRect.top) - (container.clientHeight / 2) + (activeItem.clientHeight / 2);
                container.scrollTop += offset;
            };

            centerActiveItem(document.querySelector('.docs-sidebar .menu-scroll'));

            const drawer = document.getElementById('tocDrawer');
            if (drawer) {
                const offcanvasBody = drawer.querySelector('.offcanvas-body');
                const alignOffcanvas = () => centerActiveItem(offcanvasBody);
                alignOffcanvas();
                drawer.addEventListener('shown.bs.offcanvas', alignOffcanvas);
            }
        })();
    </script>
@endsection
