class UI
{
  // Show/Hide left menu a.k.a Main Menu
  toggleMenu()
  {
    UI.overlay()
    document.querySelector('.left-sidebar').classList.toggle('active')
  }

  // Show/Hide right menu a.k.a Login/Register Form
  toggleForm()
  {
    UI.overlay()
    document.querySelector('.right-sidebar').classList.toggle('active')
  }

  // Toggle black transparent overlay
  static overlay()
  {
    document.querySelector('.overlay').classList.toggle('active')
  }
}

export { UI }