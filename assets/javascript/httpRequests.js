class HttpRequests
{
  async get(url)
  {
    let request = await fetch(url)
    return await request.text()
  }

  async post(url, data = '')
  {
    const request = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-type': 'application/json'
      },
      body: JSON.stringify(data)
    })

    const response = await request.json()
    return response
  }
}

export { HttpRequests }