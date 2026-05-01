@extends('dashboard.layout')

@section('title', 'Ready-Made Software Products')
@section('subtitle', 'Manage product categories and product cards shown in the frontend products section.')

@section('content')
    <div class="panel">
        @if (session('status'))
            <div class="success">{{ session('status') }}</div>
        @endif

        <div class="panel-head" style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px; flex-wrap:wrap;">
            <div>
                <h2>Products Section</h2>
                <p>Manage categories such as ERP, SaaS, Management, and custom product cards. Each product keeps logo, title, details, features, stack, demo message, and active state.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.products.update') }}" id="productsForm">
            @csrf

            <div class="field">
                <label for="products_title">Section Title</label>
                <input id="products_title" name="products_title" value="{{ old('products_title', $settings['products_title'] ?? 'Ready-Made Software Products') }}" required>
            </div>

            <div class="field">
                <label for="products_subtitle">Section Subtitle</label>
                <textarea id="products_subtitle" name="products_subtitle" required>{{ old('products_subtitle', $settings['products_subtitle'] ?? 'Battle-tested products ready to deploy or customize for your business.') }}</textarea>
            </div>

            <input type="hidden" id="products_categories" name="products_categories" value="{{ old('products_categories', $settings['products_categories'] ?? '[]') }}">
            <input type="hidden" id="products_items" name="products_items" value="{{ old('products_items', $settings['products_items'] ?? '[]') }}">

            <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:16px; margin-top:16px; align-items:start;">
                <div style="border:1px solid #d9e1ec; border-radius:14px; padding:16px; background:#fff;">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:14px; flex-wrap:wrap;">
                        <div>
                            <h3 style="margin:0 0 4px; font-size:18px;">Categories</h3>
                            <p style="margin:0; color:#64748b; font-size:13px;">ERP, SaaS, Management, and custom buckets.</p>
                        </div>
                        <button type="button" class="btn-primary" id="addCategoryBtn">+ Add Category</button>
                    </div>
                    <div id="categoryList" style="display:grid; gap:10px;"></div>
                    <div id="categoryPagination" style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; margin-top:12px;"></div>
                </div>

                <div style="border:1px solid #d9e1ec; border-radius:14px; padding:16px; background:#fff;">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:14px; flex-wrap:wrap;">
                        <div>
                            <h3 style="margin:0 0 4px; font-size:18px;">Products</h3>
                            <p style="margin:0; color:#64748b; font-size:13px;">Create product cards for each category.</p>
                        </div>
                        <button type="button" class="btn-primary" id="addProductBtn">+ Add Product</button>
                    </div>
                    <div id="productList" style="display:grid; gap:10px;"></div>
                    <div id="productPagination" style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; margin-top:12px;"></div>
                </div>
            </div>

            <div class="actions-row" style="margin-top:18px;">
                <button class="btn-primary" type="submit">Save Products Section</button>
            </div>
        </form>
    </div>

    <div id="categoryModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); z-index:1000; padding:22px;">
        <div style="max-width:620px; margin:0 auto; background:#fff; border-radius:14px; border:1px solid #d9e1ec; box-shadow:0 16px 44px rgba(15,23,42,0.25); max-height:90vh; overflow:auto;">
            <div style="padding:16px 18px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                <h3 id="categoryModalTitle" style="margin:0; font-size:18px;">Add Category</h3>
                <button type="button" id="closeCategoryModalBtn" style="border:0; background:#f1f5f9; width:32px; height:32px; border-radius:8px; cursor:pointer;">x</button>
            </div>
            <div style="padding:16px 18px; display:grid; gap:12px;">
                <div class="field">
                    <label for="category_name">Name</label>
                    <input id="category_name" type="text" maxlength="80">
                </div>
                <div class="field">
                    <label for="category_slug">Slug</label>
                    <input id="category_slug" type="text" maxlength="80">
                </div>
                <div class="field">
                    <label for="category_description">Description</label>
                    <textarea id="category_description" maxlength="200"></textarea>
                </div>
                <div class="field">
                    <div style="display:inline-flex; padding:4px; border-radius:999px; background:#f8fafc; border:1px solid #dbe4ee; gap:4px; flex-wrap:wrap;">
                        <button type="button" class="toggle-option" data-toggle-value="1" data-target="category">Active</button>
                        <button type="button" class="toggle-option" data-toggle-value="0" data-target="category">Inactive</button>
                    </div>
                </div>
            </div>
            <div style="padding:14px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" id="cancelCategoryModalBtn" style="border:1px solid #d1d5db; background:#fff; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer;">Cancel</button>
                <button type="button" class="btn-primary" id="saveCategoryBtn">Save Category</button>
            </div>
        </div>
    </div>

    <div id="productModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); z-index:1000; padding:22px;">
        <div style="max-width:860px; margin:0 auto; background:#fff; border-radius:14px; border:1px solid #d9e1ec; box-shadow:0 16px 44px rgba(15,23,42,0.25); max-height:90vh; overflow:auto;">
            <div style="padding:16px 18px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                <h3 id="productModalTitle" style="margin:0; font-size:18px;">Add Product</h3>
                <button type="button" id="closeProductModalBtn" style="border:0; background:#f1f5f9; width:32px; height:32px; border-radius:8px; cursor:pointer;">x</button>
            </div>
            <div style="padding:16px 18px; display:grid; gap:12px;">
                <div class="grid">
                    <div class="field">
                        <label for="product_logo">Logo</label>
                        <input id="product_logo" type="text" maxlength="20">
                    </div>
                    <div class="field">
                        <label for="product_title">Title</label>
                        <input id="product_title" type="text" maxlength="220">
                    </div>
                </div>
                <div class="field">
                    <label for="product_category">Category</label>
                    <select id="product_category"></select>
                </div>
                <div class="field">
                    <label for="product_details">Details</label>
                    <textarea id="product_details" maxlength="1200"></textarea>
                </div>
                <div class="field">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:8px; flex-wrap:wrap;">
                        <label style="margin:0;">Features</label>
                        <button type="button" id="addFeatureBtn" style="border:1px solid #d1d5db; background:#fff; border-radius:8px; padding:6px 10px; font-weight:700; cursor:pointer;">+ Add Feature</button>
                    </div>
                    <div id="featureList" style="display:grid; gap:10px;"></div>
                </div>
                <div class="field">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:8px; flex-wrap:wrap;">
                        <label style="margin:0;">Stack</label>
                        <button type="button" id="addStackBtn" style="border:1px solid #d1d5db; background:#fff; border-radius:8px; padding:6px 10px; font-weight:700; cursor:pointer;">+ Add Stack</button>
                    </div>
                    <div id="stackList" style="display:grid; gap:10px;"></div>
                </div>
                <div class="field">
                    <label for="product_demo_message">Get Demo Message</label>
                    <input id="product_demo_message" type="text" maxlength="220">
                </div>
                <div class="field">
                    <div style="display:inline-flex; padding:4px; border-radius:999px; background:#f8fafc; border:1px solid #dbe4ee; gap:4px; flex-wrap:wrap;">
                        <button type="button" class="toggle-option" data-toggle-value="1" data-target="product">Active</button>
                        <button type="button" class="toggle-option" data-toggle-value="0" data-target="product">Inactive</button>
                    </div>
                </div>
            </div>
            <div style="padding:14px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" id="cancelProductModalBtn" style="border:1px solid #d1d5db; background:#fff; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer;">Cancel</button>
                <button type="button" class="btn-primary" id="saveProductBtn">Save Product</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const hiddenCategories = document.getElementById('products_categories');
            const hiddenProducts = document.getElementById('products_items');
            const categoryList = document.getElementById('categoryList');
            const productList = document.getElementById('productList');
            const categoryPagination = document.getElementById('categoryPagination');
            const productPagination = document.getElementById('productPagination');
            const categoryPageSize = 5;
            const productPageSize = 4;

            const categoryModal = document.getElementById('categoryModal');
            const categoryModalTitle = document.getElementById('categoryModalTitle');
            const categoryNameInput = document.getElementById('category_name');
            const categorySlugInput = document.getElementById('category_slug');
            const categoryDescriptionInput = document.getElementById('category_description');
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            const closeCategoryModalBtn = document.getElementById('closeCategoryModalBtn');
            const cancelCategoryModalBtn = document.getElementById('cancelCategoryModalBtn');
            const saveCategoryBtn = document.getElementById('saveCategoryBtn');

            const productModal = document.getElementById('productModal');
            const productModalTitle = document.getElementById('productModalTitle');
            const productLogoInput = document.getElementById('product_logo');
            const productTitleInput = document.getElementById('product_title');
            const productCategorySelect = document.getElementById('product_category');
            const productDetailsInput = document.getElementById('product_details');
            const featureList = document.getElementById('featureList');
            const stackList = document.getElementById('stackList');
            const productDemoMessageInput = document.getElementById('product_demo_message');
            const addProductBtn = document.getElementById('addProductBtn');
            const addFeatureBtn = document.getElementById('addFeatureBtn');
            const addStackBtn = document.getElementById('addStackBtn');
            const closeProductModalBtn = document.getElementById('closeProductModalBtn');
            const cancelProductModalBtn = document.getElementById('cancelProductModalBtn');
            const saveProductBtn = document.getElementById('saveProductBtn');

            let categories = [];
            let products = [];
            let editingCategoryIndex = null;
            let editingProductIndex = null;
            let categoryActiveState = true;
            let productActiveState = true;
            let categoryPage = 1;
            let productPage = 1;

            function parseInitial() {
                try {
                    const parsedCategories = JSON.parse(hiddenCategories.value || '[]');
                    categories = Array.isArray(parsedCategories) ? parsedCategories : [];
                } catch (e) {
                    categories = [];
                }

                try {
                    const parsedProducts = JSON.parse(hiddenProducts.value || '[]');
                    products = Array.isArray(parsedProducts) ? parsedProducts : [];
                } catch (e) {
                    products = [];
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

            function slugify(text) {
                const slug = String(text || '')
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');

                return slug || 'item';
            }

            function makeUniqueCategorySlug(baseSlug, ignoreIndex) {
                let slug = baseSlug || 'item';
                let suffix = 2;

                while (categories.some(function (category, index) {
                    return index !== ignoreIndex && category && category.slug === slug;
                })) {
                    slug = baseSlug + '-' + suffix;
                    suffix++;
                }

                return slug;
            }

            function syncHidden() {
                hiddenCategories.value = JSON.stringify(categories);
                hiddenProducts.value = JSON.stringify(products);
            }

            function createRow(value, placeholder) {
                const row = document.createElement('div');
                row.style.display = 'flex';
                row.style.gap = '8px';
                row.style.alignItems = 'center';

                const input = document.createElement('input');
                input.type = 'text';
                input.value = value || '';
                input.placeholder = placeholder;
                input.maxLength = 220;
                input.style.flex = '1';

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.textContent = 'Remove';
                removeBtn.style.border = '1px solid #fecaca';
                removeBtn.style.color = '#b91c1c';
                removeBtn.style.background = '#fff';
                removeBtn.style.borderRadius = '8px';
                removeBtn.style.padding = '8px 10px';
                removeBtn.style.cursor = 'pointer';
                removeBtn.addEventListener('click', function () {
                    row.remove();
                    if (!row.parentElement.children.length) {
                        row.parentElement.appendChild(createRow('', placeholder));
                    }
                });

                row.appendChild(input);
                row.appendChild(removeBtn);
                return row;
            }

            function renderRows(container, values, placeholder) {
                container.innerHTML = '';
                const items = Array.isArray(values) && values.length ? values : [''];
                items.forEach(function (value) {
                    container.appendChild(createRow(value, placeholder));
                });
            }

            function collectRows(container) {
                return Array.from(container.querySelectorAll('input'))
                    .map(function (input) { return input.value.trim(); })
                    .filter(function (value) { return value.length > 0; });
            }

            function totalPages(items, pageSize) {
                return Math.max(1, Math.ceil(items.length / pageSize));
            }

            function clampPage(page, items, pageSize) {
                return Math.min(Math.max(1, page), totalPages(items, pageSize));
            }

            function sliceForPage(items, page, pageSize) {
                const start = (page - 1) * pageSize;
                return items.slice(start, start + pageSize).map(function (item, index) {
                    return {
                        item: item,
                        index: start + index
                    };
                });
            }

            function renderPagination(container, items, page, pageSize, onPageChange, label) {
                const pages = totalPages(items, pageSize);
                if (pages <= 1) {
                    container.innerHTML = '';
                    return;
                }

                const prevDisabled = page <= 1 ? 'disabled' : '';
                const nextDisabled = page >= pages ? 'disabled' : '';

                container.innerHTML = ''
                    + '<span style="color:#64748b; font-size:13px; font-weight:600;">' + label + ' ' + page + ' of ' + pages + '</span>'
                    + '<div style="display:flex; gap:8px; flex-wrap:wrap;">'
                    + '<button type="button" data-page-action="prev" ' + prevDisabled + ' style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer; opacity:' + (page <= 1 ? '0.5' : '1') + ';">Previous</button>'
                    + '<button type="button" data-page-action="next" ' + nextDisabled + ' style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer; opacity:' + (page >= pages ? '0.5' : '1') + ';">Next</button>'
                    + '</div>';

                container.querySelectorAll('button[data-page-action]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        onPageChange(button.getAttribute('data-page-action'));
                    });
                });
            }

            function setCategoryActiveState(value) {
                categoryActiveState = !!value;
                Array.from(categoryModal.querySelectorAll('.toggle-option[data-target="category"]')).forEach(function (button) {
                    const isActive = button.getAttribute('data-toggle-value') === '1';
                    button.style.border = '0';
                    button.style.borderRadius = '999px';
                    button.style.padding = '9px 14px';
                    button.style.fontWeight = '700';
                    button.style.cursor = 'pointer';
                    button.style.transition = 'all .18s ease';
                    button.style.background = isActive === categoryActiveState ? (categoryActiveState ? '#16a34a' : '#e2e8f0') : 'transparent';
                    button.style.color = isActive === categoryActiveState ? (categoryActiveState ? '#fff' : '#0f172a') : '#475569';
                });
            }

            function setProductActiveState(value) {
                productActiveState = !!value;
                Array.from(productModal.querySelectorAll('.toggle-option[data-target="product"]')).forEach(function (button) {
                    const isActive = button.getAttribute('data-toggle-value') === '1';
                    button.style.border = '0';
                    button.style.borderRadius = '999px';
                    button.style.padding = '9px 14px';
                    button.style.fontWeight = '700';
                    button.style.cursor = 'pointer';
                    button.style.transition = 'all .18s ease';
                    button.style.background = isActive === productActiveState ? (productActiveState ? '#16a34a' : '#e2e8f0') : 'transparent';
                    button.style.color = isActive === productActiveState ? (productActiveState ? '#fff' : '#0f172a') : '#475569';
                });
            }

            function getFallbackCategorySlug() {
                const otherCategory = categories.find(function (category) {
                    return category && category.slug === 'other';
                });

                if (otherCategory) {
                    return otherCategory.slug;
                }

                return categories[0] ? categories[0].slug : 'other';
            }

            function categoryLabel(slug) {
                const category = categories.find(function (entry) {
                    return entry && entry.slug === slug;
                });

                return category ? category.name : 'Uncategorized';
            }

            function renderCategoryOptions(selectedSlug) {
                const fallbackSlug = getFallbackCategorySlug();
                const activeCategories = categories.length ? categories : [{ name: 'Other', slug: 'other', description: '', active: true }];

                productCategorySelect.innerHTML = activeCategories.map(function (category) {
                    const slug = category.slug || fallbackSlug;
                    return '<option value="' + escapeHtml(slug) + '"' + (slug === selectedSlug ? ' selected' : '') + '>' + escapeHtml(category.name || slug) + '</option>';
                }).join('');
            }

            function renderCategoryList() {
                if (!categories.length) {
                    categoryList.innerHTML = '<div style="padding:14px; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b;">No categories yet. Click "Add Category" to create one.</div>';
                    categoryPagination.innerHTML = '';
                    syncHidden();
                    return;
                }

                categoryPage = clampPage(categoryPage, categories, categoryPageSize);
                const pageItems = sliceForPage(categories, categoryPage, categoryPageSize);

                categoryList.innerHTML = pageItems.map(function (entry) {
                    const category = entry.item;
                    const index = entry.index;
                    const productCount = products.filter(function (product) { return product && product.category === category.slug; }).length;
                    const badge = category.active
                        ? '<span style="display:inline-flex; align-items:center; gap:6px; background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#22c55e;"></span>Active</span>'
                        : '<span style="display:inline-flex; align-items:center; gap:6px; background:#f8fafc; color:#475569; border:1px solid #cbd5e1; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#94a3b8;"></span>Inactive</span>';

                    return '<div style="border:1px solid #d9e1ec; border-radius:12px; padding:12px 14px;">'
                        + '<div style="display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap;">'
                        + '<div style="display:flex; flex-direction:column; gap:2px;">'
                        + '<strong style="font-size:15px;">' + escapeHtml(category.name || '') + '</strong>'
                        + '<span style="font-size:12px; color:#64748b;">' + escapeHtml(category.slug || '') + ' • ' + productCount + ' product(s)</span>'
                        + '</div>'
                        + badge
                        + '</div>'
                        + '<p style="margin:10px 0 0; color:#475569;">' + escapeHtml(category.description || '') + '</p>'
                        + '<div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:12px;">'
                        + '<button type="button" data-action="toggle-category" data-index="' + index + '" style="border:1px solid ' + (category.active ? '#86efac' : '#d1d5db') + '; background:' + (category.active ? '#dcfce7' : '#fff') + '; color:' + (category.active ? '#166534' : '#334155') + '; border-radius:999px; padding:8px 12px; font-weight:800; cursor:pointer;">' + (category.active ? 'Active' : 'Inactive') + '</button>'
                        + '<button type="button" data-action="edit-category" data-index="' + index + '" style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer;">Edit</button>'
                        + '<button type="button" data-action="delete-category" data-index="' + index + '" style="border:1px solid #fecaca; color:#b91c1c; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer;">Delete</button>'
                        + '</div>'
                        + '</div>';
                }).join('');

                renderPagination(categoryPagination, categories, categoryPage, categoryPageSize, function (direction) {
                    categoryPage = direction === 'next' ? categoryPage + 1 : categoryPage - 1;
                    renderCategoryList();
                }, 'Categories');

                syncHidden();
            }

            function renderProductList() {
                if (!products.length) {
                    productList.innerHTML = '<div style="padding:14px; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b;">No products yet. Click "Add Product" to create one.</div>';
                    productPagination.innerHTML = '';
                    syncHidden();
                    return;
                }

                productPage = clampPage(productPage, products, productPageSize);
                const pageItems = sliceForPage(products, productPage, productPageSize);

                productList.innerHTML = pageItems.map(function (entry) {
                    const product = entry.item;
                    const index = entry.index;
                    const features = Array.isArray(product.features) ? product.features : [];
                    const stack = Array.isArray(product.stack) ? product.stack : [];
                    const badge = product.active
                        ? '<span style="display:inline-flex; align-items:center; gap:6px; background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#22c55e;"></span>Active</span>'
                        : '<span style="display:inline-flex; align-items:center; gap:6px; background:#f8fafc; color:#475569; border:1px solid #cbd5e1; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#94a3b8;"></span>Inactive</span>';

                    return '<div style="border:1px solid #d9e1ec; border-radius:12px; padding:12px 14px;">'
                        + '<div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px; flex-wrap:wrap;">'
                        + '<div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">'
                        + '<span style="font-size:22px;">' + escapeHtml(product.logo || '') + '</span>'
                        + '<div style="display:flex; flex-direction:column; gap:4px;">'
                        + '<strong style="font-size:15px;">' + escapeHtml(product.title || '') + '</strong>'
                        + '<span style="font-size:12px; color:#64748b;">' + escapeHtml(categoryLabel(product.category)) + '</span>'
                        + '</div>'
                        + '</div>'
                        + badge
                        + '</div>'
                        + '<p style="margin:10px 0 8px; color:#475569;">' + escapeHtml(product.details || '') + '</p>'
                        + '<p style="margin:0 0 10px; color:#64748b; font-size:13px;">' + escapeHtml(product.demo_message || '') + '</p>'
                        + '<div style="display:grid; gap:10px;">'
                        + '<div><div style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; text-transform:uppercase; letter-spacing:.04em;">Features</div><div style="display:flex; flex-wrap:wrap; gap:6px;">' + features.map(function (feature) { return '<span style="font-size:12px; background:#f1f5f9; color:#334155; border-radius:999px; padding:4px 8px;">' + escapeHtml(feature) + '</span>'; }).join('') + '</div></div>'
                        + '<div><div style="font-size:11px; font-weight:800; color:#334155; margin-bottom:6px; text-transform:uppercase; letter-spacing:.04em;">Stack</div><div style="display:flex; flex-wrap:wrap; gap:6px;">' + stack.map(function (tech) { return '<span style="font-size:12px; background:#eff6ff; color:#1d4ed8; border-radius:999px; padding:4px 8px;">' + escapeHtml(tech) + '</span>'; }).join('') + '</div></div>'
                        + '</div>'
                        + '<div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:12px;">'
                        + '<button type="button" data-action="toggle-product" data-index="' + index + '" style="border:1px solid ' + (product.active ? '#86efac' : '#d1d5db') + '; background:' + (product.active ? '#dcfce7' : '#fff') + '; color:' + (product.active ? '#166534' : '#334155') + '; border-radius:999px; padding:8px 12px; font-weight:800; cursor:pointer;">' + (product.active ? 'Active' : 'Inactive') + '</button>'
                        + '<button type="button" data-action="edit-product" data-index="' + index + '" style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer;">Edit</button>'
                        + '<button type="button" data-action="delete-product" data-index="' + index + '" style="border:1px solid #fecaca; color:#b91c1c; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer;">Delete</button>'
                        + '</div>'
                        + '</div>';
                }).join('');

                renderPagination(productPagination, products, productPage, productPageSize, function (direction) {
                    productPage = direction === 'next' ? productPage + 1 : productPage - 1;
                    renderProductList();
                }, 'Products');

                syncHidden();
            }

            function openCategoryModal(index) {
                editingCategoryIndex = index;

                if (index === null) {
                    categoryModalTitle.textContent = 'Add Category';
                    categoryNameInput.value = '';
                    categorySlugInput.value = '';
                    categoryDescriptionInput.value = '';
                    setCategoryActiveState(true);
                } else {
                    const category = categories[index];
                    categoryModalTitle.textContent = 'Edit Category';
                    categoryNameInput.value = category.name || '';
                    categorySlugInput.value = category.slug || '';
                    categoryDescriptionInput.value = category.description || '';
                    setCategoryActiveState(!!category.active);
                }

                categoryModal.style.display = 'block';
            }

            function closeCategoryModal() {
                categoryModal.style.display = 'none';
                editingCategoryIndex = null;
            }

            function openProductModal(index) {
                editingProductIndex = index;

                const selectedCategory = categories[0] ? categories[0].slug : 'other';
                renderCategoryOptions(selectedCategory);

                if (index === null) {
                    productModalTitle.textContent = 'Add Product';
                    productLogoInput.value = '';
                    productTitleInput.value = '';
                    productDetailsInput.value = '';
                    productDemoMessageInput.value = '';
                    renderRows(featureList, [''], 'Enter a feature');
                    renderRows(stackList, [''], 'Enter a stack item');
                    renderCategoryOptions(getFallbackCategorySlug());
                    productCategorySelect.value = getFallbackCategorySlug();
                    setProductActiveState(true);
                } else {
                    const product = products[index];
                    productModalTitle.textContent = 'Edit Product';
                    productLogoInput.value = product.logo || '';
                    productTitleInput.value = product.title || '';
                    productDetailsInput.value = product.details || '';
                    productDemoMessageInput.value = product.demo_message || '';
                    renderRows(featureList, Array.isArray(product.features) ? product.features : [], 'Enter a feature');
                    renderRows(stackList, Array.isArray(product.stack) ? product.stack : [], 'Enter a stack item');
                    renderCategoryOptions(product.category || getFallbackCategorySlug());
                    productCategorySelect.value = product.category || getFallbackCategorySlug();
                    setProductActiveState(!!product.active);
                }

                productModal.style.display = 'block';
            }

            function closeProductModal() {
                productModal.style.display = 'none';
                editingProductIndex = null;
            }

            function saveCategoryFromModal() {
                const name = categoryNameInput.value.trim();
                const slugBase = categorySlugInput.value.trim() || slugify(name);
                const description = categoryDescriptionInput.value.trim();
                const active = categoryActiveState;

                if (!name) {
                    alert('Please enter a category name.');
                    return;
                }

                const slug = makeUniqueCategorySlug(slugBase, editingCategoryIndex);
                const category = {
                    name: name,
                    slug: slug,
                    description: description,
                    active: active
                };

                if (editingCategoryIndex === null) {
                    categories.push(category);
                } else {
                    const previousSlug = categories[editingCategoryIndex] ? categories[editingCategoryIndex].slug : null;
                    categories[editingCategoryIndex] = category;
                    if (previousSlug && previousSlug !== slug) {
                        products.forEach(function (product) {
                            if (product.category === previousSlug) {
                                product.category = slug;
                            }
                        });
                    }
                }

                closeCategoryModal();
                renderCategoryList();
                renderProductList();
            }

            function saveProductFromModal() {
                const logo = productLogoInput.value.trim();
                const title = productTitleInput.value.trim();
                const details = productDetailsInput.value.trim();
                const category = productCategorySelect.value || getFallbackCategorySlug();
                const features = collectRows(featureList);
                const stack = collectRows(stackList);
                const demoMessage = productDemoMessageInput.value.trim();

                if (!logo || !title || !details || !features.length || !stack.length) {
                    alert('Please fill logo, title, details, features, and stack.');
                    return;
                }

                const product = {
                    category: category,
                    logo: logo,
                    title: title,
                    details: details,
                    features: features,
                    stack: stack,
                    demo_message: demoMessage || 'Book a demo for ' + title,
                    active: productActiveState
                };

                if (editingProductIndex === null) {
                    products.push(product);
                } else {
                    products[editingProductIndex] = product;
                }

                closeProductModal();
                renderCategoryList();
                renderProductList();
            }

            addCategoryBtn.addEventListener('click', function () { openCategoryModal(null); });
            addProductBtn.addEventListener('click', function () { openProductModal(null); });

            closeCategoryModalBtn.addEventListener('click', closeCategoryModal);
            cancelCategoryModalBtn.addEventListener('click', closeCategoryModal);
            saveCategoryBtn.addEventListener('click', saveCategoryFromModal);

            closeProductModalBtn.addEventListener('click', closeProductModal);
            cancelProductModalBtn.addEventListener('click', closeProductModal);
            saveProductBtn.addEventListener('click', saveProductFromModal);

            addFeatureBtn.addEventListener('click', function () {
                featureList.appendChild(createRow('', 'Enter a feature'));
            });

            addStackBtn.addEventListener('click', function () {
                stackList.appendChild(createRow('', 'Enter a stack item'));
            });

            categoryModal.addEventListener('click', function (event) {
                if (event.target === categoryModal) closeCategoryModal();
            });

            productModal.addEventListener('click', function (event) {
                if (event.target === productModal) closeProductModal();
            });

            categoryModal.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-toggle-value][data-target="category"]');
                if (!button) return;
                setCategoryActiveState(button.getAttribute('data-toggle-value') === '1');
            });

            productModal.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-toggle-value][data-target="product"]');
                if (!button) return;
                setProductActiveState(button.getAttribute('data-toggle-value') === '1');
            });

            categoryList.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-action]');
                if (!button) return;

                const action = button.getAttribute('data-action');
                const index = Number(button.getAttribute('data-index'));
                if (!Number.isInteger(index) || index < 0 || index >= categories.length) return;

                if (action === 'edit-category') {
                    openCategoryModal(index);
                    return;
                }

                if (action === 'delete-category') {
                    if (categories.length === 1) {
                        alert('At least one category is required.');
                        return;
                    }

                    const slug = categories[index].slug;
                    const fallbackSlug = getFallbackCategorySlug();
                    categories.splice(index, 1);
                    products.forEach(function (product) {
                        if (product.category === slug) {
                            product.category = fallbackSlug;
                        }
                    });
                    categoryPage = clampPage(categoryPage, categories, categoryPageSize);
                    renderCategoryList();
                    renderProductList();
                    return;
                }

                if (action === 'toggle-category') {
                    categories[index].active = !categories[index].active;
                    renderCategoryList();
                }
            });

            productList.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-action]');
                if (!button) return;

                const action = button.getAttribute('data-action');
                const index = Number(button.getAttribute('data-index'));
                if (!Number.isInteger(index) || index < 0 || index >= products.length) return;

                if (action === 'edit-product') {
                    openProductModal(index);
                    return;
                }

                if (action === 'delete-product') {
                    products.splice(index, 1);
                    productPage = clampPage(productPage, products, productPageSize);
                    renderCategoryList();
                    renderProductList();
                    return;
                }

                if (action === 'toggle-product') {
                    products[index].active = !products[index].active;
                    renderProductList();
                }
            });

            parseInitial();
            if (!categories.length) {
                categories = [
                    { name: 'Other', slug: 'other', description: 'Custom or uncategorized products.', active: true }
                ];
            }

            setCategoryActiveState(true);
            setProductActiveState(true);
            renderCategoryList();
            renderProductList();
        })();
    </script>
@endsection
