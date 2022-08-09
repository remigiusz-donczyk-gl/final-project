window.addEventListener('load', () => {
  document.getElementById('docs').addEventListener('click', () => {
    window.open('docs/index.html', '_self');
  });
  document.getElementById('refresh').addEventListener('click', () => {
    window.location.reload();
  });
});

