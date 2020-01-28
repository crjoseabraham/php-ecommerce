// Display corresponding content for X navbar link
document.querySelectorAll('.container-links #nav-btn').forEach(navLink => {
    navLink.addEventListener('click', element => {
        element.preventDefault()
        // Hide arrow
        for (let link of document.querySelectorAll('#menu .container-links > a')) {
            if (link.firstElementChild)
                link.firstElementChild.classList.remove('active')
        }
        // Display content box
        document.querySelectorAll('.menu-content-box .content').forEach(contentDiv => {
            if (contentDiv.dataset.content === element.target.dataset.content)
                contentDiv.classList.toggle('active')
            else
                contentDiv.classList.remove('active')
            // Display little arrow
            if (contentDiv.classList.contains('active'))
                navLink.firstElementChild.classList.toggle('active')
        })
    })
})