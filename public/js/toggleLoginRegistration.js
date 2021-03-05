
    const toggleLoginRegistration = () => {
        document.querySelector("#login-form").toggleAttribute("hidden");
        document.querySelector("#reg-form").toggleAttribute("hidden");
        const link = document.querySelector("#toggle-login-reg");
        if (link.textContent === "I'm already registered") {
            link.textContent = "I'm not registered yet";
        } else {
            link.textContent = "I'm already registered"
        }
    }
