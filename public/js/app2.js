document.getElementById('menu-toggle').addEventListener('click', toggleActive);

function toggleActive()
{
  this.nextElementSibling.classList.toggle('active');
}