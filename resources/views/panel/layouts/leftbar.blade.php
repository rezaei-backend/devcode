@php
    $menuItems = [
        ['route' => 'Admin',           'icon' => 'feather icon-home',          'label' => 'داشبورد'],

        ['separator' => true],

        ['route' => 'language.index',  'icon' => 'feather icon-globe',         'label' => 'زبان‌های برنامه‌نویسی'],
        ['route'  => 'subject.index',   'icon'   => 'feather icon-book-open',   'label'  => 'موضوعات',],
        ['route' => 'quiz.index',      'icon' => 'feather icon-check-square',  'label' => 'آزمون‌ها'],
        ['route' => 'doc.index',      'icon' => 'feather icon-file-text',     'label' => 'مستندات'],

        ['route' => 'category.index',   'icon' => 'feather icon-grid',          'label' => 'دسته‌بندی مقالات'],
        ['route' => 'tag.index',        'icon' => 'feather icon-tag',           'label' => 'تگ‌ها'],
        ['route' => 'blog.index',       'icon' => 'feather icon-file-plus',     'label' => 'مقالات'],
        ['route'=> 'team.index'  ,'icon'=>'fa fa-child' ,'label'=>'تیم ما'],

        ['separator' => true],

        ['route' => 'aboutus.index',   'icon' => 'feather icon-info',          'label' => 'درباره ما'],
        ['route' => 'settings.index',  'icon' => 'feather icon-settings',      'label' => 'تنظیمات سایت'],
        ['route' => 'profile.edit', 'icon' => 'feather icon-user', 'label' => 'پروفایل من'],
    ];
@endphp

<div class="leftbar">
    <div class="sidebar">
        <!-- لوگو -->
        <div class="logobar">
            @if(isset($settings) && $settings->logo_path)
                <a href="{{ route('Admin') }}" class="logo">
                    <img src="{{ asset('images/settings/' . $settings->logo_path) }}"
                         class="img-fluid" alt="logo">
                </a>
            @else
                <a href="{{ route('Admin') }}" class="logo text-white h5 mb-0">
                    {{ $settings->site_name ?? 'پنل مدیریت' }}
                </a>
            @endif
        </div>

        <!-- منوی عمودی -->
        <div class="navigationbar">
            <ul class="vertical-menu">
                @foreach ($menuItems as $item)
                    @if (isset($item['separator']))
                        <li class="separator">
                            <hr class="menu-divider">
                        </li>
                    @else
                        <li>
                            <a href="{{ route($item['route']) }}"
                               class="{{ request()->routeIs($item['route']) || request()->routeIs($item['route'].'.*') ? 'active' : '' }}">
                                <i class="{{ $item['icon'] }}"></i>
                                <span>{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Feather Icons -->
<script src="https://unpkg.com/feather-icons"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        feather.replace();
    });
</script>

<!-- Font Awesome (اختیاری) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
