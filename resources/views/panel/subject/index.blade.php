@extends('panel.layouts.master')
@section('title', 'مدیریت موضوعات')
@section('content')
    <div class="contentbar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30 shadow-sm">
                    <!-- Header کارت -->
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="feather icon-book-open"></i> مدیریت موضوعات
                        </h5>
                        <a href="{{ route('subject.create') }}" class="btn btn-primary-rgba">
                            <i class="feather icon-plus"></i> ایجاد موضوع جدید
                        </a>
                    </div>
                    <div class="card-body">
                        <!-- پیام موفقیت -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- وقتی موضوعی وجود ندارد -->
                        @if($subjects->isEmpty())
                            <div class="text-center py-5">
                                <img src="{{ asset('panel/assets/images/empty.svg') }}" alt="خالی" width="180" class="mb-4 opacity-75">
                                <p class="text-muted fs-5">هنوز هیچ موضوعی ایجاد نشده است.</p>
                                <a href="{{ route('subject.create') }}" class="btn btn-primary-rgba">
                                    ایجاد اولین موضوع
                                </a>
                            </div>
                        @else
                            <!-- جدول موضوعات -->
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle">
                                    <thead>
                                    <tr style="border-bottom: 2px solid #ebebeb;">
                                        <th>#</th>
                                        <th>عنوان</th>
                                        <th>زبان</th>
                                        <th>توضیحات</th>
                                        <th>منبع</th>
                                        <th>تاریخ ایجاد</th>
                                        <th class="text-center">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($subjects as $index => $subject)
                                        <tr>
                                            <td>{{ $loop->iteration + ($subjects->currentPage() - 1) * $subjects->perPage() }}</td>
                                            <td><strong>{{ Str::limit($subject->title, 50) }}</strong></td>
                                            <td>
                                                <span class="badge text-white px-3 py-2"
                                                      style="background-color: {{ $subject->language?->primary_color ?? '#666' }}">
                                                    {{ $subject->language?->name ?? 'نامشخص' }}
                                                </span>
                                            </td>
                                            <td><small class="text-muted">{{ Str::limit(strip_tags($subject->description), 70) }}</small></td>
                                            <td>
                                                @if($subject->resource)
                                                    <span class="badge badge-success">دارد</span>
                                                @else
                                                    <span class="badge badge-secondary">ندارد</span>
                                                @endif
                                            </td>
                                            <td>{{ datejallali($subject->created_at, 1) }}</td>
                                            <td class="text-center">
                                                <div class="button-list">
                                                    <!-- ویرایش (صفحه جداگانه) -->
                                                    <a href="{{ route('subject.edit', $subject->slug) }}"
                                                       class="btn btn-success-rgba btn-sm" title="ویرایش">
                                                        <i class="feather icon-edit-2"></i>
                                                    </a>

                                                    <!-- مدیریت منبع (مودال) -->
                                                    <button type="button"
                                                            class="btn btn-info-rgba btn-sm"
                                                            title="منبع"
                                                            onclick="openResourceModal({{ $subject->id }}, {{ $subject->resource ? $subject->resource->toJson() : 'null' }})">
                                                        <i class="feather icon-link"></i>
                                                    </button>

                                                    <!-- حذف -->
                                                    <form action="{{ route('subject.destroy', $subject->slug) }}"
                                                          method="POST" style="display:inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-danger-rgba btn-sm"
                                                                title="حذف"
                                                                onclick="return confirm('آیا از حذف «{{ addslashes($subject->title) }}» مطمئن هستید؟')">
                                                            <i class="feather icon-trash-2"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- صفحه‌بندی -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $subjects->appends(request()->query())->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('panel.subject.modals.resource')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openResourceModal(subjectId, resource = null) {
            const form = document.getElementById('resource-form');
            const titleInput = document.getElementById('resource-title');
            const urlInput = document.getElementById('resource-url');
            const subjectInput = document.getElementById('resource-subject_id');
            const submitText = document.getElementById('resource-submit-text');

            subjectInput.value = subjectId;

            // یک روت برای ایجاد/ویرایش دارید پس آدرس همیشه یکی است
            form.action = "{{ route('resources.storeOrUpdate') }}";

            if (resource) {
                titleInput.value = resource.title || '';
                urlInput.value = resource.url || '';
                submitText.textContent = 'به‌روزرسانی منبع';

                // اضافه کردن id برای آپدیت
                if (!document.getElementById('resource-id')) {
                    let idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'id';
                    idInput.id = 'resource-id';
                    form.appendChild(idInput);
                }
                document.getElementById('resource-id').value = resource.id;

            } else {
                // حذف hidden id اگر قبلاً اضافه شده
                const idInput = document.getElementById('resource-id');
                if (idInput) idInput.remove();

                titleInput.value = '';
                urlInput.value = '';
                submitText.textContent = 'ذخیره منبع';
            }

            // بوت‌استرپ ۵ – باز کردن مدال
            let modal = new bootstrap.Modal(document.getElementById('resourceModal'));
            modal.show();
        }
    </script>

@endsection

