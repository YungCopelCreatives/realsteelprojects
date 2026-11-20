// Mobile menu, scroll reveal and the "request sent" note.
(function () {
  var hd = document.querySelector('.hd');
  var btn = document.querySelector('.menu-btn');
  if (hd && btn) {
    btn.addEventListener('click', function () {
      var open = hd.classList.toggle('open');
      btn.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
  }
  var items = document.querySelectorAll('.rv');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
    }, { rootMargin: '0px 0px -8% 0px' });
    items.forEach(function (el) { io.observe(el); });
  } else {
    items.forEach(function (el) { el.classList.add('in'); });
  }
  if (/[?&]sent=1/.test(location.search)) {
    document.querySelectorAll('.sent').forEach(function (el) { el.classList.add('show'); });
  }
  var y = document.getElementById('year');
  if (y) y.textContent = new Date().getFullYear();
})();
