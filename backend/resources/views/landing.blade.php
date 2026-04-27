<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link id="site-favicon" rel="icon" type="image/svg+xml" href="/vite.svg" />
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
            id: 'about-point-1',
            key: 'about_point_1',
            fallbackText: 'Expert certified development team'
          },
          {
            id: 'about-point-2',
            key: 'about_point_2',
            fallbackText: 'Agile delivery with regular demos'
          },
          {
            id: 'about-point-3',
            key: 'about_point_3',
            fallbackText: 'Client-first approach always'
          },
          {
            id: 'about-point-4',
            key: 'about_point_4',
            fallbackText: 'Ongoing support & maintenance'
          },
          {
            id: 'about-button-text',
            key: 'about_button_text',
            fallbackText: 'Learn Our Story ->'
          },
          {
            id: 'core-services-title',
            key: 'core_services_title',
            fallbackText: 'Our Core Services'
          },
          {
            id: 'core-services-subtitle',
            key: 'core_services_subtitle',
            fallbackText: 'End-to-end technology services to power your digital transformation journey.'
          },
          {
            id: 'products-title',
            key: 'products_title',
            fallbackText: 'Ready-Made Software Products'
          },
          {
            id: 'products-subtitle',
            key: 'products_subtitle',
            fallbackText: 'Battle-tested products ready to deploy or customize for your business.'
          },
          {
            id: 'clients-tag',
            key: 'clients_tag',
            fallbackText: 'Trusted By'
          },
          {
            id: 'clients-title',
            key: 'clients_title',
            fallbackText: 'Our Clients'
          },
          {
            id: 'blog-title',
            key: 'blog_title',
            fallbackText: 'Case Studies & Blog'
          },
          {
            id: 'blog-subtitle',
            key: 'blog_subtitle',
            fallbackText: 'Insights, success stories, and technical deep-dives from our team.'
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
            id: 'privacy-policy',
            key: 'privacy_policy',
            fallbackText: 'Privacy Policy'
          },
          {
            id: 'terms-of-service',
            key: 'terms_of_service',
            fallbackText: 'Terms of Service'
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

          const searchRoot = document.body;
          const candidates = searchRoot.querySelectorAll('h1, h2, h3, h4, p, span, div, a');

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

        function replaceAllText(oldText, newText) {
          if (!oldText || typeof newText === 'undefined' || newText === null) return;

          const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
          let node;
          while ((node = walker.nextNode())) {
            if (!node.nodeValue) continue;
            if (node.nodeValue.indexOf(oldText) === -1) continue;
            node.nodeValue = node.nodeValue.split(oldText).join(String(newText));
          }
        }

        function replaceFooterBrandWithLogo(logoSrc) {
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
          logo.src = logoSrc || '/vite.svg';
          logo.alt = 'InfyraSoft Tech Logo';
          logo.setAttribute('data-footer-logo', 'true');
          logo.style.height = '38px';
          logo.style.width = 'auto';
          logo.style.display = 'block';

          brandContainer.appendChild(logo);
        }

        function applyBrandingLinks(data) {
          if (!data) return;

          const favicon = document.getElementById('site-favicon');
          if (favicon && data.site_favicon) {
            favicon.setAttribute('href', data.site_favicon);
          }

          const footerSocial = document.querySelectorAll('footer .social-btn');
          if (footerSocial.length >= 1 && data.linkedin_link) {
            footerSocial[0].setAttribute('href', data.linkedin_link);
            footerSocial[0].setAttribute('target', '_blank');
            footerSocial[0].setAttribute('rel', 'noopener noreferrer');
          }
          if (footerSocial.length >= 2 && data.facebook_link) {
            footerSocial[1].setAttribute('href', data.facebook_link);
            footerSocial[1].setAttribute('target', '_blank');
            footerSocial[1].setAttribute('rel', 'noopener noreferrer');
          }

          if (data.whatsapp_link) {
            const buttons = document.querySelectorAll('button');
            buttons.forEach(function (btn) {
              if (!btn.textContent || btn.dataset.whatsappBound === '1') return;
              if (btn.textContent.indexOf('WhatsApp') === -1) return;

              btn.dataset.whatsappBound = '1';
              btn.addEventListener('click', function () {
                window.open(data.whatsapp_link, '_blank', 'noopener,noreferrer');
              });
            });
          }
        }

        function applyAboutSectionSettings(data) {
          if (!data) return;

          const aboutTitle = Array.from(document.querySelectorAll('h2')).find(function (el) {
            if (!el.textContent) return false;
            return el.textContent.indexOf('We Build Digital') !== -1 && el.textContent.indexOf('Experiences') !== -1;
          });
          if (aboutTitle && data.about_title) {
            aboutTitle.textContent = data.about_title;
          }

          const aboutButton = Array.from(document.querySelectorAll('button')).find(function (btn) {
            return btn.textContent && btn.textContent.indexOf('Learn Our Story') !== -1;
          });

          if (!aboutButton) return;

          if (data.about_button_text) {
            aboutButton.textContent = data.about_button_text;
          }

          const isActive = String(data.about_button_active || '0') === '1';
          aboutButton.style.display = isActive ? '' : 'none';

          if (!isActive) return;
          if (!data.about_button_link) return;
          if (aboutButton.dataset.customLinkBound === '1') return;

          aboutButton.dataset.customLinkBound = '1';
          aboutButton.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            const link = String(data.about_button_link).trim();
            if (!link) return;
            if (/^https?:\/\//i.test(link)) {
              window.open(link, '_blank', 'noopener,noreferrer');
              return;
            }

            window.location.href = link;
          }, true);
        }

        function applyCoreServiceItems(data) {
          const defaults = [
            {
              icon: '🌐',
              title: 'Domain & Hosting',
              details: 'Reliable, high-performance hosting with 99.9% uptime SLA. We manage domain registration, DNS, SSL certificates, CDN, and server infrastructure.',
              points: ['99.9% Uptime SLA', 'Free SSL Certificate', 'DDoS Protection', '24/7 Monitoring', 'Auto Backups', 'CDN Integration']
            },
            {
              icon: '💻',
              title: 'Custom Application Development',
              details: 'Tailor-made web and mobile applications using React, Next.js, Node.js, and modern tech stacks. From MVPs to enterprise-grade platforms.',
              points: ['React & Next.js', 'Node.js Backend', 'REST & GraphQL', 'Mobile Apps', 'Cloud Deploy', 'Full Documentation']
            },
            {
              icon: '🛡️',
              title: 'Cyber Security Support',
              details: 'Comprehensive cybersecurity solutions including penetration testing, vulnerability assessments, security audits, and incident response.',
              points: ['Penetration Testing', 'Vulnerability Scan', 'Security Audits', 'Firewall Config', 'Incident Response', 'Compliance']
            },
            {
              icon: '🤖',
              title: 'AI Support & Integration',
              details: 'Integrate cutting-edge AI into your existing systems to automate workflows, gain intelligent insights, and build smarter applications.',
              points: ['ChatGPT Integration', 'ML Models', 'Intelligent Chatbots', 'Predictive Analytics', 'Process Automation', 'NLP Solutions']
            },
            {
              icon: '🔧',
              title: 'Technical Support',
              details: '24/7 technical assistance for all your software systems. From urgent bug fixes to performance optimization — always available.',
              points: ['24/7 Availability', 'Remote Support', 'Bug Fixes', 'Performance Tuning', 'System Upgrades', 'Priority SLA']
            },
            {
              icon: '☁️',
              title: 'SaaS Platform Development',
              details: 'Build scalable SaaS platforms with multi-tenant architecture, subscription billing, and cloud-native infrastructure.',
              points: ['Multi-tenant Arch', 'Subscription Billing', 'Cloud-Native', 'Auto Scaling', 'White-label Ready', 'Analytics']
            }
          ];

          let services = [];
          try {
            const parsed = JSON.parse(data.core_services_items || '[]');
            services = Array.isArray(parsed) ? parsed : [];
          } catch (e) {
            services = [];
          }

          const activeServices = services
            .filter(function (item) { return item && item.active; })
            .slice(0, 6);

          if (!activeServices.length) {
            for (let i = 1; i <= 6; i++) {
              const item = {
                icon: data['core_service_' + i + '_icon'],
                title: data['core_service_' + i + '_title'],
                details: data['core_service_' + i + '_details'],
                key_points: String(data['core_service_' + i + '_key_points'] || '').split('\n')
              };

              if (!item.title || !item.details) continue;
              activeServices.push(item);
            }
          }

          for (let i = 1; i <= 6; i++) {
            const fallback = defaults[i - 1];
            const next = activeServices[i - 1] || null;
            const title = next ? String(next.title || '') : '';
            const details = next ? String(next.details || '') : '';
            const icon = next ? String(next.icon || '') : '';
            const keyPoints = next
              ? (Array.isArray(next.key_points) ? next.key_points.join('\n') : String(next.key_points || ''))
              : '';

            replaceAllText(fallback.title, title || '');
            replaceAllText(fallback.details, details || '');
            replaceAllText(fallback.icon, icon || '');

            const newPoints = String(keyPoints)
              .split('\n')
              .map(function (p) { return p.trim(); })
              .filter(function (p) { return p.length > 0; });

            fallback.points.forEach(function (oldPoint, index) {
              const nextPoint = typeof newPoints[index] === 'undefined' ? '' : newPoints[index];
              replaceAllText(oldPoint, nextPoint);
            });
          }
        }

        function applyContent(data) {
          if (!data) return;

          document.title = data.site_title || document.title;

          contentBindings.forEach(function (binding) {
            setBoundText(binding.id, binding.fallbackText, data[binding.key]);
          });

          replaceFooterBrandWithLogo(data.footer_logo);
          applyBrandingLinks(data);
          applyAboutSectionSettings(data);
          applyCoreServiceItems(data);
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
            setTimeout(function () { applyBrandingLinks(data); }, 2650);
            setTimeout(function () { applyAboutSectionSettings(data); }, 2700);
            setTimeout(function () { applyCoreServiceItems(data); }, 2750);
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
