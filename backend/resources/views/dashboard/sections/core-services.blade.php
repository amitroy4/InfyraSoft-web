@extends('dashboard.layout')

@section('title', 'Our Core Services')
@section('subtitle', 'Add, edit, activate/inactivate, and delete service cards from one place.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head" style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap;">
            <div>
                <h2>Core Services Section</h2>
                <p>Manage section heading and service cards. Each service includes icon, title, details, and key points.</p>
            </div>
            <button type="button" class="btn-primary" id="addServiceBtn">+ Add Service</button>
        </div>

        <form method="POST" action="{{ route('dashboard.core-services.update') }}" id="coreServicesForm">
            @csrf

            <div class="field">
                <label for="core_services_title">Section Title</label>
                <input id="core_services_title" name="core_services_title" value="{{ old('core_services_title', $settings['core_services_title']) }}" required>
            </div>

            <div class="field">
                <label for="core_services_subtitle">Section Subtitle</label>
                <textarea id="core_services_subtitle" name="core_services_subtitle" required>{{ old('core_services_subtitle', $settings['core_services_subtitle']) }}</textarea>
            </div>

            <input type="hidden" id="core_services_items" name="core_services_items" value="{{ old('core_services_items', $settings['core_services_items']) }}">

            <div id="serviceList" style="display:grid; gap:12px; margin-top:10px;"></div>

            <div class="actions-row">
                <button class="btn-primary" type="submit">Save Core Services</button>
            </div>
        </form>
    </div>

    <div id="serviceModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); z-index:1000; padding:22px;">
        <div style="max-width:760px; margin:0 auto; background:#fff; border-radius:14px; border:1px solid #d9e1ec; box-shadow:0 16px 44px rgba(15,23,42,0.25); max-height:90vh; overflow:auto;">
            <div style="padding:16px 18px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                <h3 id="modalTitle" style="margin:0; font-size:18px;">Add Service</h3>
                <button type="button" id="closeModalBtn" style="border:0; background:#f1f5f9; width:32px; height:32px; border-radius:8px; cursor:pointer;">x</button>
            </div>
            <div style="padding:16px 18px;">
                <div class="grid">
                    <div class="field">
                        <label for="modal_icon">Icon (Emoji)</label>
                        <input id="modal_icon" type="text" maxlength="20">
                    </div>
                    <div class="field">
                        <label for="modal_title">Title</label>
                        <input id="modal_title" type="text" maxlength="220">
                    </div>
                </div>
                <div class="field">
                    <label for="modal_details">Details</label>
                    <textarea id="modal_details" maxlength="1500"></textarea>
                </div>
                <div class="field">
                    <label for="modal_key_points">Key Points (one per line)</label>
                    <textarea id="modal_key_points" maxlength="4000"></textarea>
                </div>
                <div class="field" style="margin-bottom:8px;">
                    <label style="display:flex; align-items:center; gap:8px; margin:0;">
                        <input id="modal_active" type="checkbox" checked>
                        Active
                    </label>
                </div>
            </div>
            <div style="padding:14px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" id="cancelModalBtn" style="border:1px solid #d1d5db; background:#fff; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer;">Cancel</button>
                <button type="button" class="btn-primary" id="saveServiceBtn">Save Service</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const hiddenInput = document.getElementById('core_services_items');
            const serviceList = document.getElementById('serviceList');
            const modal = document.getElementById('serviceModal');
            const modalTitle = document.getElementById('modalTitle');
            const addBtn = document.getElementById('addServiceBtn');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            const saveBtn = document.getElementById('saveServiceBtn');

            const iconInput = document.getElementById('modal_icon');
            const titleInput = document.getElementById('modal_title');
            const detailsInput = document.getElementById('modal_details');
            const keyPointsInput = document.getElementById('modal_key_points');
            const activeInput = document.getElementById('modal_active');

            let editingIndex = null;
            let services = [];

            function parseInitial() {
                try {
                    const parsed = JSON.parse(hiddenInput.value || '[]');
                    services = Array.isArray(parsed) ? parsed : [];
                } catch (e) {
                    services = [];
                }
            }

            function keyPointsToArray(raw) {
                return String(raw || '')
                    .split(/\r\n|\n|\r/)
                    .map(function (p) { return p.trim(); })
                    .filter(function (p) { return p.length > 0; });
            }

            function serviceKeyPointsText(item) {
                if (Array.isArray(item.key_points)) return item.key_points.join('\n');
                return String(item.key_points || '');
            }

            function syncHidden() {
                hiddenInput.value = JSON.stringify(services);
            }

            function escapeHtml(text) {
                return String(text)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function renderList() {
                if (!services.length) {
                    serviceList.innerHTML = '<div style="padding:14px; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b;">No services yet. Click "Add Service" to create one.</div>';
                    syncHidden();
                    return;
                }

                serviceList.innerHTML = services.map(function (item, index) {
                    const points = Array.isArray(item.key_points) ? item.key_points : keyPointsToArray(item.key_points);
                    const badge = item.active ? '<span style="background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; padding:2px 8px; border-radius:999px; font-size:12px; font-weight:700;">Active</span>' : '<span style="background:#f8fafc; color:#475569; border:1px solid #cbd5e1; padding:2px 8px; border-radius:999px; font-size:12px; font-weight:700;">Inactive</span>';

                    return '<div style="border:1px solid #d9e1ec; border-radius:12px; padding:12px 14px;">'
                        + '<div style="display:flex; justify-content:space-between; align-items:center; gap:8px;">'
                        + '<div style="display:flex; align-items:center; gap:8px;">'
                        + '<span style="font-size:20px;">' + escapeHtml(item.icon || '') + '</span>'
                        + '<strong>' + escapeHtml(item.title || '') + '</strong>'
                        + badge
                        + '</div>'
                        + '<div style="display:flex; gap:8px;">'
                        + '<button type="button" data-action="toggle" data-index="' + index + '" style="border:1px solid #d1d5db; background:#fff; border-radius:8px; padding:6px 9px; cursor:pointer;">' + (item.active ? 'Inactivate' : 'Activate') + '</button>'
                        + '<button type="button" data-action="edit" data-index="' + index + '" style="border:1px solid #d1d5db; background:#fff; border-radius:8px; padding:6px 9px; cursor:pointer;">Edit</button>'
                        + '<button type="button" data-action="delete" data-index="' + index + '" style="border:1px solid #fecaca; color:#b91c1c; background:#fff; border-radius:8px; padding:6px 9px; cursor:pointer;">Delete</button>'
                        + '</div>'
                        + '</div>'
                        + '<p style="margin:10px 0 8px; color:#475569;">' + escapeHtml(item.details || '') + '</p>'
                        + '<div style="display:flex; flex-wrap:wrap; gap:6px;">'
                        + points.map(function (p) { return '<span style="font-size:12px; background:#f1f5f9; color:#334155; border-radius:999px; padding:4px 8px;">' + escapeHtml(p) + '</span>'; }).join('')
                        + '</div>'
                        + '</div>';
                }).join('');

                syncHidden();
            }

            function openModal(index) {
                editingIndex = index;

                if (index === null) {
                    modalTitle.textContent = 'Add Service';
                    iconInput.value = '';
                    titleInput.value = '';
                    detailsInput.value = '';
                    keyPointsInput.value = '';
                    activeInput.checked = true;
                } else {
                    const item = services[index];
                    modalTitle.textContent = 'Edit Service';
                    iconInput.value = item.icon || '';
                    titleInput.value = item.title || '';
                    detailsInput.value = item.details || '';
                    keyPointsInput.value = serviceKeyPointsText(item);
                    activeInput.checked = !!item.active;
                }

                modal.style.display = 'block';
            }

            function closeModal() {
                modal.style.display = 'none';
                editingIndex = null;
            }

            function saveFromModal() {
                const icon = iconInput.value.trim();
                const title = titleInput.value.trim();
                const details = detailsInput.value.trim();
                const keyPoints = keyPointsToArray(keyPointsInput.value);
                const active = activeInput.checked;

                if (!icon || !title || !details || !keyPoints.length) {
                    alert('Please fill icon, title, details, and at least one key point.');
                    return;
                }

                const item = {
                    icon: icon,
                    title: title,
                    details: details,
                    key_points: keyPoints,
                    active: active
                };

                if (editingIndex === null) {
                    services.push(item);
                } else {
                    services[editingIndex] = item;
                }

                closeModal();
                renderList();
            }

            addBtn.addEventListener('click', function () { openModal(null); });
            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);
            saveBtn.addEventListener('click', saveFromModal);

            modal.addEventListener('click', function (event) {
                if (event.target === modal) closeModal();
            });

            serviceList.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-action]');
                if (!button) return;

                const action = button.getAttribute('data-action');
                const index = Number(button.getAttribute('data-index'));
                if (!Number.isInteger(index) || index < 0 || index >= services.length) return;

                if (action === 'edit') {
                    openModal(index);
                    return;
                }

                if (action === 'delete') {
                    services.splice(index, 1);
                    renderList();
                    return;
                }

                if (action === 'toggle') {
                    services[index].active = !services[index].active;
                    renderList();
                }
            });

            parseInitial();
            renderList();
        })();
    </script>
@endsection
