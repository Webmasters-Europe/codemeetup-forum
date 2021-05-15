body {
    font-family: 'Nunito Sans', sans-serif;
    color: #212529;
    font-size: 1rem;
}

a {
    color: #212529;
}

a:hover {
    text-decoration: none;
    opacity: 0.8;
    cursor: pointer;
}

h1 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #212529;
}

h2 {
    font-size: 1.4rem;
    font-weight: 700;
    color: #212529;
}

h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #212529;
}

label {
    font-size: 1rem;
}

input.form-control,
textarea {
    border-radius: 5px;
    padding: 20px;
    font-size: 1rem;
}

.btn:focus,
input:focus,
input.form-control:focus,
textarea:focus {
    outline: none !important;
    outline-width: 0 !important;
    box-shadow: none;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
}

.btn {
    font-size: 1rem;
    border-radius: 5px;
}

#navbar .navbar-brand {
    font-size: 2rem;
    font-weight: 700;
}

#app {
    position: relative;
    min-height: 100vh;
    padding-bottom: 50px;
}

@media (max-width: 768px) {
    #app {
        padding-bottom: 150px;
    }
}

.content-wrap {
    padding-bottom: 50px;
}

/* Main */

#main .icon,
#main .posts-count {
    text-align: center;
}

/* Footer */

#footer {
    position: absolute;
    min-height: 50px;
    bottom: 0;
    width: 100%;
}

#footer a:hover {
    background: rgba(255, 255, 255, 0.2);
}

/* Search */

#search-results {
    position: absolute;
    background-color: white;
    z-index: 999;
    border: 1px solid;
    box-shadow: 0 12px 12px rgba(0, 0, 0, 0.15);
    width: 90%;
}

#search-results ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

#search-results ul h5 {
    margin-top: 1rem;
}

#search-results .opensearch-inner {
    overflow-y: scroll;
    max-height: 80vh;
}

.disabled-reply {
    min-height: 150px;
}

/* Replies */

.reply {}

.reply-info {}

.icon {
    color: {{ config('app.settings.category_icons_color') }};
}

a:hover {
    color: {{ config('app.settings.primary_color') }};
}

input:focus,
input.form-control:focus,
textarea:focus {
    border: {
            {
            config('app.settings.primary_color')
        }
    }

    2px solid;
}

.btn {
    background-color: {
            {
            config('app.settings.primary_color')
        }
    }

    ;

    color: {
            {
            config('app.settings.button_text_color')
        }
    }

    ;

    border: {
            {
            config('app.settings.primary_color')
        }
    }

    1px solid;
}

.btn:hover,
.btn:focus {
    background-color: {
            {
            config('app.settings.primary_color')
        }
    }

    ;

    color: {
            {
            config('app.settings.button_text_color')
        }
    }

    ;
    opacity: 0.8;

    border: {
            {
            config('app.settings.primary_color')
        }
    }

    1px solid;
}

.outline-primary {
    background-color: transparent;

    color: {
            {
            config('app.settings.primary_color')
        }
    }

    ;

    border: {
            {
            config('app.settings.primary_color')
        }
    }

    solid 1px;
}

.outline-primary:hover {
    background-color: {
            {
            config('app.settings.primary_color')
        }
    }

    ;

    color: {
            {
            config('app.settings.button_text_color')
        }
    }

    ;
}

#navbar.navbar {
    background-color: {
            {
            config('app.settings.primary_color')
        }
    }

    ;
}

#navbar .navbar-brand {
    color: {
            {
            config('app.settings.button_text_color')
        }
    }

    ;
}

#footer {
    background-color: {
            {
            config('app.settings.primary_color')
        }
    }

    ;

    color: {
            {
            config('app.settings.button_text_color')
        }
    }

    ;
}

#footer a {
    color: {
            {
            config('app.settings.button_text_color')
        }
    }

    ;
}

#footer a:hover {
    color: #212529;


}

.page-link {
    color: {
        {
            config('app.settings.primary_color')
        } 
    }
    background-color: {
            {
            config('app.settings.primary_color')
        }
    }
    border-color: {
            {
            config('app.settings.primary_color')
        }
    }
}

.page-link:hover {
    opacity: 0.8;
}

.badge {
    background-color: {
            {
            config('app.settings.primary_color')
        }
    }
}