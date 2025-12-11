@extends('panel.layouts.master')

@section('title', 'داشبورد')

@section('content')
    <!-- Start Contentbar -->
    <div class="contentbar">
        <!-- Start row -->
        <div class="row">
            <div class="col-md-12 col-lg-12 col-xl-12">
                <div class="text-center mt-3 mb-5">
                    <h4>خوش آمدید!</h4>
                    <p class="text-muted">آمار کلی پنل مدیریت آزمون آنلاین</p>
                </div>
            </div>
        </div>

        @php
                    $cards = [
            // پروفایل ادمین
            [
                'route'        => 'profile.edit',
                'icon'         => 'user',
                'bg_class'     => 'bg-gradient-orange',
                'title'        => 'پروفایل ادمین',
                'description'  => 'اطلاعات حساب کاربری خود را مشاهده و ویرایش کنید',
                'count'        => null,
                'button_text'  => 'مشاهده پروفایل',
                'button_class' => 'btn-gradient-orange px-5 py-2',
                'roles'        => ['main_admin', 'appearance_admin', 'support_admin', 'warehouse_admin'],
            ],

            // زبان‌های برنامه‌نویسی
            [
                'route'        => 'language.index',
                'icon'         => 'globe',
                'bg_class'     => 'bg-gradient-blue',
                'title'        => 'زبان‌های برنامه‌نویسی',
                'description'  => 'تعداد زبان‌های ثبت‌شده',
                'count'        => \App\Models\Language::count(),
                'button_text'  => 'مدیریت زبان‌ها',
                'col'          => '6 col-lg-3',
            ],

            // موضوعات
            [
                'route'        => 'subject.index',
                'icon'         => 'book-open',
                'bg_class'     => 'bg-gradient-info',
                'title'        => 'موضوعات',
                'description'  => 'تعداد موضوعات ثبت‌شده',
                'count'        => \App\Models\Subject::count(),
                'button_text'  => 'مدیریت موضوعات',
                'col'          => '6 col-lg-3',
            ],

            // آزمون‌ها
            [
                'route'        => 'quiz.index',
                'icon'         => 'check-square',
                'bg_class'     => 'bg-gradient-success',
                'title'        => 'آزمون‌ها',
                'description'  => 'تعداد آزمون‌های ایجادشده',
                'count'        => \App\Models\Quiz::count(),
                'button_text'  => 'مدیریت آزمون‌ها',
                'col'          => '6 col-lg-3',
            ],

            // سوالات
            [
                'route'        => 'quiz.index', // می‌تونی بعداً یه route جدا برای سوالات بزنی
                'icon'         => 'help-circle',
                'bg_class'     => 'bg-gradient-warning',
                'title'        => 'سوالات',
                'description'  => 'تعداد سوالات موجود',
                'count'        => \App\Models\Question::count(),
                'button_text'  => 'مشاهده همه سوالات',
                'col'          => '6 col-lg-3',
            ],

            // مستندات
            [
                'route'        => 'doc.index',
                'icon'         => 'file-text',
                'bg_class'     => 'bg-gradient-danger',
                'title'        => 'مستندات',
                'description'  => 'تعداد مستندات آپلودشده',
                'count'        => \App\Models\Doc::count(),
                'button_text'  => 'مدیریت مستندات',
                'col'          => '6 col-lg-3',
            ],

            // دسته‌بندی مقالات
            [
                'route'        => 'category.index',
                'icon'         => 'grid',
                'bg_class'     => 'bg-gradient-warning',
                'title'        => 'دسته‌بندی مقالات',
                'description'  => 'تعداد دسته‌بندی‌های بلاگ',
                'count'        => \App\Models\Category::count(),
                'button_text'  => 'مدیریت دسته‌ها',
                'col'          => '6 col-lg-3',
            ],

            // تگ‌ها
            [
                'route'        => 'tag.index',
                'icon'         => 'tag',
                'bg_class'     => 'bg-gradient-pink',
                'title'        => 'تگ‌های بلاگ',
                'description'  => 'تعداد تگ‌های استفاده‌شده',
                'count'        => \App\Models\Tag::count(),
                'button_text'  => 'مدیریت تگ‌ها',
                'col'          => '6 col-lg-3',
            ],

            // مقالات بلاگ
            [
                'route'        => 'blog.index',
                'icon'         => 'file-plus',
                'bg_class'     => 'bg-gradient-cyan',
                'title'        => 'مقالات',
                'description'  => 'تعداد مقالات منتشرشده',
                'count'        => \App\Models\Blog::count(),
                'button_text'  => 'مدیریت مقالات',
                'col'          => '6 col-lg-3',
            ],

            // تیم
            [
                'route'        => 'team.index',
                'icon'         => 'users',
                'bg_class'     => 'bg-gradient-teal',
                'title'        => 'تیم',
                'description'  => 'تعداد اعضای تیم',
                'count'        => \App\Models\Team::count(),
                'button_text'  => 'مدیریت تیم',
                'col'          => '6 col-lg-3',
            ],

            // درباره ما
            [
                'route'        => 'aboutus.index',
                'icon'         => 'info',
                'bg_class'     => 'bg-gradient-teal',
                'title'        => 'درباره ما',
                'description'  => 'ویرایش صفحه درباره ما',
                'count'        => '1',
                'button_text'  => 'ویرایش درباره ما',
                'col'          => '6 col-lg-3',
            ],

            // تنظیمات سایت
            [
                'route'        => 'settings.index',
                'icon'         => 'settings',
                'bg_class'     => 'bg-gradient-purple',
                'title'        => 'تنظیمات سایت',
                'description'  => 'تنظیمات کلی سایت',
                'count'        => \App\Models\Setting::count() ?: 1,
                'button_text'  => 'ویرایش تنظیمات',
                'col'          => '6 col-lg-3',
            ],
        ];
        @endphp

        <div class="row">
            @foreach ($cards as $card)
                <div class="col-md-{{ $card['route'] === 'profile.edit' ? '12' : '6 col-lg-3' }} mb-4">
                    <div class="card {{ $card['route'] === 'profile.edit' ? 'profile-card' : 'stats-card' }} shadow-sm">
                        <div class="card-body {{ $card['route'] === 'profile.edit' ? 'd-flex align-items-center' : 'text-center' }}">
                            <div class="icon-circle {{ $card['bg_class'] }} {{ $card['route'] === 'profile.edit' ? 'me-4' : 'mb-3' }}">
                                <i data-feather="{{ $card['icon'] }}"></i>
                            </div>
                            <div class="{{ $card['route'] === 'profile.edit' ? 'flex-grow-1 mr-2' : '' }}">
                                <h5 class="card-title {{ $card['route'] === 'profile.edit' ? 'mb-1' : '' }}">{{ $card['title'] }}</h5>
                                <p class="text-muted mb-0">{{ $card['description'] }}</p>
                                @if ($card['count'] !== null)
                                    <h3 class="stats-number">{{ $card['count'] }}</h3>
                                @endif
                            </div>
                            <a href="{{ route($card['route']) }}" class="btn btn-primary-rgba mt-3">{{ $card['button_text'] }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->

    <style>
        /* گرادیان‌های رنگی یکسان با ویو مرجع */
        .bg-gradient-blue    { background: linear-gradient(135deg, #007bff, #0069d9) !important; color: white !important; }
        .bg-gradient-info    { background: linear-gradient(135deg, #17a2b8, #138496) !important; color: white !important; }
        .bg-gradient-success { background: linear-gradient(135deg, #28a745, #218838) !important; color: white !important; }
        .bg-gradient-warning { background: linear-gradient(135deg, #ffc107, #e0a800) !important; color: white !important; }
        .bg-gradient-danger  { background: linear-gradient(135deg, #dc3545, #c82333) !important; color: white !important; }
        .bg-gradient-purple  { background: linear-gradient(135deg, #6f42c1, #5a32a3) !important; color: white !important; }

        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        .icon-circle i {
            width: 28px;
            height: 28px;
        }

        .stats-card {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
        }

        .stats-number {
            font-weight: bold;
            color: #343a40;
        }

        .btn-primary-rgba {
            background: rgba(0, 123, 255, 0.1);
            color: #007bff;
            border: 1px solid #007bff;
            font-size: 0.875rem;
        }
        .btn-primary-rgba:hover {
            background: #007bff;
            color: white;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace({
                width: 28,
                height: 28
            });
        });
    </script>
@endsection
