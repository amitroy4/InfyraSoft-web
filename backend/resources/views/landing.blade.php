<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>infyrasoft-website</title>
    <script type="module" crossorigin src="/assets/index-BU7Mwjc2.js"></script>
    <link rel="stylesheet" crossorigin href="/assets/index-tn0RQdqM.css">
    <style>
      @media (min-width: 768px) {
        .mobile-col {
          display: none !important;
        }
      }

      @media (max-width: 767.98px) {
        .mobile-col {
          display: flex !important;
        }
      }
    </style>
  </head>
  <body>
    <div id="root"></div>

    <script>
      (function () {
        const contentBindings = [
          {
            id: 'hero-subtitle',
            key: 'hero_subtitle',
            fallbackText: 'InfyraSoft Tech delivers cutting-edge apps, SaaS platforms & enterprise automation for modern businesses in Dhaka and beyond.'
          },
          {
            id: 'about-paragraph-1',
            key: 'about_paragraph_1',
            fallbackText: 'Based in Dhaka, Bangladesh, InfyraSoft Tech is a professional software development company specializing in web applications, SaaS platforms, and business automation systems.'
          },
          {
            id: 'about-paragraph-2',
            key: 'about_paragraph_2',
            fallbackText: 'We create secure, scalable, and high-performance solutions that help companies streamline operations and accelerate growth globally.'
          },
          {
            id: 'contact-location',
            key: 'contact_location',
            fallbackText: 'Dhaka, Bangladesh'
          },
          {
            id: 'contact-email',
            key: 'contact_email',
            fallbackText: 'info@infyrasoft.tech'
          },
          {
            id: 'contact-phone',
            key: 'contact_phone',
            fallbackText: '+880 1XXX-XXXXXX'
          },
          {
            id: 'contact-hours',
            key: 'contact_hours',
            fallbackText: 'Sun-Thu: 9AM - 6PM BST'
          },
          {
            id: 'footer-tagline',
            key: 'footer_tagline',
            fallbackText: 'Building scalable software solutions for modern digital businesses. Based in Dhaka, Bangladesh.'
          },
          {
            id: 'footer-copyright',
            key: 'footer_copyright',
            fallbackText: '© 2025 InfyraSoft Tech. All rights reserved. Built in Dhaka'
          },
          {
            id: 'stat-projects',
            key: 'stat_projects',
            fallbackText: '50+'
          },
          {
            id: 'stat-clients',
            key: 'stat_clients',
            fallbackText: '30+'
          },
          {
            id: 'stat-products',
            key: 'stat_products',
            fallbackText: '8+'
          },
          {
            id: 'stat-rating',
            key: 'stat_rating',
            fallbackText: '5★'
          }
        ];

        function ensureBoundElement(id, fallbackText) {
          const existing = document.getElementById(id);
          if (existing) return existing;

          const searchRoot = document.querySelector('footer') || document.body;
          const candidates = searchRoot.querySelectorAll('h1, h2, h3, h4, p, span, div');

          for (const el of candidates) {
            if (el.children.length !== 0) continue;
            if (!el.textContent) continue;
            if (el.textContent.trim() !== fallbackText) continue;

            el.id = id;
            return el;
          }

          return null;
        }

        function bindContentElements() {
          contentBindings.forEach(function (binding) {
            ensureBoundElement(binding.id, binding.fallbackText);
          });
        }

        function setBoundText(id, fallbackText, value) {
          if (!value) return;
          const el = ensureBoundElement(id, fallbackText);
          if (el) {
            el.textContent = value;
          }
        }

        function replaceFooterBrandWithLogo() {
          const footer = document.querySelector('footer');
          if (!footer) return;

          const brandContainer = Array.from(footer.querySelectorAll('div')).find(function (el) {
            const spans = el.querySelectorAll(':scope > span');
            if (spans.length < 3) return false;
            return (
              spans[0].textContent && spans[0].textContent.trim() === 'Infyra' &&
              spans[1].textContent && spans[1].textContent.trim() === 'Soft' &&
              spans[2].textContent && spans[2].textContent.trim() === 'TECH'
            );
          });

          if (!brandContainer) return;
          if (brandContainer.querySelector('img[data-footer-logo="true"]')) return;

          brandContainer.innerHTML = '';
          const logo = document.createElement('img');
          logo.src = '/vite.svg';
          logo.alt = 'InfyraSoft Tech Logo';
          logo.setAttribute('data-footer-logo', 'true');
          logo.style.height = '38px';
          logo.style.width = 'auto';
          logo.style.display = 'block';

          brandContainer.appendChild(logo);
        }

        function applyContent(data) {
          if (!data) return;

          document.title = data.site_title || document.title;

          contentBindings.forEach(function (binding) {
            setBoundText(binding.id, binding.fallbackText, data[binding.key]);
          });

          replaceFooterBrandWithLogo();
        }

        async function loadData() {
          try {
            const response = await fetch('/api/site-data', { headers: { Accept: 'application/json' } });
            if (!response.ok) return;
            const data = await response.json();

            const applyNow = function () { applyContent(data); };
            setTimeout(applyNow, 350);
            setTimeout(applyNow, 1200);
            setTimeout(applyNow, 2400);
            setTimeout(bindContentElements, 2550);
            setTimeout(replaceFooterBrandWithLogo, 2600);
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

        loadData();
        setTimeout(bindContentElements, 600);
        setTimeout(replaceFooterBrandWithLogo, 800);
      })();
    </script>
  </body>
</html>
