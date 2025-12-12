document.addEventListener('DOMContentLoaded',function(){
  const form = document.getElementById('loginForm');
  const btn = document.getElementById('submitBtn');
  const notice = document.getElementById('notice');
  form.addEventListener('submit',function(){
    btn.disabled = true;
    btn.style.opacity = '0.8';
    btn.textContent = 'Logging in...';
    notice.textContent = '';
  });
  const inputs = form.querySelectorAll('input');
  inputs.forEach(i=>i.addEventListener('input',()=>{ notice.textContent=''; btn.disabled=false; btn.style.opacity='1'; btn.textContent='LOGIN'}));
});
