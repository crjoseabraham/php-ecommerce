// Display corresponding content for X navbar link
document.querySelectorAll('.container-links #nav-btn').forEach(navLink => {
    navLink.addEventListener('click', element => {
        element.preventDefault()
        document.querySelectorAll('.menu-content-box .content').forEach(contentDiv => {
            if (contentDiv.dataset.content === element.target.dataset.content)
                contentDiv.classList.toggle('active')
            else
                contentDiv.classList.remove('active')
        })
    })
})