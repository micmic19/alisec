  // JavaScript для отображения и закрытия уведомления
  document.addEventListener('DOMContentLoaded', function() {
    var cookieNotice = document.querySelector('.cookie-notice');
    var cookieNoticeCloseButton = document.querySelector('.cookie-notice-close');

    if (localStorage.getItem('cookieConsent') === 'accepted') {
      cookieNotice.style.display = 'none';
    }

    cookieNoticeCloseButton.addEventListener('click', function() {
      cookieNotice.style.display = 'none';
      localStorage.setItem('cookieConsent', 'accepted');
    });
  });
