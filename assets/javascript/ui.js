class UI
{
  // Toggle black semi-transparent layer
  overlay()
  {
    document.querySelector('.overlay').classList.toggle('active')
  }

  // Toggle left or right sidebar
  toggleActive(element)
  {
    switch (true)
    {
      case element.classList.contains('left-sidebar-toggle'):
      case element.classList.contains('left-sidebar'):
        document.querySelector('.left-sidebar').classList.toggle('active')
        break;

      case element.classList.contains('right-sidebar-toggle'):
      case element.classList.contains('right-sidebar'):
        document.querySelector('.right-sidebar').classList.toggle('active')
        break;

      case element.classList.contains('modal'):
      case element.classList.contains('modal-toggle'):
        document.querySelector('.modal').classList.toggle('active')
        break;
    }
  }

  // Empty content of an element's .container
  emptyContainer(container)
  {
    while (container.firstChild)
    {
      container.removeChild(container.firstChild)
    }
  }

  // Change content of an element's .container
  loadTemplate(route, container)
  {
    fetch(`http://localhost/shoppingcart/${route}`)
    .then(resp => resp.text())
    .then(text => container.innerHTML = text)
  }

  // Add or subtract quantity
  modalEvents(element)
  {
    switch (true) 
    {
      case element.target.classList.contains('add'):
        let quantity = document.getElementById('quantity')
        quantity.value++
        break;
      case element.target.classList.contains('subtract'):
        quantity = document.getElementById('quantity')
        if (quantity.value > 1)
          quantity.value--
        break;
    }
  }
}

export { UI }