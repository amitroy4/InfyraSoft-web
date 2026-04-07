<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>infyrasoft-website</title>
    <script type="module" crossorigin src="/assets/index-BU7Mwjc2.js"></script>
    <link rel="stylesheet" crossorigin href="/assets/index-tn0RQdqM.css">
  </head>
  <body>
    <div id="root"></div>

    <script>
      (function () {
        function replaceText(oldText, newText) {
          if (!oldText || !newText || oldText === newText) return;
          const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
          let node;
          while ((node = walker.nextNode())) {
            if (node.nodeValue && node.nodeValue.indexOf(oldText) !== -1) {
              node.nodeValue = node.nodeValue.split(oldText).join(newText);
            }
          }
        }

        function applyContent(data) {
          if (!data) return;

          document.title = data.site_title || document.title;

          replaceText("InfyraSoft Tech delivers cutting-edge apps, SaaS platforms & enterprise automation for modern businesses in Dhaka and beyond.", data.hero_subtitle);
          replaceText("Based in Dhaka, Bangladesh, InfyraSoft Tech is a professional software development company specializing in web applications, SaaS platforms, and business automation systems.", data.about_paragraph_1);
          replaceText("We create secure, scalable, and high-performance solutions that help companies streamline operations and accelerate growth globally.", data.about_paragraph_2);
          replaceText("Dhaka, Bangladesh", data.contact_location);
          replaceText("info@infyrasoft.tech", data.contact_email);
          replaceText("+880 1XXX-XXXXXX", data.contact_phone);
          replaceText("Sun-Thu: 9AM - 6PM BST", data.contact_hours);
          replaceText("Building scalable software solutions for modern digital businesses. Based in Dhaka, Bangladesh.", data.footer_tagline);
          replaceText("© 2025 InfyraSoft Tech. All rights reserved. Built in Dhaka", data.footer_copyright);
          replaceText("50+", data.stat_projects);
          replaceText("30+", data.stat_clients);
          replaceText("8+", data.stat_products);
          replaceText("5★", data.stat_rating);
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
      })();
    </script>
  </body>
</html>
