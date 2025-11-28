<section>
    <header>
        <h2 class="card-title mb-0">اطلاعات پروفایل</h2>
        <p class="text-muted mt-2">اطلاعات پروفایل و ایمیل حساب خود را به‌روزرسانی کنید.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="first_name" class="form-label">نام</label>
            <input id="first_name" name="first_name" type="text" class="form-control" value="{{ old('first_name', $user->first_name) }}" required autofocus autocomplete="first_name">
            @error('first_name')
            <span class="text-danger mt-2 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="last_name" class="form-label">نام خانوادگی</label>
            <input id="last_name" name="last_name" type="text" class="form-control" value="{{ old('last_name', $user->last_name) }}" required autocomplete="last_name">
            @error('last_name')
            <span class="text-danger mt-2 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="phone" class="form-label">شماره تلفن</label>
            <input id="phone" name="phone" type="text" class="form-control" value="{{ old('phone', $user->phone) }}" required autocomplete="phone">
            @error('phone')
            <span class="text-danger mt-2 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="email" class="form-label">ایمیل</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
            <span class="text-danger mt-2 d-block">{{ $message }}</span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-muted">
                        ایمیل شما تأیید نشده است.
                        <button form="send-verification" class="btn btn-link p-0">برای ارسال مجدد ایمیل تأیید کلیک کنید.</button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success mt-2">لینک تأیید جدید به ایمیل شما ارسال شد.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary-rgba">ذخیره</button>
            @if (session('status') === 'profile-updated')
                <span class="text-success ml-3">ذخیره شد.</span>
            @endif
        </div>
    </form>
</section>
