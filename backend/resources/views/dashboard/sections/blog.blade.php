@extends('dashboard.layout')

@section('title', 'Case Studies & Blog')
@section('subtitle', 'Manage blog and case study categories, posts, and publishing state.')

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
                <h2>Case Studies & Blog Section</h2>
                <p>Manage categories and posts for case studies or blog entries. Each item keeps a title, image, category, date, details, and active state.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('dashboard.blog.update') }}" id="blogForm">
            @csrf

            <div class="field">
                <label for="blog_title">Section Title</label>
                <input id="blog_title" name="blog_title" value="{{ old('blog_title', $settings['blog_title'] ?? 'Case Studies & Blog') }}" required>
            </div>

            <div class="field">
                <label for="blog_subtitle">Section Subtitle</label>
                <textarea id="blog_subtitle" name="blog_subtitle" required>{{ old('blog_subtitle', $settings['blog_subtitle'] ?? 'Insights, success stories, and technical deep-dives from our team.') }}</textarea>
            </div>

            <input type="hidden" id="blog_categories" name="blog_categories" value="{{ old('blog_categories', $settings['blog_categories'] ?? '[]') }}">
            <input type="hidden" id="blog_items" name="blog_items" value="{{ old('blog_items', $settings['blog_items'] ?? '[]') }}">

            <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:16px; margin-top:16px; align-items:start;">
                <div style="border:1px solid #d9e1ec; border-radius:14px; padding:16px; background:#fff;">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:14px; flex-wrap:wrap;">
                        <div>
                            <h3 style="margin:0 0 4px; font-size:18px;">Categories</h3>
                            <p style="margin:0; color:#64748b; font-size:13px;">Create labels like Case Study, Blog, or Announcement.</p>
                        </div>
                        <button type="button" class="btn-primary" id="addBlogCategoryBtn">+ Add Category</button>
                    </div>
                    <div id="blogCategoryList" style="display:grid; gap:10px;"></div>
                    <div id="blogCategoryPagination" style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; margin-top:12px;"></div>
                </div>

                <div style="border:1px solid #d9e1ec; border-radius:14px; padding:16px; background:#fff;">
                    <div style="display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:14px; flex-wrap:wrap;">
                        <div>
                            <h3 style="margin:0 0 4px; font-size:18px;">Posts</h3>
                            <p style="margin:0; color:#64748b; font-size:13px;">Add case studies or blog posts and assign them to a category.</p>
                        </div>
                        <button type="button" class="btn-primary" id="addBlogPostBtn">+ Add Post</button>
                    </div>
                    <div id="blogPostList" style="display:grid; gap:10px;"></div>
                    <div id="blogPostPagination" style="display:flex; justify-content:space-between; align-items:center; gap:10px; flex-wrap:wrap; margin-top:12px;"></div>
                </div>
            </div>

            <div class="actions-row" style="margin-top:18px;">
                <button class="btn-primary" type="submit">Save Blog Section</button>
            </div>
        </form>
    </div>

    <div id="blogCategoryModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); z-index:1000; padding:22px;">
        <div style="max-width:620px; margin:0 auto; background:#fff; border-radius:14px; border:1px solid #d9e1ec; box-shadow:0 16px 44px rgba(15,23,42,0.25); max-height:90vh; overflow:auto;">
            <div style="padding:16px 18px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                <h3 id="blogCategoryModalTitle" style="margin:0; font-size:18px;">Add Category</h3>
                <button type="button" id="closeBlogCategoryModalBtn" style="border:0; background:#f1f5f9; width:32px; height:32px; border-radius:8px; cursor:pointer;">x</button>
            </div>
            <div style="padding:16px 18px; display:grid; gap:12px;">
                <div class="field">
                    <label for="blog_category_name">Name</label>
                    <input id="blog_category_name" type="text" maxlength="80">
                </div>
                <div class="field">
                    <label for="blog_category_slug">Slug</label>
                    <input id="blog_category_slug" type="text" maxlength="80">
                </div>
                <div class="field">
                    <label for="blog_category_description">Description</label>
                    <textarea id="blog_category_description" maxlength="200"></textarea>
                </div>
                <div class="field">
                    <div style="display:inline-flex; padding:4px; border-radius:999px; background:#f8fafc; border:1px solid #dbe4ee; gap:4px; flex-wrap:wrap;">
                        <button type="button" class="toggle-option" data-toggle-value="1" data-target="blog-category">Active</button>
                        <button type="button" class="toggle-option" data-toggle-value="0" data-target="blog-category">Inactive</button>
                    </div>
                </div>
            </div>
            <div style="padding:14px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" id="cancelBlogCategoryModalBtn" style="border:1px solid #d1d5db; background:#fff; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer;">Cancel</button>
                <button type="button" class="btn-primary" id="saveBlogCategoryBtn">Save Category</button>
            </div>
        </div>
    </div>

    <div id="blogPostModal" style="display:none; position:fixed; inset:0; background:rgba(15,23,42,0.55); z-index:1000; padding:22px;">
        <div style="max-width:760px; margin:0 auto; background:#fff; border-radius:14px; border:1px solid #d9e1ec; box-shadow:0 16px 44px rgba(15,23,42,0.25); max-height:90vh; overflow:auto;">
            <div style="padding:16px 18px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; gap:10px;">
                <h3 id="blogPostModalTitle" style="margin:0; font-size:18px;">Add Post</h3>
                <button type="button" id="closeBlogPostModalBtn" style="border:0; background:#f1f5f9; width:32px; height:32px; border-radius:8px; cursor:pointer;">x</button>
            </div>
            <div style="padding:16px 18px; display:grid; gap:12px;">
                <div class="field">
                    <label for="blog_post_image_file">Image</label>
                    <input id="blog_post_image_file" type="file" accept="image/*,.svg">
                    <input id="blog_post_image_path" type="hidden">
                    <p class="hint">Upload a feature image for the post. The uploaded file will be stored and reused by path.</p>
                    <div id="blog_post_image_preview" style="margin-top:10px;"></div>
                </div>
                <div class="grid">
                    <div class="field">
                        <label for="blog_post_title">Title</label>
                        <input id="blog_post_title" type="text" maxlength="220">
                    </div>
                    <div class="field">
                        <label for="blog_post_date">Date</label>
                        <input id="blog_post_date" type="date">
                    </div>
                </div>
                <div class="field">
                    <label for="blog_post_category">Category</label>
                    <select id="blog_post_category"></select>
                </div>
                <div class="field">
                    <label for="blog_post_details">Details</label>
                    <textarea id="blog_post_details" maxlength="2000"></textarea>
                </div>
                <div class="field">
                    <div style="display:inline-flex; padding:4px; border-radius:999px; background:#f8fafc; border:1px solid #dbe4ee; gap:4px; flex-wrap:wrap;">
                        <button type="button" class="toggle-option" data-toggle-value="1" data-target="blog-post">Active</button>
                        <button type="button" class="toggle-option" data-toggle-value="0" data-target="blog-post">Inactive</button>
                    </div>
                </div>
            </div>
            <div style="padding:14px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
                <button type="button" id="cancelBlogPostModalBtn" style="border:1px solid #d1d5db; background:#fff; border-radius:10px; padding:10px 14px; font-weight:700; cursor:pointer;">Cancel</button>
                <button type="button" class="btn-primary" id="saveBlogPostBtn">Save Post</button>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const hiddenCategories = document.getElementById('blog_categories');
            const hiddenPosts = document.getElementById('blog_items');
            const categoryList = document.getElementById('blogCategoryList');
            const postList = document.getElementById('blogPostList');
            const categoryPagination = document.getElementById('blogCategoryPagination');
            const postPagination = document.getElementById('blogPostPagination');
            const categoryPageSize = 4;
            const postPageSize = 4;

            const addBlogCategoryBtn = document.getElementById('addBlogCategoryBtn');
            const addBlogPostBtn = document.getElementById('addBlogPostBtn');

            const categoryModal = document.getElementById('blogCategoryModal');
            const categoryModalTitle = document.getElementById('blogCategoryModalTitle');
            const categoryNameInput = document.getElementById('blog_category_name');
            const categorySlugInput = document.getElementById('blog_category_slug');
            const categoryDescriptionInput = document.getElementById('blog_category_description');
            const closeCategoryModalBtn = document.getElementById('closeBlogCategoryModalBtn');
            const cancelCategoryModalBtn = document.getElementById('cancelBlogCategoryModalBtn');
            const saveCategoryBtn = document.getElementById('saveBlogCategoryBtn');

            const postModal = document.getElementById('blogPostModal');
            const postModalTitle = document.getElementById('blogPostModalTitle');
            const postImageFileInput = document.getElementById('blog_post_image_file');
            const postImagePathInput = document.getElementById('blog_post_image_path');
            const postImagePreview = document.getElementById('blog_post_image_preview');
            const postTitleInput = document.getElementById('blog_post_title');
            const postDateInput = document.getElementById('blog_post_date');
            const postCategorySelect = document.getElementById('blog_post_category');
            const postDetailsInput = document.getElementById('blog_post_details');
            const closePostModalBtn = document.getElementById('closeBlogPostModalBtn');
            const cancelPostModalBtn = document.getElementById('cancelBlogPostModalBtn');
            const savePostBtn = document.getElementById('saveBlogPostBtn');

            const uploadUrl = '{{ route('dashboard.blog.upload-image') }}';
            const csrfToken = document.querySelector('#blogForm input[name="_token"]').value;

            let categories = [];
            let posts = [];
            let categoryPage = 1;
            let postPage = 1;
            let editingCategoryIndex = null;
            let editingPostIndex = null;
            let categoryActiveState = true;
            let postActiveState = true;
            let postImageUploading = false;

            function parseInitial() {
                try {
                    const parsedCategories = JSON.parse(hiddenCategories.value || '[]');
                    categories = Array.isArray(parsedCategories) ? parsedCategories : [];
                } catch (error) {
                    categories = [];
                }

                try {
                    const parsedPosts = JSON.parse(hiddenPosts.value || '[]');
                    posts = Array.isArray(parsedPosts) ? parsedPosts : [];
                } catch (error) {
                    posts = [];
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
                hiddenCategories.value = JSON.stringify(categories);
                hiddenPosts.value = JSON.stringify(posts);
            }

            function slugify(text) {
                const slug = String(text || '')
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');

                return slug || 'item';
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
                    return { item: item, index: start + index };
                });
            }

            function renderPagination(container, items, page, pageSize, onPageChange, label) {
                const pages = totalPages(items, pageSize);
                if (pages <= 1) {
                    container.innerHTML = '';
                    return;
                }

                container.innerHTML = ''
                    + '<span style="color:#64748b; font-size:13px; font-weight:600;">' + label + ' ' + page + ' of ' + pages + '</span>'
                    + '<div style="display:flex; gap:8px; flex-wrap:wrap;">'
                    + '<button type="button" data-page-action="prev" ' + (page <= 1 ? 'disabled' : '') + ' style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer; opacity:' + (page <= 1 ? '0.5' : '1') + ';">Previous</button>'
                    + '<button type="button" data-page-action="next" ' + (page >= pages ? 'disabled' : '') + ' style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer; opacity:' + (page >= pages ? '0.5' : '1') + ';">Next</button>'
                    + '</div>';

                container.querySelectorAll('button[data-page-action]').forEach(function (button) {
                    button.addEventListener('click', function () {
                        onPageChange(button.getAttribute('data-page-action'));
                    });
                });
            }

            function setCategoryActiveState(value) {
                categoryActiveState = !!value;
                Array.from(categoryModal.querySelectorAll('.toggle-option[data-target="blog-category"]')).forEach(function (button) {
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

            function setPostActiveState(value) {
                postActiveState = !!value;
                Array.from(postModal.querySelectorAll('.toggle-option[data-target="blog-post"]')).forEach(function (button) {
                    const isActive = button.getAttribute('data-toggle-value') === '1';
                    button.style.border = '0';
                    button.style.borderRadius = '999px';
                    button.style.padding = '9px 14px';
                    button.style.fontWeight = '700';
                    button.style.cursor = 'pointer';
                    button.style.transition = 'all .18s ease';
                    button.style.background = isActive === postActiveState ? (postActiveState ? '#16a34a' : '#e2e8f0') : 'transparent';
                    button.style.color = isActive === postActiveState ? (postActiveState ? '#fff' : '#0f172a') : '#475569';
                });
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

            function getFallbackCategorySlug() {
                const activeCategory = categories.find(function (category) { return category && category.active; });
                return (activeCategory && activeCategory.slug) || (categories[0] ? categories[0].slug : 'blog');
            }

            function categoryLabel(slug) {
                const category = categories.find(function (entry) {
                    return entry && entry.slug === slug;
                });

                return category ? category.name : 'Uncategorized';
            }

            function renderCategoryOptions(selectedSlug) {
                const fallbackSlug = getFallbackCategorySlug();
                const list = categories.length ? categories : [{ name: 'Blog', slug: 'blog', description: '', active: true }];

                postCategorySelect.innerHTML = list.map(function (category) {
                    const slug = category.slug || fallbackSlug;
                    return '<option value="' + escapeHtml(slug) + '"' + (slug === selectedSlug ? ' selected' : '') + '>' + escapeHtml(category.name || slug) + '</option>';
                }).join('');
            }

            function renderCategoryList() {
                if (!categories.length) {
                    categoryList.innerHTML = '<div style="padding:14px; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b;">No categories yet. Click "Add Category" to create one.</div>';
                    categoryPagination.innerHTML = '';
                    syncHidden();
                    renderCategoryOptions(getFallbackCategorySlug());
                    return;
                }

                categoryPage = clampPage(categoryPage, categories, categoryPageSize);
                const pageItems = sliceForPage(categories, categoryPage, categoryPageSize);

                categoryList.innerHTML = pageItems.map(function (entry) {
                    const category = entry.item;
                    const index = entry.index;
                    const postCount = posts.filter(function (post) { return post && post.category === category.slug; }).length;
                    const badge = category.active
                        ? '<span style="display:inline-flex; align-items:center; gap:6px; background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#22c55e;"></span>Active</span>'
                        : '<span style="display:inline-flex; align-items:center; gap:6px; background:#f8fafc; color:#475569; border:1px solid #cbd5e1; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#94a3b8;"></span>Inactive</span>';

                    return '<div style="border:1px solid #d9e1ec; border-radius:12px; padding:12px 14px;">'
                        + '<div style="display:flex; justify-content:space-between; align-items:center; gap:8px; flex-wrap:wrap;">'
                        + '<div style="display:flex; flex-direction:column; gap:2px;">'
                        + '<strong style="font-size:15px;">' + escapeHtml(category.name || '') + '</strong>'
                        + '<span style="font-size:12px; color:#64748b;">' + escapeHtml(category.slug || '') + ' • ' + postCount + ' post(s)</span>'
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
                    renderCategoryOptions(postCategorySelect.value || getFallbackCategorySlug());
                }, 'Categories');

                renderCategoryOptions(postCategorySelect.value || getFallbackCategorySlug());
                syncHidden();
            }

            function renderImage(item) {
                const image = String(item.image || '').trim();
                if (!image) {
                    return '<div style="width:88px; height:64px; border-radius:12px; background:#f1f5f9; border:1px dashed #cbd5e1;"></div>';
                }

                return '<img src="' + escapeHtml(image) + '" alt="' + escapeHtml(item.title || 'Post image') + '" class="preview-img" style="max-height:64px;">';
            }

            function renderImagePreview(path) {
                const value = String(path || '').trim();
                if (!value) {
                    postImagePreview.innerHTML = '<div style="padding:10px 12px; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b; font-size:13px;">No image uploaded yet.</div>';
                    return;
                }

                postImagePreview.innerHTML = '<img src="' + escapeHtml(value) + '" alt="Post image preview" class="preview-img" style="max-height:88px;">';
            }

            async function uploadPostImage(file) {
                const formData = new FormData();
                formData.append('image', file);

                postImageUploading = true;
                savePostBtn.disabled = true;

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
                    postImagePathInput.value = data.path || '';
                    renderImagePreview(postImagePathInput.value);
                    return data.path || '';
                } finally {
                    postImageUploading = false;
                    savePostBtn.disabled = false;
                }
            }

            function renderPostList() {
                if (!posts.length) {
                    postList.innerHTML = '<div style="padding:14px; border:1px dashed #cbd5e1; border-radius:10px; color:#64748b;">No posts yet. Click "Add Post" to create one.</div>';
                    postPagination.innerHTML = '';
                    syncHidden();
                    return;
                }

                postPage = clampPage(postPage, posts, postPageSize);
                const pageItems = sliceForPage(posts, postPage, postPageSize);

                postList.innerHTML = pageItems.map(function (entry) {
                    const post = entry.item;
                    const index = entry.index;
                    const badge = post.active
                        ? '<span style="display:inline-flex; align-items:center; gap:6px; background:#ecfdf3; color:#166534; border:1px solid #bbf7d0; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#22c55e;"></span>Active</span>'
                        : '<span style="display:inline-flex; align-items:center; gap:6px; background:#f8fafc; color:#475569; border:1px solid #cbd5e1; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800;"><span style="width:8px; height:8px; border-radius:999px; background:#94a3b8;"></span>Inactive</span>';

                    return '<div style="border:1px solid #d9e1ec; border-radius:12px; padding:12px 14px;">'
                        + '<div style="display:flex; justify-content:space-between; align-items:flex-start; gap:10px; flex-wrap:wrap;">'
                        + '<div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">'
                        + renderImage(post)
                        + '<div style="display:flex; flex-direction:column; gap:4px;">'
                        + '<strong style="font-size:15px;">' + escapeHtml(post.title || '') + '</strong>'
                        + '<span style="font-size:12px; color:#64748b;">' + escapeHtml(categoryLabel(post.category)) + ' • ' + escapeHtml(post.date || '') + '</span>'
                        + '</div>'
                        + '</div>'
                        + badge
                        + '</div>'
                        + '<p style="margin:10px 0 8px; color:#475569;">' + escapeHtml(post.details || '') + '</p>'
                        + '<div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:12px;">'
                        + '<button type="button" data-action="toggle-post" data-index="' + index + '" style="border:1px solid ' + (post.active ? '#86efac' : '#d1d5db') + '; background:' + (post.active ? '#dcfce7' : '#fff') + '; color:' + (post.active ? '#166534' : '#334155') + '; border-radius:999px; padding:8px 12px; font-weight:800; cursor:pointer;">' + (post.active ? 'Active' : 'Inactive') + '</button>'
                        + '<button type="button" data-action="edit-post" data-index="' + index + '" style="border:1px solid #d1d5db; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer;">Edit</button>'
                        + '<button type="button" data-action="delete-post" data-index="' + index + '" style="border:1px solid #fecaca; color:#b91c1c; background:#fff; border-radius:999px; padding:8px 12px; font-weight:700; cursor:pointer;">Delete</button>'
                        + '</div>'
                        + '</div>';
                }).join('');

                renderPagination(postPagination, posts, postPage, postPageSize, function (direction) {
                    postPage = direction === 'next' ? postPage + 1 : postPage - 1;
                    renderPostList();
                }, 'Posts');

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

            function saveCategoryFromModal() {
                const name = categoryNameInput.value.trim();
                const slugBase = categorySlugInput.value.trim() || slugify(name);
                const description = categoryDescriptionInput.value.trim();
                const active = categoryActiveState;

                if (!name) {
                    alert('Please enter a category name.');
                    return;
                }

                const category = {
                    name: name,
                    slug: makeUniqueCategorySlug(slugBase, editingCategoryIndex),
                    description: description,
                    active: active
                };

                if (editingCategoryIndex === null) {
                    categories.push(category);
                } else {
                    const previousSlug = categories[editingCategoryIndex] ? categories[editingCategoryIndex].slug : null;
                    categories[editingCategoryIndex] = category;
                    if (previousSlug && previousSlug !== category.slug) {
                        posts.forEach(function (post) {
                            if (post.category === previousSlug) {
                                post.category = category.slug;
                            }
                        });
                    }
                }

                categoryPage = clampPage(categoryPage, categories, categoryPageSize);
                closeCategoryModal();
                renderCategoryList();
                renderPostList();
            }

            function openPostModal(index) {
                editingPostIndex = index;
                postImageFileInput.value = '';
                postImagePathInput.value = '';

                if (index === null) {
                    postModalTitle.textContent = 'Add Post';
                    postTitleInput.value = '';
                    postDateInput.value = '';
                    postDetailsInput.value = '';
                    renderCategoryOptions(getFallbackCategorySlug());
                    postImagePreview.innerHTML = '';
                    setPostActiveState(true);
                } else {
                    const post = posts[index];
                    postModalTitle.textContent = 'Edit Post';
                    postTitleInput.value = post.title || '';
                    postDateInput.value = post.date || '';
                    postDetailsInput.value = post.details || '';
                    postImagePathInput.value = post.image || '';
                    renderCategoryOptions(post.category || getFallbackCategorySlug());
                    renderImagePreview(post.image || '');
                    setPostActiveState(!!post.active);
                }

                postModal.style.display = 'block';
            }

            function closePostModal() {
                postModal.style.display = 'none';
                editingPostIndex = null;
            }

            async function savePostFromModal() {
                if (postImageUploading) {
                    alert('Please wait for the image upload to finish.');
                    return;
                }

                const image = postImagePathInput.value.trim();
                const title = postTitleInput.value.trim();
                const date = postDateInput.value.trim();
                const category = postCategorySelect.value || getFallbackCategorySlug();
                const details = postDetailsInput.value.trim();

                if (!image || !title || !date || !details) {
                    alert('Please upload an image, enter a title, choose a date, and add details.');
                    return;
                }

                const post = {
                    category: category,
                    title: title,
                    image: image,
                    date: date,
                    details: details,
                    active: postActiveState
                };

                if (editingPostIndex === null) {
                    posts.push(post);
                } else {
                    posts[editingPostIndex] = post;
                }

                postPage = clampPage(postPage, posts, postPageSize);
                closePostModal();
                renderCategoryList();
                renderPostList();
            }

            addBlogCategoryBtn.addEventListener('click', function () { openCategoryModal(null); });
            addBlogPostBtn.addEventListener('click', function () { openPostModal(null); });

            closeCategoryModalBtn.addEventListener('click', closeCategoryModal);
            cancelCategoryModalBtn.addEventListener('click', closeCategoryModal);
            saveCategoryBtn.addEventListener('click', saveCategoryFromModal);

            closePostModalBtn.addEventListener('click', closePostModal);
            cancelPostModalBtn.addEventListener('click', closePostModal);
            savePostBtn.addEventListener('click', savePostFromModal);

            categoryModal.addEventListener('click', function (event) {
                if (event.target === categoryModal) closeCategoryModal();
            });

            postModal.addEventListener('click', function (event) {
                if (event.target === postModal) closePostModal();
            });

            categoryModal.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-toggle-value][data-target="blog-category"]');
                if (!button) return;
                setCategoryActiveState(button.getAttribute('data-toggle-value') === '1');
            });

            postModal.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-toggle-value][data-target="blog-post"]');
                if (!button) return;
                setPostActiveState(button.getAttribute('data-toggle-value') === '1');
            });

            postImageFileInput.addEventListener('change', async function () {
                const file = postImageFileInput.files && postImageFileInput.files[0] ? postImageFileInput.files[0] : null;
                if (!file) return;

                try {
                    await uploadPostImage(file);
                } catch (error) {
                    postImagePathInput.value = '';
                    renderImagePreview('');
                    alert('Could not upload the post image. Please try again.');
                }
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
                    posts.forEach(function (post) {
                        if (post.category === slug) {
                            post.category = fallbackSlug;
                        }
                    });
                    categoryPage = clampPage(categoryPage, categories, categoryPageSize);
                    renderCategoryList();
                    renderPostList();
                    return;
                }

                if (action === 'toggle-category') {
                    categories[index].active = !categories[index].active;
                    renderCategoryList();
                }
            });

            postList.addEventListener('click', function (event) {
                const button = event.target.closest('button[data-action]');
                if (!button) return;

                const action = button.getAttribute('data-action');
                const index = Number(button.getAttribute('data-index'));
                if (!Number.isInteger(index) || index < 0 || index >= posts.length) return;

                if (action === 'edit-post') {
                    openPostModal(index);
                    return;
                }

                if (action === 'delete-post') {
                    posts.splice(index, 1);
                    postPage = clampPage(postPage, posts, postPageSize);
                    renderCategoryList();
                    renderPostList();
                    return;
                }

                if (action === 'toggle-post') {
                    posts[index].active = !posts[index].active;
                    renderPostList();
                }
            });

            parseInitial();
            if (!categories.length) {
                categories = [
                    { name: 'Blog', slug: 'blog', description: 'Articles and general posts.', active: true }
                ];
            }

            if (!posts.length) {
                posts = [
                    { category: categories[0].slug, title: 'Sample Post', image: '/vite.svg', date: '2026-04-01', details: 'Replace this sample post with your first article or case study.', active: true }
                ];
            }

            setCategoryActiveState(true);
            setPostActiveState(true);
            renderCategoryList();
            renderPostList();
            renderImagePreview('');
        })();
    </script>
@endsection
