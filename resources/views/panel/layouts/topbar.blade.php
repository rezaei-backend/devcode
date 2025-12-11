<!-- Start Topbar Mobile -->
<div class="topbar-mobile">
    <div class="row align-items-center">
        <div class="col-md-12">
            <div class="mobile-togglebar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="topbar-toggle-icon">
                            <a class="topbar-toggle-hamburger" href="#">
                                <img src="{{ asset('panel/assets/images/svg-icon/horizontal.svg') }}" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                <img src="{{ asset('panel/assets/images/svg-icon/verticle.svg') }}" class="img-fluid menu-hamburger-vertical" alt="verticle">
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="menubar">
                            <a class="menu-hamburger" href="#">
                                <img src="{{ asset('panel/assets/images/svg-icon/collapse.svg') }}" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                <img src="{{ asset('panel/assets/images/svg-icon/close.svg') }}" class="img-fluid menu-hamburger-close" alt="close">
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Topbar Mobile -->

<!-- Start Topbar -->
<div class="topbar">
    <div class="row align-items-center">
        <div class="col-md-12 align-self-center">
            <div class="togglebar">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item">
                        <div class="menubar">
                            <a class="menu-hamburger" href="#">
                                <img src="{{ asset('panel/assets/images/svg-icon/collapse.svg') }}" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                <img src="{{ asset('panel/assets/images/svg-icon/close.svg') }}" class="img-fluid menu-hamburger-close" alt="close">
                            </a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        <div class="searchbar">
                            @yield('searchbar')
                        </div>
                    </li>
                </ul>
            </div>

            <div class="infobar">
                <ul class="list-inline mb-0">
                    @php
                        $recentActivities = \App\Models\ActivityLog::latest()->limit(5)->get();
                        $latestActivityId = $recentActivities->first()->id ?? 0;
                        $hasNewActivity = $recentActivities->isNotEmpty();
                    @endphp

                    <li class="list-inline-item">
                        <div class="notifybar">
                            <div class="dropdown">
                                <a class="dropdown-toggle infobar-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('panel/assets/images/svg-icon/notifications.svg') }}" class="img-fluid" alt="notifications">
                                    <span class="live-icon {{ $hasNewActivity ? 'blink' : 'hidden' }}"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" style="width: 360px;">
                                    <div class="notification-dropdown-title d-flex justify-content-between align-items-center p-3 border-bottom">
                                        <h4 class="mb-0">فعالیت‌های اخیر</h4>
                                        <a href="#" class="btn btn-danger-rgba" data-toggle="modal" data-target="#deleteNotificationsModal">
                                            <i class="feather icon-trash"></i>
                                        </a>
                                    </div>

                                    <div style="max-height: 350px; overflow-y: auto;">
                                        <ul class="list-unstyled">
                                            @forelse($recentActivities as $activity)
                                                <li class="media dropdown-item px-3 py-2 hover-bg">
                                                    <span class="action-icon badge badge-info-inverse"><i class="feather icon-bell"></i></span>
                                                    <div class="media-body ml-3">
                                                        <p class="mb-1 text-sm text-gray-600">
                                                            {{ $activity->description }}
                                                        </p>
                                                        @if($activity->user)
                                                            <small class="text-primary">(توسط: {{ $activity->user->name  }})</small>
                                                        @endif
                                                        <span class="timing text-muted d-block">{{ $activity->jalali_time }}</span>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="dropdown-item text-center text-muted py-4">هیچ فعالیتی وجود ندارد</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="list-inline-item">
                        <div class="profilebar">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('panel/assets/images/users/profile.svg') }}" class="img-fluid rounded-circle" width="38" height="38" alt="profile">
                                    <span class="feather icon-chevron-down live-icon"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-item text-center py-3">
                                        <h5 class="mb-0">{{ auth()->user()->name ?? 'ادمین' }}</h5>
                                        @if($settings?->site_name)<small class="text-muted">{{ $settings->site_name }}</small>@endif
                                    </div>
                                    <div class="userbox">
                                        <ul class="list-unstyled mb-0">
                                            <li class="media dropdown-item">
                                                <form action="{{ route('logout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="profile-icon btn btn-link">
                                                        <img
                                                            src="{{ asset('panel/assets/images/svg-icon/logout.svg') }}"
                                                            class="img-fluid" alt="logout">خروج
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Topbar -->

<!-- Modal حذف نوتیفیکیشن‌ها -->
<div class="modal fade" id="deleteNotificationsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-gradient-danger text-white border-0">
                <h5 class="modal-title">حذف نوتیفیکیشن‌ها</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <p>آیا از حذف تمامی نوتیفیکیشن‌ها مطمئن هستید؟</p>
                <form action="{{ route('activity-logs.destroy') }}" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-gradient-danger px-4">بله، حذف کن</button>
                    <button type="button" class="btn btn-outline-secondary px-4" data-dismiss="modal">لغو</button>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('ok'))
    <div class="alert alert-primary custom-toast">{{ session('ok') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger custom-toast">{{ session('error') }}</div>
@endif

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .live-icon.blink { animation: blinker 1.5s linear infinite; }
    @keyframes blinker { 50% { opacity: 0.3; } }
    .custom-toast { position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); border-radius: 8px; }
    .hover-bg:hover { background: rgba(0,0,0,0.03); }
    .btn-danger-rgba, .btn-gradient-danger { background: rgba(220,53,69,0.1); color: #dc3545; border: none; border-radius: 6px; }
    .btn-danger-rgba:hover, .btn-gradient-danger:hover { background: #dc3545; color: white; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const icon = document.querySelector('.infobar-icon');
        const live = document.querySelector('.live-icon');
        const latestId = {{ $latestActivityId }};
        const lastSeen = localStorage.getItem('lastSeenActivityId') || 0;

        if (latestId > lastSeen) live?.classList.add('blink');

        icon?.addEventListener('click', () => {
            if (live?.classList.contains('blink')) {
                live.classList.remove('blink');
                live.classList.add('hidden');
                localStorage.setItem('lastSeenActivityId', latestId);
            }
        });
    });
</script>
