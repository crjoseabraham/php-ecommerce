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
  loadTemplate(template, container)
  {
    container.innerHTML = template
  }

  // Event listeners for the modal element
  modalEvents()
  {
    document.querySelector('.modal').addEventListener('click', element => {
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
    })
  }

  // Event listeners for the cart
  cartEvents()
  {
    document.querySelector('.right-sidebar').addEventListener('click', element => {
      switch (true)
      {
        // Remove item from cart
        case element.target.getAttribute("id") === "delete":
          this.removeItemFromCart(element.target)
          break;
        case element.target.parentElement.getAttribute("id") === "delete":
          this.removeItemFromCart(element.target.parentElement)
          break;
      }
    })
  }

  // Remove an item from user's cart
  removeItemFromCart(element)
  {
    let route = element.getAttribute('data-action')
    let container = document.querySelector('.right-sidebar > .container')

    this.http.post(`${this.baseURL}/${route}`)
      .then(response => {
        if (response) {
          // Reload cart and show flash_message
          this.toggleActive(document.querySelector('.right-sidebar'))
          this.emptyContainer(container)
          return this.http.get(`${this.baseURL}/cart`)
        }
        else {
          // Show flash_message with error
        }
      })
      .then(newCartTemplate => {
        setTimeout(() => {
          this.loadTemplate(newCartTemplate, container)
          this.toggleActive(document.querySelector('.right-sidebar'))
        }, 150);
      })
      .catch(error => console.log(error))
  }
}

export { UI }