@extends('App.Layouts.master')

@section('title', 'devcode(تحت‌توسعه) — آموزش رایگان برنامه‌نویسی به فارسی')

@section('content')

    <section class="position-relative overflow-hidden pt-5 pt-lg-3">
        <figure class="position-absolute top-50 start-0 translate-middle-y ms-n7 d-none d-xxl-block">
        </figure>
        <span class="position-absolute top-50 end-0 translate-middle-y mt-5 me-n5 d-none d-xxl-inline-flex">
    </span>
        <figure class="position-absolute top-0 start-0 ms-5">
            <svg class="fill-orange opacity-4" width="29px" height="29px">
                <path d="M29.004,14.502 C29.004,22.512 22.511,29.004 14.502,29.004 C6.492,29.004 -0.001,22.512 -0.001,14.502 C-0.001,6.492 6.492,-0.001 14.502,-0.001 C22.511,-0.001 29.004,6.492 29.004,14.502 Z"></path>
            </svg>
        </figure>
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5 col-xl-6 position-relative z-index-1 text-center text-lg-start mb-5 mb-sm-0">
                    <figure class="fill-warning position-absolute bottom-0 end-0 me-5 d-none d-xl-block">
                        <svg width="42px" height="42px">
                            <path d="M21.000,-0.001 L28.424,13.575 L41.999,20.999 L28.424,28.424 L21.000,41.998 L13.575,28.424 L-0.000,20.999 L13.575,13.575 L21.000,-0.001 Z"></path>
                        </svg>
                    </figure>
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start mb-3">
                        <span class="badge bg-primary bg-opacity-10 text-primary">از آموزش تا آزمون در یک جا</span>
                        <span class="badge bg-success bg-opacity-10 text-success">کارنامه لحظه‌ای، بدون ثبت‌نام</span>
                        <span class="badge bg-warning bg-opacity-10 text-warning">مخصوص برنامه‌نویس‌های در حال رشد</span>
                    </div>
                    <h1 class="mb-0 display-6">به devcode <br><span class="position-relative">خوش آمدید<span class="position-absolute top-50 start-50 translate-middle ms-3 z-index-n1"></span></span></h1>
                    <p class="my-4">devcode پلتفرم آموزش و <strong>آزمون مهارت برنامه‌نویسی</strong> است؛ از دیدن ویدیوهای آموزشی تا حل تست‌های مفهومی و گرفتن <strong>کارنامه‌ی لحظه‌ای</strong>، همه‌چیز در یک جا. دوره‌ها و آزمون‌های HTML، CSS، JavaScript، Python و UI/UX کاملاً رایگان و بدون نیاز به ثبت‌نام!<br><span class="text-muted">یه جا برای این‌که فقط آموزش نبینی؛ <strong>خودت رو هم بسنجی و پیشرفتت رو ببینی.</strong></span></p>
                    <ul class="list-inline position-relative justify-content-center justify-content-lg-start mb-4">
                        <li class="list-inline-item me-2"><i class="bi bi-patch-check-fill h6 me-1"></i>آزمون‌های چهارگزینه‌ای با تصحیح خودکار</li>
                        <li class="list-inline-item me-2"><i class="bi bi-patch-check-fill h6 me-1"></i>کارنامه، درصد و سطح مهارت</li>
                        <li class="list-inline-item"><i class="bi bi-patch-check-fill h6 me-1"></i>دوره‌های پروژه‌محور و رایگان</li>
                    </ul>
                </div>
                <div class="col-lg-7 col-xl-6 text-center position-relative">
                    <img src="https://images.pexels.com/photos/2653362/pexels-photo-2653362.jpeg?cs=srgb&dl=pexels-harold-vasquez-853421-2653362.jpg&fm=jpg" alt="پنل آزمون و آموزش برنامه‌نویسی devcode" class="img-fluid" width="711" height="427" fetchpriority="high" decoding="async">
                </div>
            </div>
        </div>
    </section>
    <style>
        .icon-xl img {
            width: 64px;
            height: 64px;
            transition: transform 0.3s ease, filter 0.3s ease;
            animation: floatIcon 3s ease-in-out infinite;
        }
        @keyframes floatIcon {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-6px);
            }
        }
        .btn-transition:hover .icon-xl img {
            transform: translateY(-10px) scale(1.08);
            filter: drop-shadow(0 0 10px rgba(0, 0, 0, 0.25));
        }
    </style>
    <section class="position-relative pb-0 pb-sm-5">
        <div class="container">
            <div class="">
                <div class="row mb-4">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="fs-3">مستندات زبان‌ها</h2>
                        <p class="mb-0">ترجمهٔ فارسی مستندات زبان‌های برنامه‌نویسی برای شروع و پیشرفت مرحله‌به‌مرحله.</p>
                    </div>
                </div>
                <div class="row g-4 justify-content-center">
                    @forelse($languages as $language)
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <div class="bg-primary bg-opacity-10 rounded-3 text-center p-3 position-relative btn-transition">
                            <a class="stretched-link" href="{{route('language.show',$language->slug)}}">
                                <div class="icon-xl bg-body mx-auto rounded-circle mb-3 d-flex align-items-center justify-content-center">
                                    <img class="rounded-5" src="{{asset('images/language/'.$language->logo) ?? 'https://raw.githubusercontent.com/devicons/devicon/master/icons/html5/html5-original.svg'}}" alt="لوگوی زبان {{$language->name}}" loading="lazy" decoding="async">
                                </div>
                                <h5 class="mb-1">{{display_language_name($language->name)}}</h5>
                            </a>
                        </div>
                    </div>
                    @empty
                        <span>زبان موجود نیست</span>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fs-3">جدیدترین آزمون‌ها</h2>
                    <p class="mb-0">لیست آزمون‌های آنلاین برای سنجش مهارت و ارزیابی سطح شما در حوزه‌های مختلف.</p>
                </div>
            </div>
            <div class="tab-content" id="course-pills-tabContent">
                <div class="tab-pane fade show active" id="course-pills-tabs-1" role="tabpanel" aria-labelledby="course-pills-tab-1">
                    <div class="row g-4">
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card shadow h-100">
                                <a href="exam/ui-ux-skill-test.html">
                                    <img src="{{ asset('app/assets/uploads/2025/09/ba3fc9cb-7c57-431d-ab9f-19a941296ae9.webp') }}" class="card-img-top" alt="آزمون مهارت UI/UX" loading="lazy" decoding="async">
                                </a>
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-between mb-2">
                                        <p class="badge bg-warning bg-opacity-10 text-warning">سطح: متوسط</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-normal">
                                            <a href="exam/ui-ux-skill-test.html">آزمون مهارت UI/UX — طراحی تجربه و رابط کاربری</a>
                                        </h5>
                                        <div class="avatar avatar-sm">
                                            <img class="avatar-img rounded-circle" src="{{ asset('app/assets/uploads/2025/09/57fb6688-3957-40e0-82a6-a84fd3c6a357.webp') }}" alt="طراح آزمون UI/UX" loading="lazy" decoding="async">
                                        </div>
                                    </div>
                                    <p class="text-truncate-2 mb-2">این آزمون برای سنجش درک شما از اصول تجربه کاربری، وایرفریم، پرسونای کاربر و مبانی طراحی UI طراحی شده است.</p>
                                </div>
                                <div class="card-footer pt-0 pb-3">
                                    <hr>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="h6 fw-light mb-0"><i class="far fa-clock text-danger me-2"></i>20 دقیقه</span>
                                        <span class="h6 fw-light mb-0"><i class="fas fa-question-circle text-orange me-2"></i>30 سؤال</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card shadow h-100">
                                <a href="exam/html-beginner-test.html">
                                    <img src="{{ asset('app/assets/uploads/2025/09/aaaa52a4-396f-42e6-9e66-75a7ae3a218e.webp') }}" class="card-img-top" alt="آزمون مفاهیم HTML" loading="lazy" decoding="async">
                                </a>
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-between mb-2">
                                        <p class="badge bg-success bg-opacity-10 text-success">سطح: مقدماتی</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-normal">
                                            <a href="exam/html-beginner-test.html">آزمون HTML — از مفاهیم پایه تا تگ‌های پرکاربرد</a>
                                        </h5>
                                        <div class="avatar avatar-sm">
                                            <img class="avatar-img rounded-circle" src="{{ asset('app/assets/uploads/2025/09/6b239324-e11a-4250-9194-31847d88fd0e.webp') }}" alt="طراح آزمون HTML" loading="lazy" decoding="async">
                                        </div>
                                    </div>
                                    <p class="text-truncate-2 mb-2">با این آزمون، تسلط خود را بر ساختار صفحه، تگ‌های متنی، تصاویر، لینک‌ها و فرم‌های ساده بررسی کنید.</p>
                                </div>
                                <div class="card-footer pt-0 pb-3">
                                    <hr>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="h6 fw-light mb-0"><i class="far fa-clock text-danger me-2"></i>15 دقیقه</span>
                                        <span class="h6 fw-light mb-0"><i class="fas fa-question-circle text-orange me-2"></i>25 سؤال</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card shadow h-100">
                                <a href="exam/javascript-zero-to-pro.html">
                                    <img src="{{ asset('app/assets/uploads/2025/09/dae08f69-17fa-46a9-8986-4827dfb34f1e.webp') }}" class="card-img-top" alt="آزمون JavaScript" loading="lazy" decoding="async">
                                </a>
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-between mb-2">
                                        <p class="badge bg-info bg-opacity-10 text-info">سطح: متوسط رو به پیشرفته</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-normal">
                                            <a href="exam/javascript-zero-to-pro.html">آزمون JavaScript — از پایه تا مفاهیم مدرن</a>
                                        </h5>
                                        <div class="avatar avatar-sm">
                                            <img class="avatar-img rounded-circle" src="{{ asset('app/assets/uploads/2025/09/5bd8cdda-04c5-4077-b31a-d54213761726.webp') }}" alt="طراح آزمون JavaScript" loading="lazy" decoding="async">
                                        </div>
                                    </div>
                                    <p class="text-truncate-2 mb-2">شامل سوالاتی درباره متغیرها، توابع، DOM، رویدادها، ES6 و مفاهیم آسنکرون مانند Promise و Async/Await.</p>
                                </div>
                                <div class="card-footer pt-0 pb-3">
                                    <hr>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="h6 fw-light mb-0"><i class="far fa-clock text-danger me-2"></i>30 دقیقه</span>
                                        <span class="h6 fw-light mb-0"><i class="fas fa-question-circle text-orange me-2"></i>40 سؤال</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card shadow h-100">
                                <a href="exam/python-zero-to-pro.html">
                                    <img src="{{ asset('app/assets/uploads/2025/09/3609e010-5d57-4e43-b2bd-abb8d0b860f0.webp') }}" class="card-img-top" alt="آزمون Python" loading="lazy" decoding="async">
                                </a>
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-between mb-2">
                                        <p class="badge bg-info bg-opacity-10 text-info">سطح: مقدماتی تا متوسط</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-normal">
                                            <a href="exam/python-zero-to-pro.html">آزمون Python — مفاهیم پایه، حلقه‌ها و دیتاست</a>
                                        </h5>
                                        <div class="avatar avatar-sm">
                                            <img class="avatar-img rounded-circle" src="{{ asset('app/assets/uploads/2025/09/feaca3f2-a25b-45ea-a9af-83b5f9934fa7.webp') }}" alt="طراح آزمون Python" loading="lazy" decoding="async">
                                        </div>
                                    </div>
                                    <p class="text-truncate-2 mb-2">مناسب برای بررسی آشنایی با سینتکس، نوع داده‌ها، شرط‌ها، حلقه‌ها و کار اولیه با کتابخانه‌ها.</p>
                                </div>
                                <div class="card-footer pt-0 pb-3">
                                    <hr>
                                    <div class="d-flex justify-content-between mt-2">
                                        <span class="h6 fw-light mb-0"><i class="far fa-clock text-danger me-2"></i>25 دقیقه</span>
                                        <span class="h6 fw-light mb-0"><i class="fas fa-question-circle text-orange me-2"></i>35 سؤال</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
