<section>
    <header>
        <h2 class="card-title mb-0">حذف حساب</h2>
        <p class="text-muted mt-2">پس از حذف حساب، تمام منابع و داده‌های آن برای همیشه حذف می‌شوند. لطفاً قبل از حذف، داده‌های مورد نیاز خود را دانلود کنید.</p>
    </header>

    <div class="mt-4">
        <button type="button" class="btn btn-danger-rgba" data-toggle="modal" data-target="#deleteUserModal">
            <i class="feather icon-trash"></i> حذف حساب
        </button>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-gradient-danger text-white border-0">
                    <h5 class="modal-title" id="deleteUserModalLabel">حذف حساب</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body p-4 text-center">
                    <i class="feather icon-alert-triangle fa-3x text-danger mb-3"></i>
                    <p class="mb-4">آیا از حذف حساب خود مطمئن هستید؟</p>
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="form-group">
                            <label for="password" class="form-label">رمز عبور</label>
                            <input id="password" name="password" type="password" class="form-control" placeholder="رمز عبور">
                            @error('password', 'userDeletion')
                            <span class="text-danger mt-2 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-gradient-danger px-4 py-2 ml-2">بله، حذف کن</button>
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" data-dismiss="modal">لغو</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
