window.toggleLoginRegistration = () => {
    document.querySelector('#login-form').toggleAttribute('hidden')
    document.querySelector('#reg-form').toggleAttribute('hidden')
    document.querySelector('#to-registration').toggleAttribute('hidden')
    document.querySelector('#to-login').toggleAttribute('hidden')
}
