// Smooth scrolling for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});

// Waitlist form submission simulation
const waitlistForm = document.querySelector('.waitlist-form');
if (waitlistForm) {
  waitlistForm.addEventListener('submit', (e) => {
    e.preventDefault();
    alert('Thank you for joining the waitlist! We will keep you updated.');
    waitlistForm.reset();
  });
}
