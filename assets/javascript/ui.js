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
        case element.target.classList.contains('star-label'):
          setTimeout(() => {
            element.target.closest('form').submit()
          }, 10)
          break;
        case element.target.classList.contains('show-reviews'):
          element.target.textContent = 'Hide reviews'
          element.target.className = 'text-button hide-reviews'
          document.querySelector('.reviews-container').classList.toggle('active')
          break;
        case element.target.classList.contains('hide-reviews'):
          element.target.textContent = 'View product reviews'
          element.target.className = 'text-button show-reviews'
          document.querySelector('.reviews-container').classList.toggle('active')
          break;
      }
    })

    document.querySelector('.modal').addEventListener('mouseover', element => {
      if (element.target.classList.contains('star-label'))
      {
        let starValue = parseInt(element.target.nextElementSibling.value)
        this.calculateStarsBackground(starValue)
      }
    })
  }

  // Take the rating of the selected product in order to
  // calculate it as percentage and color the stars depending on such percentage
  calculateStarsBackground(rating)
  {
    const container = document.querySelector('.product-rating form')
    const percentage = (rating * 100) / 5
    container.style.background = `linear-gradient(to right, gold 0, gold ${percentage}%, #ccc ${percentage}%)`
    container.style.backgroundClip = 'text'
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
    let container = document.querySelector('.right-sidebar .container')

    this.http.post(`${this.baseURL}/${route}`)
      .then(response => {
        if (response)
          // If deletion was successful reload cart template
          return this.http.get(`${this.baseURL}/cart`)
        else
          return false
      })
      .then(newCartTemplate => {
        if (newCartTemplate)
        {
          this.emptyContainer(container)

          setTimeout(() => {
            this.loadTemplate(newCartTemplate, container)
            this.handleShipping(document.getElementById('shipping'))
            document.getElementById('shipping').addEventListener('change', this.handleShipping)
          }, 100);

          document.querySelector('.counter').textContent = parseInt(document.querySelector('.counter').textContent) - 1

          if (document.querySelector('.counter').textContent === '0')
            document.querySelector('.counter').style.display = 'none'
        }
        else
          alert('Something went wrong. Please try again')
      })
      .catch(error => console.log(error))
  }

  // Add/Subtract shipping costs
  handleShipping(element)
  {
    const selectedValue = (element.target === undefined) ? parseFloat(element.value) : parseFloat(element.target.value)
    const subtotal = parseFloat(document.querySelector('.subtotal-value').innerText)
    let total = 0

    switch (selectedValue) {
      case 0:
        total = subtotal
        break;

      case 7:
        total = (subtotal + (subtotal * 0.07)).toFixed(2)
        break;
    }

    document.querySelector(".total-value").innerHTML = total
    // Update hidden input value
    document.getElementById('shippingInput').value = selectedValue
  }
}

export { UI }