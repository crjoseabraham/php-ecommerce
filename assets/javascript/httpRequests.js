class HttpRequests
{
  async get(url)
  {
    let request = await fetch(url)
    return await request.text()
  }
}

export { HttpRequests }