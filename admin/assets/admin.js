$(function() {
  // Sidebar active class
  $('.admin-sidebar a').each(function() {
    if (window.location.pathname.includes($(this).attr('href'))) {
      $(this).addClass('active');
    }
  });

  // Dark mode toggle
  $('.js-toggle-theme').on('click', function() {
    $('body').toggleClass('dark');
    // Optional: save preference
    if($('body').hasClass('dark'))
      localStorage.setItem('admintheme', 'dark');
    else
      localStorage.setItem('admintheme', 'light');
  });
  // On load, set theme from localStorage
  if(localStorage.getItem('admintheme') === 'dark') $('body').addClass('dark');

  // Example toast function
  window.showToast = function(msg, ok) {
    $("body").append('<div class="admintoast" style="position:fixed;z-index:9999;left:50%;transform:translateX(-50%);bottom:44px;background:'+(ok?'#355c7d':'#f67280')+';color:#fff;padding:14px 28px;border-radius:12px;font-size:1.1em;box-shadow:0 4px 16px #0005;">'+msg+'</div>');
    setTimeout(function(){$('.admintoast').fadeOut(300,function(){$(this).remove();});},2500);
  }
});
