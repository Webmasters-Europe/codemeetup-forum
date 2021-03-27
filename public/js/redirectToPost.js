const redirectToPost = (url) => {
    const options = Array.from(document.querySelectorAll('#search-results option'));
    const values = options.map(el => el.value);
    if (values.includes(url)) {
        window.location.href = url;
    }
}