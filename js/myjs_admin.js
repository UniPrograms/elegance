function showSection(id) {
  document.querySelectorAll('section').forEach(s => s.classList.remove('active'));
  document.getElementById(id).classList.add('active');
  document.querySelectorAll('.sidebar ul li').forEach(li => li.classList.remove('active'));
  event.target.closest('li').classList.add('active');
  document.querySelector('.header h1').textContent = id.charAt(0).toUpperCase() + id.slice(1);
}
