@extends('Panel.Layouts.master')

@section('title', 'پروفایل کاربر')

@section('searchbar')
    <div class="input-group">
        <h5 class="card-title mb-0">مدیریت پروفایل</h5>
    </div>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <!-- Profile Editing Card -->
                <div class="card m-b-30 shadow-sm">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h5 class="card-title mb-0">ویرایش پروفایل</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- بخش ویرایش اطلاعات پروفایل -->
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">تغییر اطلاعات کاربری</h6>
                                    <form method="POST" action="{{ route('profile.update') }}">
                                        @csrf
                                        @method('PATCH')

                                        @if (session('status') === 'profile-updated')
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                اطلاعات پروفایل با موفقیت به‌روزرسانی شد.
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="name">نام</label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name', auth()->user()->name) }}" required autofocus autocomplete="name">
                                            @error('name')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="email">ایمیل</label>
                                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email', auth()->user()->email) }}" required autocomplete="username">
                                            @error('email')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                            @enderror

                                            @if (auth()->user()->email_verified_at)
                                                <p class="text-success mt-2"><i class="fas fa-check-circle"></i> ایمیل شما تأیید شده است.</p>
                                            @else
                                                <p class="text-warning mt-2"><i class="fas fa-exclamation-triangle"></i> ایمیل شما هنوز تأیید نشده است.</p>
                                            @endif
                                        </div>

                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary-rgba">ذخیره تغییرات</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- بخش تغییر رمز عبور -->
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <h6 class="mb-3">تغییر رمز عبور</h6>
                                    <form method="POST" action="{{ route('password.update') }}">
                                        @csrf
                                        @method('PUT')

                                        @if (session('status') === 'password-updated')
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                رمز عبور با موفقیت تغییر کرد.
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                            </div>
                                        @endif

                                        <div class="form-group">
                                            <label for="current_password">رمز عبور فعلی</label>
                                            <div class="input-group">
                                                <input type="password" name="current_password" id="current_password"
                                                       class="form-control @error('current_password') is-invalid @enderror" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text password-toggle" onclick="togglePassword('current_password')">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            @error('current_password')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password">رمز عبور جدید</label>
                                            <div class="input-group">
                                                <input type="password" name="password" id="password"
                                                       class="form-control @error('password') is-invalid @enderror" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text password-toggle" onclick="togglePassword('password')">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            @error('password')
                                            <span class="text-danger error-text">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="password_confirmation">تکرار رمز عبور جدید</label>
                                            <div class="input-group">
                                                <input type="password" name="password_confirmation" id="password_confirmation"
                                                       class="form-control" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text password-toggle" onclick="togglePassword('password_confirmation')">
                                                        <i class="fas fa-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary-rgba">تغییر رمز عبور</button>
                                    </form>
                                </div>
                            </div>

                            <!-- بخش حذف حساب -->
                            <div class="col-lg-12 mt-4">
                                <div class="card border-danger">
                                    <div class="card-body">
                                        <h6 class="text-danger">حذف حساب کاربری</h6>
                                        <p class="text-muted">پس از حذف حساب، تمام اطلاعات شما برای همیشه حذف خواهد شد و قابل بازگشت نیست.</p>
                                        <button type="button" class="btn btn-danger-rgba" data-toggle="modal" data-target="#deleteAccountModal">
                                            حذف دائمی حساب کاربری
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal حذف حساب -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-gradient-danger text-white border-0">
                    <h5 class="modal-title">حذف حساب کاربری</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body p-4 text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p class="mb-4">آیا از حذف دائمی حساب کاربری خود مطمئن هستید؟</p>
                    <p class="text-danger">این عملیات غیرقابل بازگشت است.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <div class="form-group mt-4">
                            <label>برای تأیید، رمز عبور خود را وارد کنید:</label>
                            <input type="password" name="password" class="form-control w-75 mx-auto" required>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-gradient-danger px-4 py-2 ml-2">بله، حساب را حذف کن</button>
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" data-dismiss="modal">لغو</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword(fieldId) {
            let input = document.getElementById(fieldId);
            let icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>

    <style>
        .table-borderless td, .table-borderless th { padding: 0.75rem; vertical-align: middle; }
        .password-toggle { cursor: pointer; }
        .form-group { margin-bottom: 1.5rem; }
        .btn-primary-rgba {
            background-color: rgba(0, 123, 255, 0.1);
            color: #007bff;
            border: 1px solid #007bff;
        }
        .btn-primary-rgba:hover { background-color: rgba(0, 123, 255, 0.2); }
        .btn-danger-rgba {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid #dc3545;
        }
        .btn-gradient-danger {
            background: linear-gradient(45deg, #dc3545, #c82333);
            color: white;
        }
        .text-danger { color: #dc3545 !important; }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
