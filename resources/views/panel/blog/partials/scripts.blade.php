<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/translations/fa.js"></script>

<style>
    .drop-zone { border: 2px dashed #ccc; border-radius: .5rem; padding: 2rem; text-align: center; background: #fafafa; transition: .3s; cursor: pointer; }
    .drop-zone.dragover { border-color: #1976d2; background: #e3f2fd; }
    .image-preview img { max-height: 180px; border-radius: .375rem; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
    .tag-input-container { border: 1px solid #ced4da; border-radius: .375rem; padding: .5rem; min-height: 50px; background: #fff; }
    .selected-tags { display: flex; flex-wrap: wrap; gap: .35rem; margin-bottom: .25rem; }
    .tag-chip { background: #e3f2fd; color: #1976d2; padding: .25rem .6rem; border-radius: 1rem; font-size: .85rem; font-weight: 500; }
    .tag-chip .remove-tag { margin-left: .5rem; cursor: pointer; color: #d32f2f; font-weight: bold; }
    .tag-list { max-height: 180px; overflow-y: auto; border: 1px solid #ddd; border-radius: .375rem; margin-top: .5rem; background: #fafafa; padding: .5rem; display: none; flex-wrap: wrap; gap: .4rem; }
    .tag-item { padding: .35rem .7rem; background: #f5f5f5; border: 1px solid #e0e0e0; border-radius: .375rem; cursor: pointer; }
    .tag-item:hover { background: #e3f2fd; border-color: #1976d2; color: #1976d2; }
    .tag-item.text-success { background: #e8f5e8 !important; border-color: #4caf50 !important; color: #2e7d32 !important; }
    .ck-editor__editable { min-height: 420px !important; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isEdit = !!document.getElementById('post-form-edit');
        const formId = isEdit ? 'post-form-edit' : 'post-form';
        const editorId = isEdit ? '#editor-edit' : '#editor-create';
        const contentId = isEdit ? '#content-edit' : '#content-create';
        const dropZoneId = isEdit ? '#drop-zone-edit' : '#drop-zone-create';
        const inputId = isEdit ? '#image-input-edit' : '#image-input-create';
        const previewId = isEdit ? '#image-preview-edit' : '#image-preview-create';

        // Drag & Drop
        const dropZone = document.querySelector(dropZoneId);
        const fileInput = document.querySelector(inputId);
        const preview = document.querySelector(previewId);
        if (dropZone && fileInput) {
            dropZone.addEventListener('click', () => fileInput.click());
            fileInput.addEventListener('change', () => fileInput.files[0] && showPreview(fileInput.files[0]));
            ['dragover', 'dragenter'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('dragover'); }));
            ['dragleave', 'dragend'].forEach(e => dropZone.addEventListener(e, () => dropZone.classList.remove('dragover')));
            dropZone.addEventListener('drop', e => {
                e.preventDefault(); dropZone.classList.remove('dragover');
                if (e.dataTransfer.files[0]?.type.startsWith('image/')) {
                    fileInput.files = e.dataTransfer.files;
                    showPreview(e.dataTransfer.files[0]);
                }
            });
            function showPreview(file) {
                const reader = new FileReader();
                reader.onload = e => preview.innerHTML = `<img src="${e.target.result}" alt="پیش‌نمایش">`;
                reader.readAsDataURL(file);
            }
        }

        // تگ‌ها
        const allTags = @json(\App\Models\Tag::pluck('name')->toArray());
        const selectedTagsInput = document.getElementById('selected_tags');
        const tagChips = document.getElementById('tag-chips');
        const tagSearch = document.getElementById('tag-search');
        const tagList = document.getElementById('tag-list');

        let selected = selectedTagsInput.value ? selectedTagsInput.value.split('|').map(t => t.trim()).filter(Boolean) : [];

        function render() {
            tagChips.innerHTML = '';
            selected.forEach(t => {
                const chip = document.createElement('span');
                chip.className = 'tag-chip';
                chip.innerHTML = `${t} <span class="remove-tag">×</span>`;
                chip.querySelector('.remove-tag').onclick = () => { selected = selected.filter(x => x !== t); render(); filter(); };
                tagChips.appendChild(chip);
            });
            selectedTagsInput.value = selected.join('|');
        }

        function filter() {
            const q = tagSearch.value.trim().toLowerCase();
            tagList.innerHTML = '';
            tagList.style.display = 'flex';

            if (!q) { allTags.forEach(t => !selected.includes(t) && addItem(t)); return; }

            const filtered = allTags.filter(t => t.toLowerCase().includes(q) && !selected.includes(t));
            filtered.forEach(addItem);

            if (!allTags.some(t => t.toLowerCase() === q)) {
                const item = document.createElement('div');
                item.className = 'tag-item text-success';
                item.innerHTML = `<strong>+ ایجاد: "${q}"</strong>`;
                item.onclick = () => { selected.push(q); tagSearch.value = ''; render(); filter(); };
                tagList.prepend(item);
            }
        }

        function addItem(name) {
            const item = document.createElement('div');
            item.className = 'tag-item';
            item.textContent = name;
            item.onclick = () => { selected.push(name); tagSearch.value = ''; render(); filter(); };
            tagList.appendChild(item);
        }

        tagSearch.addEventListener('keydown', e => e.key === 'Enter' && e.preventDefault() && tagSearch.value.trim() && (selected.push(tagSearch.value.trim()), tagSearch.value = '', render(), filter()));
        tagSearch.addEventListener('input', filter);
        tagSearch.addEventListener('focus', filter);
        document.addEventListener('click', e => {!tagSearch.contains(e.target) && !tagList.contains(e.target) && (tagList.style.display = 'none')});

        render();
        filter();

        // CKEditor
        ClassicEditor.create(document.querySelector(editorId), { language: 'fa' })
            .then(editor => {
                document.getElementById(formId).addEventListener('submit', () => {
                    document.querySelector(contentId).value = editor.getData();
                });
            });
    });
</script>
