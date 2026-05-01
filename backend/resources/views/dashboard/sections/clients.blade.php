@extends('dashboard.layout')

@section('title', 'Our Clients')
@section('subtitle', 'Manage heading text shown in the clients section.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div style="border:1px solid #fecaca; background:#fef2f2; color:#b91c1c; border-radius:10px; padding:12px 14px; margin-bottom:16px; font-weight:600;">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="panel-head" style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap;">
            <div>
            <h2>Clients Section</h2>
            <p>Manage the logo, name, link, and active state for the client cards shown in the frontend clients section.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.clients.update') }}" id="clientsForm" enctype="multipart/form-data">
            @csrf

            <div class="field">
                <label for="clients_tag">Section Label</label>
                <input id="clients_tag" name="clients_tag" value="{{ old('clients_tag', $settings['clients_tag'] ?? 'Trusted By') }}" required>
            </div>

            <div class="field">
                <label for="clients_title">Section Title</label>
                <input id="clients_title" name="clients_title" value="{{ old('clients_title', $settings['clients_title'] ?? 'Our Clients') }}" required>
            </div>

            <input type="hidden" id="clients_items" name="clients_items" value="{{ old('clients_items', $settings['clients_items'] ?? '[]') }}">

            <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; margin-top:18px; margin-bottom:14px;">
                <div>
                    <h3 style="margin:0 0 4px; font-size:18px;">Client Cards</h3>
                    <p style="margin:0; color:#64748b; font-size:13px;">Upload a logo image for each client, then save the returned image path into the section data.</p>
                </div>
                <button type="button" class="btn-primary" id="addClientBtn">+ Add Client</button>
            </div>

            <div id="clientList" style="display:grid; gap:10px;"></div>
            <div id="clientPagination" style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; margin-top:12px;"></div>

            <div class="actions-row" style="margin-top:18px;">
                <button class="btn-primary" type="submit">Save Clients Section</button>
            </div>
        </form>
    </div>

    <div id="clientModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); z-index:1000; padding:22px;">
        <div style="max-width:680px; margin:0 auto; background:#fff; border-radius:14px; border:1px solid #d9e1ec; box-shadow:0 16px 44px rgba(15,23,42,0.25); max-height:90vh; overflow:auto;">
            <div style="padding:16px 18px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                <h3 id="clientModalTitle" style="margin:0; font-size:18px;">Add Client</h3>
                <button type="button" id="closeClientModalBtn" style="border:0; background:#f1f5f9; width:32px; height:32px; border-radius:8px; cursor:pointer;">x</button>
            </div>
            <div style="padding:16px 18px; display:grid; gap:12px;">
                <div class="field">
                    <label for="client_logo_file">Logo Image</label>
                    <input id="client_logo_file" type="file" accept="image/*,.svg">
                    <input id="client_logo_path" type="hidden">
                    <p class="hint">Upload a PNG, JPG, WebP, or SVG logo. The uploaded file will be stored and reused by path.</p>
                    <div id="client_logo_preview" style="margin-top:10px;"></div>
                </div>
                <div class="field">
                    <label for="client_name">Name</label>
                    <input id="client_name" type="text" maxlength="120">
                </div>
                <div class="field">
                    <label for="client_url">URL / Link</label>
                    <input id="client_url" type="text" maxlength="300">
                </div>
                <div class="field">
                    <div style="display:inline-flex; padding:4px; border-radius:999px; background:#f8fafc; border:1px solid #dbe4ee; gap:4px; flex-wrap:wrap;">
                        <button type="button" class="toggle-option" data-toggle-value="1" data-target="client">Active</button>
                        <button type="button" class="toggle-option" data-toggle-value="0" data-target="client">Inactive</button>
                    </div>
                </div>
            </div>
            <div style="padding:14px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" id="cancelClientModalBtn" style="border:1px solid #d1d5db; background:#fff; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer;">Cancel</button>
                <button type="button" class="btn-primary" id="saveClientBtn">Save Client</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const hiddenClients = document.getElementById('clients_items');
            const clientList = document.getElementById('clientList');
            const clientPagination = document.getElementById('clientPagination');
            const addClientBtn = document.getElementById('addClientBtn');
            const clientModal = document.getElementById('clientModal');
            const clientModalTitle = document.getElementById('clientModalTitle');
            const clientLogoFileInput = document.getElementById('client_logo_file');
            const clientLogoPathInput = document.getElementById('client_logo_path');
            const clientLogoPreview = document.getElementById('client_logo_preview');
            const clientNameInput = document.getElementById('client_name');
            const clientUrlInput = document.getElementById('client_url');
            const closeClientModalBtn = document.getElementById('closeClientModalBtn');
            const cancelClientModalBtn = document.getElementById('cancelClientModalBtn');
            const saveClientBtn = document.getElementById('saveClientBtn');
            const pageSize = 4;
            const uploadUrl = '{{ route('dashboard.clients.upload-logo') }}';
            const csrfToken = document.querySelector('#clientsForm input[name="_token"]').value;

            let clients = [];
            let editingIndex = null;
            let activeState = true;
            let currentPage = 1;
            let logoUploadInProgress = false;

            function parseInitial() {
                try {
                    const parsed = JSON.parse(hiddenClients.value || '[]');
                    clients = Array.isArray(parsed) ? parsed : [];
                } catch (e) {
                    clients = [];
                }
            }

            function escapeHtml(text) {
                return String(text)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function syncHidden() {
                hiddenClients.value = JSON.stringify(clients);
            }

            function totalPages(items) {
                return Math.max(1, Math.ceil(items.length / pageSize));
            }

            function clampPage(page) {
                return Math.min(Math.max(1, page), totalPages(clients));
            }

            function sliceForPage() {
                const start = (currentPage - 1) * pageSize;
                return clients.slice(start, start + pageSize).map(function (item, index) {
                    return { item: item, index: start + index };
                });
            }

            function renderPagination() {
                const pages = totalPages(clients);
                if (pages <= 1) {
                    clientPagination.innerHTML = '';
                    return;
                }

                clientPagination.innerHTML = ''
                    + '<span style="color:#64748b; font-size:13px; font-weight:600;">Clients ' + currentPage + ' of ' + pages + '</span>'
                    + '<div style="display:flex; gap:8px; flex-wrap:wrap;">'
                    + '<button type="button" data-page-action="prev" ' + (currentPage <= 1 ? 'disabled' : '') + ' style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer; opacity:' + (currentPage <= 1 ? '0.5' : '1') + ';">Previous</button>'
                    + '<button type="button" data-page-action="next" ' + (currentPage >= pages ? 'disabled' : '') + ' style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer; opacity:' + (currentPage >= pages ? '0.5' : '1') + ';">Next</button>'
                    + '</div>';

                clientPagination.querySelectorAll('button[data-page-action]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        currentPage = button.getAttribute('data-page-action') === 'next' ? currentPage + 1 : currentPage - 1;
                        renderList();
                    });
                });
            }

            function renderLogo(item) {
                const logo = String(item.logo || '').trim();
                if (!logo) {
                    return '<span style="display:inline-flex; align-items:center; justify-content:center; width:44px; height:44px; border-radius:12px; background:#f1f5f9; color:#334155; font-weight:800;">?</span>';
                }

                if (/^(https?:\/\/|\/)/i.test(logo)) {
                    return '<img src="' + escapeHtml(logo) + '" alt="' + escapeHtml(item.name || 'Client') + '" class="preview-img" style="max-height:44px; border-radius:12px; padding:4px;">';
                }

                return '<span style="display:inline-flex; align-items:center; justify-content:center; min-width:44px; height:44px; padding:0 10px; border-radius:12px; background:#f1f5f9; color:#0f172a; font-weight:800; font-size:18px;">' + escapeHtml(logo) + '</span>';
            }

            function renderLogoPreview(path) {
                const value = String(path || '').trim();
                if (!value) {
                    clientLogoPreview.innerHTML = '<div style="padding:10px 12px; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b; font-size:13px;">No logo uploaded yet.</div>';
                    return;
                }

                if (/^(https?:\/\/|\/)/i.test(value)) {
                    clientLogoPreview.innerHTML = '<img src="' + escapeHtml(value) + '" alt="Client logo preview" class="preview-img" style="max-height:64px;">';
                    return;
                }

                clientLogoPreview.innerHTML = '<div style="padding:10px 12px; border:1px dashed #cbd5e1; border-radius:10px; color:#334155; font-size:13px;">' + escapeHtml(value) + '</div>';
            }

            async function uploadLogoFile(file) {
                const formData = new FormData();
                formData.append('logo', file);

                logoUploadInProgress = true;
                saveClientBtn.disabled = true;

                try {
                    const response = await fetch(uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Upload failed');
                    }

                    const data = await response.json();
                    clientLogoPathInput.value = data.path || '';
                    renderLogoPreview(clientLogoPathInput.value);
                    return data.path || '';
                } finally {
                    logoUploadInProgress = false;
                    saveClientBtn.disabled = false;
                }
            }

            function renderList() {
                if (!clients.length) {
                    clientList.innerHTML = '<div style="padding:14px; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b;">No clients yet. Click "Add Client" to create one.</div>';
                    clientPagination.innerHTML = '';
                    syncHidden();
                    return;
                }

                currentPage = clampPage(currentPage);
                const pageItems = sliceForPage();

                clientList.innerHTML = pageItems.map(function (entry) {
                    const client = entry.item;
                    const index = entry.index;
                    const badge = client.active
                        ? '<span style="display:inline-flex; align-items:center; gap:6px; background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#22c55e;"></span>Active</span>'
                        : '<span style="display:inline-flex; align-items:center; gap:6px; background:#f8fafc; color:#475569; border:1px solid #cbd5e1; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#94a3b8;"></span>Inactive</span>';

                    return '<div style="border:1px solid #d9e1ec; border-radius:12px; padding:12px 14px; display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap;">'
                        + '<div style="display:flex; gap:12px; align-items:flex-start; flex-wrap:wrap;">'
                        + renderLogo(client)
                        + '<div style="display:flex; flex-direction:column; gap:4px;">'
                        + '<strong style="font-size:15px;">' + escapeHtml(client.name || '') + '</strong>'
                        + '<a href="' + escapeHtml(client.url || '#') + '" target="_blank" rel="noopener noreferrer" style="font-size:12px; color:#2563eb; text-decoration:none; word-break:break-all;">' + escapeHtml(client.url || '') + '</a>'
                        + '</div>'
                        + '</div>'
                        + badge
                        + '<div style="display:flex; gap:8px; flex-wrap:wrap; width:100%; margin-top:6px;">'
                        + '<button type="button" data-action="toggle" data-index="' + index + '" style="border:1px solid ' + (client.active ? '#86efac' : '#d1d5db') + '; background:' + (client.active ? '#dcfce7' : '#fff') + '; color:' + (client.active ? '#166534' : '#334155') + '; border-radius:999px; padding:8px 12px; font-weight:800; cursor:pointer;">' + (client.active ? 'Active' : 'Inactive') + '</button>'
                        + '<button type="button" data-action="edit" data-index="' + index + '" style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer;">Edit</button>'
                        + '<button type="button" data-action="delete" data-index="' + index + '" style="border:1px solid #fecaca; color:#b91c1c; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer;">Delete</button>'
                        + '</div>'
                        + '</div>';
                }).join('');

                renderPagination();
                syncHidden();
            }

            function setActiveState(value) {
                activeState = !!value;
                Array.from(clientModal.querySelectorAll('.toggle-option[data-target="client"]')).forEach(function (button) {
                    const isActive = button.getAttribute('data-toggle-value') === '1';
                    button.style.border = '0';
                    button.style.borderRadius = '999px';
                    button.style.padding = '9px 14px';
                    button.style.fontWeight = '700';
                    button.style.cursor = 'pointer';
                    button.style.transition = 'all .18s ease';
                    button.style.background = isActive === activeState ? (activeState ? '#16a34a' : '#e2e8f0') : 'transparent';
                    button.style.color = isActive === activeState ? (activeState ? '#fff' : '#0f172a') : '#475569';
                });
            }

            function openModal(index) {
                editingIndex = index;
                clientLogoFileInput.value = '';

                if (index === null) {
                    clientModalTitle.textContent = 'Add Client';
                    clientLogoPathInput.value = '';
                    clientNameInput.value = '';
                    clientUrlInput.value = '';
                    renderLogoPreview('');
                    setActiveState(true);
                } else {
                    const client = clients[index];
                    clientModalTitle.textContent = 'Edit Client';
                    clientLogoPathInput.value = client.logo || '';
                    clientNameInput.value = client.name || '';
                    clientUrlInput.value = client.url || '';
                    renderLogoPreview(client.logo || '');
                    setActiveState(!!client.active);
                }

                clientModal.style.display = 'block';
            }

            function closeModal() {
                clientModal.style.display = 'none';
                editingIndex = null;
            }

            function saveFromModal() {
                if (logoUploadInProgress) {
                    alert('Please wait for the logo upload to finish.');
                    return;
                }

                const logo = clientLogoPathInput.value.trim();
                const name = clientNameInput.value.trim();
                const url = clientUrlInput.value.trim();

                if (!name) {
                    alert('Please enter a client name.');
                    return;
                }

                if (!logo) {
                    alert('Please upload a client logo.');
                    return;
                }

                const client = {
                    logo: logo,
                    name: name,
                    url: url,
                    active: activeState
                };

                if (editingIndex === null) {
                    clients.push(client);
                } else {
                    clients[editingIndex] = client;
                }

                currentPage = clampPage(currentPage);
                closeModal();
                renderList();
            }

            addClientBtn.addEventListener('click', function () { openModal(null); });
            closeClientModalBtn.addEventListener('click', closeModal);
            cancelClientModalBtn.addEventListener('click', closeModal);
            saveClientBtn.addEventListener('click', saveFromModal);

            clientLogoFileInput.addEventListener('change', async function () {
                const file = clientLogoFileInput.files && clientLogoFileInput.files[0] ? clientLogoFileInput.files[0] : null;
                if (!file) return;

                try {
                    await uploadLogoFile(file);
                } catch (error) {
                    clientLogoPathInput.value = '';
                    renderLogoPreview('');
                    alert('Could not upload the logo image. Please try again.');
                }
            });

            clientModal.addEventListener('click', function (event) {
                if (event.target === clientModal) closeModal();
            });

            clientModal.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-toggle-value][data-target="client"]');
                if (!button) return;
                setActiveState(button.getAttribute('data-toggle-value') === '1');
            });

            clientList.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-action]');
                if (!button) return;

                const action = button.getAttribute('data-action');
                const index = Number(button.getAttribute('data-index'));
                if (!Number.isInteger(index) || index < 0 || index >= clients.length) return;

                if (action === 'edit') {
                    openModal(index);
                    return;
                }

                if (action === 'delete') {
                    if (clients.length === 1) {
                        alert('At least one client is required.');
                        return;
                    }

                    clients.splice(index, 1);
                    currentPage = clampPage(currentPage);
                    renderList();
                    return;
                }

                if (action === 'toggle') {
                    clients[index].active = !clients[index].active;
                    renderList();
                }
            });

            parseInitial();
            if (!clients.length) {
                clients = [
                    { logo: '/vite.svg', name: 'Client Name', url: '', active: true }
                ];
            }

            setActiveState(true);
            renderLogoPreview('');
            renderList();
        })();
    </script>
@endsection
