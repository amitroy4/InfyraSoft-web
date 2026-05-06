<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link id="site-favicon" rel="icon" type="image/svg+xml" href="{{ $siteData['site_favicon'] ?? '/vite.svg' }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>infyrasoft-website</title>
    <style>
      @media (min-width: 981px) {
        .mobile-col {
          display: none !important;
        }
      }
    </style>
    <script type="module" crossorigin src="/assets/index-BU7Mwjc2.js"></script>
    <link rel="stylesheet" crossorigin href="/assets/index-tn0RQdqM.css">
  </head>
  <body>
    <div id="root"></div>

    <script>
      (function () {
        const siteData = window.__siteData || {};
        const logoUrl = @json($logoUrl ?? null) || siteData.footer_logo || '/vite.svg';
        const faviconUrl = @json($faviconUrl ?? '/vite.svg') || siteData.site_favicon || '/vite.svg';
        let heroFocusTimer = null;
        let latestSiteData = null;
        let applyPending = false;

        if (faviconUrl) {
          const existingIcon = document.getElementById('site-favicon') || document.querySelector('link[rel="icon"]');
          if (existingIcon) {
            existingIcon.setAttribute('href', faviconUrl);
          }
        }

        function updateTextNode(matchText, newText, scope = document.body) {
          if (!matchText || newText === undefined || newText === null || matchText === newText) return false;

          const walker = document.createTreeWalker(scope, NodeFilter.SHOW_TEXT);
          const exactMatches = [];
          const partialMatches = [];
          let node;

          while ((node = walker.nextNode())) {
            const value = node.nodeValue || '';
            const trimmed = value.trim();

            if (!trimmed) {
              continue;
            }

            if (trimmed === matchText) {
              exactMatches.push(node);
            } else if (value.includes(matchText)) {
              partialMatches.push(node);
            }
          }

          const targets = exactMatches.length ? exactMatches : partialMatches;
          if (!targets.length) return false;

          targets.forEach((target) => {
            if (exactMatches.length) {
              target.nodeValue = String(newText);
            } else {
              target.nodeValue = target.nodeValue.replace(matchText, String(newText));
            }
          });

          return true;
        }

        function applyTextReplacements(data) {
          [
            ["🚀 Bangladesh's Trusted Tech Partner", data.hero_badge_text],
            ["InfyraSoft Tech delivers cutting-edge apps, SaaS platforms & enterprise automation for modern businesses in Dhaka and beyond.", data.hero_subtitle],
            ['https://infyrasoft.tech/dashboard', data.hero_dashboard_url],
            ['All systems operational — 0 incidents', data.hero_system_status],
            ["Based in Dhaka, Bangladesh, InfyraSoft Tech is a professional software development company specializing in web applications, SaaS platforms, and business automation systems.", data.about_paragraph_1],
            ["We create secure, scalable, and high-performance solutions that help companies streamline operations and accelerate growth globally.", data.about_paragraph_2],
            ["End-to-end digital solutions crafted for modern business needs.", data.core_services_content],
            ["We combine technical excellence with deep business understanding to deliver results that matter.", data.why_us_content],
            ["Battle-tested products ready to deploy or customize for your business.", data.our_products_content],
            ["A glimpse of the impactful solutions we've delivered for our clients.", data.our_work_content],
            ["Our Clients", data.our_clients_content],
            ["How We Scaled a SaaS Platform to 10,000+ Users", data.study_blogs_content],
            ["Dhaka, Bangladesh", data.contact_location],
            ["info@infyrasoft.tech", data.contact_email],
            ["+880 1XXX-XXXXXX", data.contact_phone],
            ["Sun-Thu: 9AM - 6PM BST", data.contact_hours],
            ["Sun–Thu: 9AM – 6PM", data.contact_hours],
            ["Building scalable software solutions for modern digital businesses. Based in Dhaka, Bangladesh.", data.footer_tagline],
            ["© 2025 InfyraSoft Tech. All rights reserved. Built in Dhaka", data.footer_copyright],
            ["© 2025 InfyraSoft Tech. All rights reserved. Built in Dhaka 🇧🇩", data.footer_copyright]
          ].forEach(([matchText, newValue]) => {
            updateTextNode(matchText, newValue);
          });
        }

        function isEnabled(value) {
          return String(value) === '1' || value === true || String(value).toLowerCase() === 'true';
        }

        function findHeroHeading() {
          return Array.from(document.querySelectorAll('h1')).find((heading) => {
            const text = (heading.textContent || '').trim();
            return text.includes('That Scale.') || text.includes("Bangladesh's Trusted Tech Partner") || text.includes('Web Applications');
          });
        }

        function applyHeroHeading(data) {
          const heading = findHeroHeading();
          if (!heading) return;

          const firstTextNode = Array.from(heading.childNodes).find((node) => node.nodeType === Node.TEXT_NODE && node.nodeValue.trim().length > 0);
          if (firstTextNode && data.hero_title_line1) {
            firstTextNode.nodeValue = data.hero_title_line1;
          }

          const spans = heading.querySelectorAll('span');
          if (spans[2] && data.hero_title_line3) {
            spans[2].textContent = data.hero_title_line3;
          }

          const focusWords = String(data.hero_focus_list || '')
            .split(',')
            .map((item) => item.trim())
            .filter(Boolean);

          if (spans[0] && focusWords.length > 0) {
            if (heroFocusTimer) {
              clearInterval(heroFocusTimer);
              heroFocusTimer = null;
            }

            let index = 0;
            const updateFocusWord = () => {
              spans[0].textContent = focusWords[index];
              index = (index + 1) % focusWords.length;
            };

            updateFocusWord();
            heroFocusTimer = setInterval(updateFocusWord, 2200);
          }
        }

        function findElementsByLabels(labels) {
          const candidates = Array.from(document.querySelectorAll('button, a'));
          return candidates.filter((el) => labels.includes((el.textContent || '').trim()));
        }

        function applyButtonConfig(data, config) {
          const labels = [config.defaultLabel];
          if (data[config.textKey]) {
            labels.push(data[config.textKey]);
          }

          const targets = findElementsByLabels(labels);
          targets.forEach((target) => {
            target.textContent = data[config.textKey] || config.defaultLabel;

            if (!isEnabled(data[config.enabledKey])) {
              target.style.display = 'none';
              target.setAttribute('aria-disabled', 'true');
              target.removeAttribute('data-dynamic-link');
              return;
            }

            target.style.display = '';
            target.removeAttribute('aria-disabled');

            const customLink = (data[config.linkKey] || '').trim();
            if (customLink) {
              target.setAttribute('data-dynamic-link', customLink);
              if (target.tagName.toLowerCase() === 'a') {
                target.setAttribute('href', customLink);
              }
            } else {
              target.removeAttribute('data-dynamic-link');
            }
          });
        }

        function applySecondaryKpiCards(data) {
          const cards = [
            { defaultLabel: 'Projects Done', emojiKey: 'kpi_projects_emoji', valueKey: 'kpi_projects_value', labelKey: 'kpi_projects_label' },
            { defaultLabel: 'Happy Clients', emojiKey: 'kpi_clients_emoji', valueKey: 'kpi_clients_value', labelKey: 'kpi_clients_label' },
            { defaultLabel: 'Products Built', emojiKey: 'kpi_products_emoji', valueKey: 'kpi_products_value', labelKey: 'kpi_products_label' },
            { defaultLabel: 'Years Experience', emojiKey: 'kpi_years_emoji', valueKey: 'kpi_years_value', labelKey: 'kpi_years_label' },
            { defaultLabel: 'Support Hours', emojiKey: 'kpi_support_emoji', valueKey: 'kpi_support_value', labelKey: 'kpi_support_label' }
          ];

          cards.forEach((config) => {
            const labelEl = Array.from(document.querySelectorAll('div')).find((el) => {
              const text = (el.textContent || '').trim();
              return text === config.defaultLabel || text === (data[config.labelKey] || '').trim();
            });
            if (!labelEl) return;

            const card = labelEl.parentElement;
            if (!card) return;

            const parts = Array.from(card.children).filter((el) => el.tagName && el.tagName.toLowerCase() === 'div');
            if (parts.length < 3) return;

            parts[0].textContent = data[config.emojiKey] || parts[0].textContent;
            parts[1].textContent = data[config.valueKey] || parts[1].textContent;
            parts[2].textContent = data[config.labelKey] || parts[2].textContent;
          });
        }

        function applySnippetStats(data) {
          const mappings = [
            { defaultLabel: 'Uptime', label: data.hero_uptime_label, value: data.hero_uptime_value },
            { defaultLabel: 'Speed', label: data.hero_speed_label, value: data.hero_speed_value },
            { defaultLabel: 'Security', label: data.hero_security_label, value: data.hero_security_value },
            { defaultLabel: 'Clients', label: data.hero_clients_label, value: data.hero_clients_value }
          ];

          mappings.forEach((item) => {
            const labelEl = Array.from(document.querySelectorAll('div')).find((el) => {
              const text = (el.textContent || '').trim();
              return text === item.defaultLabel || text === (item.label || '').trim();
            });
            if (!labelEl || !labelEl.parentElement) return;

            const pair = labelEl.parentElement;
            const divs = Array.from(pair.children).filter((child) => child.tagName && child.tagName.toLowerCase() === 'div');
            if (divs.length < 2) return;

            divs[0].textContent = item.value || divs[0].textContent;
            divs[1].textContent = item.label || item.defaultLabel;
          });
        }

        function applyHeroTopStats(data) {
          const heading = findHeroHeading();
          if (!heading) return;

          const scope = heading.closest('section') || document;
          const mappings = [
            { label: 'Projects', value: data.stat_projects },
            { label: 'Clients', value: data.stat_clients },
            { label: 'Products', value: data.stat_products },
            { label: 'Rating', value: data.stat_rating }
          ];

          mappings.forEach((item) => {
            const labelEl = Array.from(scope.querySelectorAll('div')).find((el) => (el.textContent || '').trim() === item.label);
            if (!labelEl || !labelEl.parentElement) return;

            const valueEl = Array.from(labelEl.parentElement.children).find((child) => child !== labelEl);
            if (!valueEl || !item.value) return;

            valueEl.textContent = item.value;
          });
        }

        function applySnippetCodeVariable(data) {
          const snippet = String(data.hero_dashboard_text || '').trim();
          if (!snippet) return;

          const lines = snippet.split(/\r?\n/).map((line) => line.trim()).filter(Boolean);
          const commentLine = lines[0];
          const variableLine = lines[1] || '';
          const typeLine = lines.find((line) => line.startsWith('type:'));
          const stackLine = lines.find((line) => line.startsWith('stack:'));
          const statusLine = lines.find((line) => line.startsWith('status:'));

          if (commentLine) {
            updateTextNode('// InfyraSoft Tech — Live Dashboard', commentLine);
          }

          const variableMatch = variableLine.match(/^const\s+([A-Za-z_$][\w$]*)\s*=\s*\{$/);
          if (variableMatch) {
            updateTextNode('const solution = {', variableLine);
          }

          if (typeLine) {
            const typeValue = typeLine.replace(/^type:\s*/, '').replace(/,?$/, '').trim();
            updateTextNode("'enterprise'", typeValue);
          }

          if (stackLine) {
            const stackValue = stackLine.replace(/^stack:\s*/, '').replace(/,?$/, '').trim();
            updateTextNode("'React + Node'", stackValue);
          }

          if (statusLine) {
            const statusValue = statusLine.replace(/^status:\s*/, '').replace(/,?$/, '').trim();
            updateTextNode("'🟢 deployed'", statusValue);
          }
        }

        document.addEventListener('click', function (event) {
          const target = event.target.closest('[data-dynamic-link]');
          if (!target) return;

          const link = target.getAttribute('data-dynamic-link');
          if (!link) return;

          event.preventDefault();
          event.stopPropagation();
          window.location.href = link;
        }, true);

        function updateLogo() {
          if (!logoUrl) return;
          const targets = [document.getElementById('site-header-logo'), document.getElementById('site-footer-logo')].filter(Boolean);
          targets.forEach((target) => {
            const isFooter = target.id === 'site-footer-logo';
            target.innerHTML = `<img src="${logoUrl}" alt="InfyraSoft logo" style="display:block;max-height:${isFooter ? '48px' : '42px'};max-width:${isFooter ? '220px' : '170px'};width:auto;height:auto;object-fit:contain;">`;
            target.style.display = 'inline-flex';
            target.style.alignItems = 'center';
            target.style.justifyContent = 'center';
          });
        }
        
          function bindBrandElements() {
            const candidates = Array.from(document.querySelectorAll('header div, footer div'));
          
            candidates.forEach((element) => {
              const spans = element.querySelectorAll(':scope > span');
              if (spans.length < 3) return;
            
              const brandText = Array.from(spans).map((span) => (span.textContent || '').trim()).join('').toLowerCase();
              if (brandText !== 'infyrasofttech') return;
            
              if (element.closest('footer')) {
                element.id = 'site-footer-logo';
              } else if (element.closest('header')) {
                element.id = 'site-header-logo';
              }
            });
          }

        function applyFooterDynamics(data) {
          if (!data) return;
          const footer = document.querySelector('footer');
          if (!footer) return;

          // Strict id-based updates: only update elements that already have the expected ids
          (function () {
            const emailEl = document.getElementById('contact-email');
            if (emailEl && data.contact_email) {
              const email = String(data.contact_email).trim();
              if (emailEl.tagName.toLowerCase() === 'a') {
                emailEl.setAttribute('href', 'mailto:' + email);
                emailEl.textContent = email;
              } else {
                emailEl.textContent = email;
              }
            }

            const phoneEl = document.getElementById('contact-phone');
            if (phoneEl && data.contact_phone) {
              const phone = String(data.contact_phone).trim();
              const tel = phone.replace(/[^+\d]/g, '');
              if (phoneEl.tagName.toLowerCase() === 'a') {
                phoneEl.setAttribute('href', 'tel:' + tel);
                phoneEl.textContent = phone;
              } else {
                phoneEl.textContent = phone;
              }
            }

            const locationEl = document.getElementById('contact-location');
            if (locationEl && data.contact_location) {
              locationEl.textContent = String(data.contact_location).trim();
            }

            const hoursEl = document.getElementById('contact-hours');
            if (hoursEl && data.contact_hours) {
              hoursEl.textContent = String(data.contact_hours).trim();
            }

            const taglineEl = document.getElementById('footer-tagline');
            if (taglineEl && data.footer_tagline) {
              taglineEl.textContent = String(data.footer_tagline).trim();
            }

            const copyrightEl = document.getElementById('footer-copyright');
            if (copyrightEl && data.footer_copyright) {
              copyrightEl.textContent = String(data.footer_copyright).trim();
            }
          })();

          // Ensure email uses mailto and keep element id
          const emailEl = document.getElementById('contact-email');
          if (emailEl) {
            const email = (data.contact_email || (emailEl.textContent || '')).trim();
            if (email) {
              if (emailEl.tagName.toLowerCase() === 'a') {
                emailEl.setAttribute('href', 'mailto:' + email);
                emailEl.textContent = email;
              } else {
                const a = document.createElement('a'); a.href = 'mailto:' + email; a.textContent = email; a.id = 'contact-email'; emailEl.replaceWith(a);
              }
            }
          }

          // Ensure phone uses tel and keep element id
          const phoneEl = document.getElementById('contact-phone');
          if (phoneEl) {
            const phone = (data.contact_phone || (phoneEl.textContent || '')).trim();
            if (phone) {
              const tel = phone.replace(/[^+\d]/g, '');
              if (phoneEl.tagName.toLowerCase() === 'a') {
                phoneEl.setAttribute('href', 'tel:' + tel);
                phoneEl.textContent = phone;
              } else {
                const a = document.createElement('a'); a.href = 'tel:' + tel; a.textContent = phone; a.id = 'contact-phone'; phoneEl.replaceWith(a);
              }
            }
          }

          // Privacy and terms: use id-based anchors if present
          const privacyEl = document.getElementById('privacy-policy');
          if (privacyEl && data.privacy_policy) {
            if (privacyEl.tagName.toLowerCase() === 'a') privacyEl.setAttribute('href', data.privacy_policy);
            else {
              const a = document.createElement('a'); a.href = data.privacy_policy; a.textContent = privacyEl.textContent || 'Privacy Policy'; a.id = 'privacy-policy'; privacyEl.replaceWith(a);
            }
          }

          const termsEl = document.getElementById('terms-of-service');
          if (termsEl && data.terms_of_service) {
            if (termsEl.tagName.toLowerCase() === 'a') termsEl.setAttribute('href', data.terms_of_service);
            else {
              const a = document.createElement('a'); a.href = data.terms_of_service; a.textContent = termsEl.textContent || 'Terms of Service'; a.id = 'terms-of-service'; termsEl.replaceWith(a);
            }
          }
        }

        function applyContent(data) {
          if (!data) return;

          document.title = data.site_title || document.title;

          applyTextReplacements(data);
          applyHeroHeading(data);
          applyHeroTopStats(data);
          applySnippetCodeVariable(data);
          applySnippetStats(data);
          applySecondaryKpiCards(data);

          applyButtonConfig(data, {
            defaultLabel: 'Get Started ✨',
            textKey: 'nav_cta_text',
            linkKey: 'nav_cta_link',
            enabledKey: 'nav_cta_enabled'
          });
          applyButtonConfig(data, {
            defaultLabel: '🚀 Explore Services',
            textKey: 'hero_primary_btn_text',
            linkKey: 'hero_primary_btn_link',
            enabledKey: 'hero_primary_btn_enabled'
          });
          applyButtonConfig(data, {
            defaultLabel: 'View Our Work →',
            textKey: 'hero_secondary_btn_text',
            linkKey: 'hero_secondary_btn_link',
            enabledKey: 'hero_secondary_btn_enabled'
          });
          applyButtonConfig(data, {
            defaultLabel: 'Start Your Project 🚀',
            textKey: 'cta_start_project_text',
            linkKey: 'cta_start_project_link',
            enabledKey: 'cta_start_project_enabled'
          });
          applyButtonConfig(data, {
            defaultLabel: 'Contact Us Today 🚀',
            textKey: 'cta_contact_today_text',
            linkKey: 'cta_contact_today_link',
            enabledKey: 'cta_contact_today_enabled'
          });
          applyButtonConfig(data, {
            defaultLabel: 'Get In Touch 🚀',
            textKey: 'cta_get_in_touch_text',
            linkKey: 'cta_get_in_touch_link',
            enabledKey: 'cta_get_in_touch_enabled'
          });
          applyFooterDynamics(data);
        }

        function scheduleApply() {
          if (!latestSiteData || applyPending) return;

          applyPending = true;
          requestAnimationFrame(() => {
            applyPending = false;
            applyContent(latestSiteData);
            updateLogo();
          });
        }

        async function loadData() {
          try {
            const response = await fetch('/api/site-data', { headers: { Accept: 'application/json' } });
            if (!response.ok) return;
            const data = await response.json();
            latestSiteData = data;

            const applyNow = function () { scheduleApply(); };
              setTimeout(bindBrandElements, 200);
            setTimeout(applyNow, 350);
            setTimeout(applyNow, 1200);
            setTimeout(applyNow, 2400);
          } catch (e) {
            console.warn('Site data sync failed', e);
          }
        }

        async function submitLead(payload) {
          const response = await fetch('/api/leads', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
          });

          if (!response.ok) {
            throw new Error('Lead submission failed');
          }

          return response.json();
        }

        document.addEventListener('submit', async function (event) {
          const form = event.target;
          if (!(form instanceof HTMLFormElement)) return;

          const emailInput = form.querySelector('input[type="email"]');
          const messageInput = form.querySelector('textarea');
          if (!emailInput || !messageInput) return;

          const allInputs = form.querySelectorAll('input');
          const selects = form.querySelectorAll('select');
          const nameValue = allInputs[0] ? allInputs[0].value.trim() : '';
          const phoneValue = form.querySelector('input[type="tel"]') ? form.querySelector('input[type="tel"]').value.trim() : '';

          const payload = {
            name: nameValue,
            email: emailInput.value.trim(),
            phone: phoneValue,
            service: selects[0] ? selects[0].value : null,
            budget: selects[1] ? selects[1].value : null,
            message: messageInput.value.trim()
          };

          if (!payload.name || !payload.email || !payload.message) return;

          event.preventDefault();
          event.stopPropagation();

          try {
            await submitLead(payload);
            alert('Message sent successfully. Our team will contact you soon.');
            form.reset();
          } catch (e) {
            alert('Could not send message right now. Please try again.');
          }
        }, true);

        const root = document.getElementById('root');
        if (root) {
          const observer = new MutationObserver(() => {
            scheduleApply();
          });
          observer.observe(root, { childList: true, subtree: true });
        }

        loadData();
          bindBrandElements();
        updateLogo();
      })();
    </script>
  </body>
</html>
