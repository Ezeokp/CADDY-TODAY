document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.current-year').forEach(el => el.textContent = new Date().getFullYear());

  const header = document.getElementById('header');
  const updateHeader = () => header?.classList.toggle('scrolled', window.scrollY > 20);
  updateHeader();
  window.addEventListener('scroll', updateHeader);

  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');

  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
      const open = navLinks.classList.toggle('open');
      menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });

    navLinks.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
      navLinks.classList.remove('open');
      menuToggle.setAttribute('aria-expanded', 'false');
    }));
  }

  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', e => {
      const href = anchor.getAttribute('href');
      if (!href || href === '#') return;
      const target = document.querySelector(href);
      if (!target) return;
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  });

  document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
      const item = button.closest('.faq-item');
      const wasOpen = item.classList.contains('open');
      document.querySelectorAll('.faq-item').forEach(faq => faq.classList.remove('open'));
      if (!wasOpen) item.classList.add('open');
    });
  });

  document.querySelectorAll('.ajax-form').forEach(form => {
    form.addEventListener('submit', async e => {
      e.preventDefault();

      const button = form.querySelector('button[type="submit"]');
      const message = form.id === 'contactForm'
        ? document.getElementById('contactMessage')
        : document.getElementById('waitlistMessage');

      const originalText = button.textContent;
      button.disabled = true;
      button.textContent = form.id === 'waitlistForm' ? 'Joining...' : 'Sending...';
      message.textContent = '';
      message.className = 'form-message';

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          body: new FormData(form),
          headers: { Accept: 'application/json' }
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
          throw new Error(result.message || 'Something went wrong. Please try again.');
        }

        message.textContent = result.message;
        message.classList.add('success');
        form.reset();
      } catch (error) {
        message.textContent = error.message || 'Something went wrong. Please try again.';
        message.classList.add('error');
      } finally {
        button.disabled = false;
        button.textContent = originalText;
      }
    });
  });
});