<div class="modal fade" id="resourceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">مدیریت منبع آموزشی</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="resource-form" action="{{ route('resources.storeOrUpdate') }}" method="POST">
                @csrf
                <input type="hidden" name="subject_id" id="resource-subject_id">

                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">عنوان منبع</label>
                        <input type="text" name="title" id="resource-title"
                               class="form-control"
                               placeholder="مثال: آموزش کامل Vue 3 + Laravel" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">لینک منبع</label>
                        <input type="url" name="url" id="resource-url"
                               class="form-control"
                               placeholder="https://youtube.com/..." required>
                        <small class="text-muted">لینک باید با https:// شروع شود.</small>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary">
                        <span id="resource-submit-text">ذخیره منبع</span>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<style>
    #resourceModal .modal-content {
        border-radius: 12px;
    }

    #resourceModal .form-control {
        background: #f8f9fa;
        border: 1px solid #ddd;
        padding: 0.7rem 1rem;
        border-radius: 8px;
    }

    #resourceModal .form-control:focus {
        background: #fff;
        border-color: #4a6cf7;
        box-shadow: 0 0 0 3px rgb(74 108 247 / 20%);
    }
</style>
