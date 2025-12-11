

@extends('App.Layouts.master')

@section('title', "$doc->title"."مقاله های برنامه نویسی درمورد : ")

@section('content')

    <style>

        /* بلوک خروجی با تم روشن (معکوس نسبت به بلوک کد تیره) */
        .output-block {
            position: relative;
            background: #f8fafc;         /* پس‌زمینه خیلی روشن */
            border: 1px solid #000000;    /* خط دور خاکستری روشن */
            border-radius: 12px;
            overflow: hidden;
            margin: 20px 0;
            box-shadow: 0 6px 20px rgba(2, 6, 23, 0.08);
        }

        .output-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 10px 12px;
            border-bottom: 1px solid #000000;
            background: #ffffff; /* پس‌زمینه سفید خالص به جای گرادیان کم‌رنگ */
        }

        .output-title {
            font-size: 13px;
            color: #000000 !important; /* متن مشکی قطعی */
            font-weight: 600;          /* پررنگ‌تر برای وضوح بیشتر */
            letter-spacing: 0.2px;
        }





        .output-block pre {
            margin: 0;
            overflow-x: auto;            /* اسکرول افقی برای خطوط طولانی */
        }

        .output-block code {
            display: block;
            font-family: "Fira Code", ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 14px;
            line-height: 1.8;
            color: #0f172a;              /* متن تیره روی پس‌زمینه روشن */
            padding: 14px 16px;
            white-space: pre;
            tab-size: 2;
        }

        /* هایلایت خیلی سبک برای خروجی‌های رنگی (اختیاری) */
        .output-block .token.info    { color: #0ea5e9; }  /* آبی */
        .output-block .token.success { color: #10b981; }  /* سبز */
        .output-block .token.warn    { color: #f59e0b; }  /* نارنجی */
        .output-block .token.error   { color: #ef4444; }  /* قرمز */

        /* استایل بلوک کد */
        .code-block {
            position: relative;
            background: #0f172a;        /* پس‌زمینه تیره */
            border: 1px solid #1f2937;  /* خط دور */
            border-radius: 12px;
            overflow: hidden;
            margin: 20px 0;
            box-shadow: 0 8px 24px rgba(2, 6, 23, 0.6);
        }

        .code-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
            border-bottom: 1px solid #1f2937;
            background: rgba(255,255,255,0.04);
        }

        .code-lang {
            font-size: 13px;
            color: #94a3b8; /* خاکستری کم‌رنگ */
        }

        .btn-copy {
            font-size: 13px;
            color: #e5e7eb;
            background: #0b1228;
            border: 1px solid #1f2937;
            padding: 6px 10px;
            border-radius: 8px;
            cursor: pointer;
            transition: all .2s ease;
        }
        .btn-copy:hover {
            background: #111827;
            border-color: #334155;
        }

        pre {
            margin: 0;
            overflow: auto; /* اسکرول افقی */
        }

        code {
            display: block;
            font-family: "Fira Code", monospace;
            font-size: 14px;
            line-height: 1.8;
            color: #e5e7eb;
            padding: 14px 16px;
            white-space: pre;
            tab-size: 2;
        }

        /* هایلایت ساده */
        .token.keyword { color: #38bdf8; font-weight: 600; }
        .token.string  { color: #34d399; }
        .token.number  { color: #f59e0b; }
        .token.comment { color: #94a3b8; font-style: italic; }

    </style>

    <!-- HTML -->


    <main class="pt-3 pt-xl-5">

        <section class="pt-3 pt-xl-5">
            <div class="container">

                <!-- نوار زبان‌ها -->
                <div id="langbarWrap" class="lang-topbar-wrap">
                    <div id="langbar" class="lang-topbar bg-body-tertiary">
                        @foreach($langs as $lang)
                        <a href="/App/Doc/{{$lang->slug}}" class="text-body">{{$lang->name}}</a>
                        @endforeach
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
                            <div class="card border docs-sidebar" data-docs-sidebar data-language="mysql">
                                <div class="card-header border-bottom-0 pb-0">
                                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
                                        <div>
                                            <h6 class="mb-1">{{$languge->name}}</h6>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-sm docs-sidebar-search-group mt-3">
                                        <input type="search"
                                               id="docs-sidebar-search-mysql"
                                               class="form-control border-start-0"
                                               placeholder="جستجو در سرفصل‌ها"
                                               aria-label="جستجو در سرفصل‌ها"
                                               autocomplete="off"
                                               data-docs-search-input />
                                    </div>
                                </div>
                                <div class="list-group list-group-flush p-2 menu-scroll">
@foreach($menus as $menu)
    @foreach($menu->docjoin as $docname)

                                    <a class="list-group-item list-group-item-action {{ $docname->slug==$doc->slug ?  'active':''}}"
                                       href="/App/Doc/{{$languge->slug}}/{{$docname->slug}}"
                                       data-docs-nav-item
                                       data-docs-search-key=" {{$menu->title.' > '.$docname->title}}">
                                         {{$menu->title.' > '.$docname->title}}
                                    </a>
                                        @endforeach
                                    @endforeach
                                </div>
                                <div class="text-center text-muted small py-3 d-none" data-docs-search-empty>
                                    نتیجه‌ای برای جستجو یافت نشد.
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
                            <h5 id="tocDrawerLabel" class="mb-0"> فهرست سرفصل‌های {{$languge->name}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body p-2">
                            <div class="docs-sidebar" data-docs-sidebar data-language="mysql">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <label class="form-label small text-muted mb-0" for="docs-sidebar-search-mobile-mysql">جستجو در سرفصل‌ها</label>
                                    </div>
                                    <div class="input-group input-group-sm docs-sidebar-search-group mt-2">
                                        <input type="search"
                                               class="form-control border-start-0"
                                               id="docs-sidebar-search-mobile-mysql"
                                               placeholder="جستجو..."
                                               aria-label="جستجو در سرفصل‌ها"
                                               autocomplete="off"
                                               data-docs-search-input />
                                    </div>
                                </div>
                                <div class="list-group list-group-flush">
                                    @foreach($menus as $menu)
                                        @foreach($menu->docjoin as $docname)

                                            <a class="list-group-item list-group-item-action {{ $docname->slug==$doc->slug ?  'active':''}}"
                                               href="/App/Doc/{{$languge->name}}/{{$docname->slug}}"
                                               data-docs-nav-item
                                               data-docs-search-key=" {{$menu->title.' > '.$docname->title}}">
                                                {{$menu->title.' > '.$docname->title}}
                                            </a>
                                        @endforeach
                                    @endforeach
                                </div>
                                <div class="text-center text-muted small py-3 d-none" data-docs-search-empty>
                                    نتیجه‌ای برای جستجو یافت نشد.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- محتوای داکیومنت -->
                    <div class="col-xl-9">

                        <!-- هدر کارت + ناوبری -->
                        <div class="card border mb-3">
                            <div class="card-body d-flex align-items-center gap-3 flex-wrap">
                                <img src="{{asset('images/language/'.$languge->logo)}}" width="40" height="40" alt="MySQL">
                                <div class="me-auto">
                                    <h1 class="h4 mb-1">{{$languge->name}} — {{$subjects->title}} — {{$doc->title}}</h1>
                                    <div class="text-muted small">آخرین بروزرسانی: {{$doc->	updated_at }}</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4 gap-2 flex-wrap w-100">
                                    <span></span>
@if(!empty($nextdoc))
                                    <a href="/App/Doc/{{$languge->slug}}/{{$nextdoc->slug}}" class="btn btn-sm btn-danger shadow-sm">
                                        {{$nextdoc->title}} بعدی:  <i class="fas fa-arrow-left me-2"></i>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- مقاله -->
                        <article class="card border docs-article">
                            <div class="card-body">
                                <h1>{{$doc->title}}</h1>
                                {!! $textcher !!}

                                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-4 gap-2 flex-wrap">
                                    <span></span>
                                    @if(!empty($nextdoc))
                                        <a href="/App/Doc/{{$languge->slug}}/{{$nextdoc->slug}}" class="btn btn-sm btn-danger shadow-sm">
                                            {{$nextdoc->title}} بعدی:  <i class="fas fa-arrow-left me-2"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>


    </main>

    <script type="importmap">{}</script>

    <script>
        document.querySelectorAll('.btn-copy').forEach(btn => {
            btn.addEventListener('click', () => {
                // پیدا کردن بلوک کد مربوطه
                const blockId = btn.getAttribute('data-target');
                const codeElement = document.querySelector('#' + blockId + ' pre code');
                const codeText = codeElement.innerText.trim();

                // کپی به کلیپ‌بورد
                navigator.clipboard.writeText(codeText).then(() => {
                    const oldText = btn.textContent;
                    btn.textContent = 'کپی شد ✔';
                    setTimeout(() => btn.textContent = oldText, 1500);
                }).catch(() => {
                    alert('خطا در کپی متن');
                });
            });
        });
    </script>
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
            if(el != 'undefined' && el != null) {
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
