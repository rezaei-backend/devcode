<section>
    <header>
        <h2 class="card-title mb-0">به‌روزرسانی رمز عبور</h2>
        <p class="text-muted mt-2">برای امنیت حساب، از یک رمز عبور طولانی و تصادفی استفاده کنید.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="form-label">رمز عبور فعلی</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
            @error('current_password', 'updatePassword')
            <span class="text-danger mt-2 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="update_password_password" class="form-label">رمز عبور جدید</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
            @error('password', 'updatePassword')
            <span class="text-danger mt-2 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="update_password_password_confirmation" class="form-label">تأیید رمز عبور جدید</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
            <span class="text-danger mt-2 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary-rgba">ذخیره</button>
            @if (session('status') === 'password-updated')
                <span class="text-success ml-3">ذخیره شد.</span>
            @endif
        </div>
    </form>
</section>
