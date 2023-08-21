$(document).ready(function() {
    initialize_theme();
    const localStorageItems = [
        "username-error",
        "email-error",
        "password-error",
        "github-error",
        "confirm-password-error"
    ];
    
    localStorageItems.forEach(item => {
        localStorage.setItem(item, true);
    });    
});

function initialize_theme() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'night') {
        $('body').addClass('night');
        $('#theme-toggle').prop("checked", true);
    }
}

function toggle_theme() {
    $('body').toggleClass('night');
    const currentTheme = $('body').hasClass('night') ? 'night' : 'day';
    localStorage.setItem('theme', currentTheme);
    $('#theme-toggle').prop("checked", currentTheme === 'night');
}

var debouncedCheckUsername;

async function is_username_unique(e, file) {
    const username = e.target.value.trim();
    clearTimeout(debouncedCheckUsername);

    debouncedCheckUsername = setTimeout(async () => {
        if (username !== '') {
            try {
                const response = await fetch(file + '?username=' + encodeURIComponent(username), {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data) {
                    $('#username-msg').text("Username is unique.").removeClass("error").addClass("msg");
                     localStorage.setItem('username-error', false);
                } else {
                    $('#username-msg').text("Username is not unique!").removeClass("msg").addClass("error");
                    localStorage.setItem('username-error', true);
                }
            } catch (error) {
                console.error('Error checking username uniqueness:', error);
                localStorage.setItem('username-error', false);
            }
        }
        else
            $('#username-msg').text("");
    }, 300);
}

var debouncedCheckEmail;

async function is_email_valid(e, file) {
    const email = e.target.value.trim();
    const emailRegex = /\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\b/i;
    if(emailRegex.test(email))
    {
        clearTimeout(debouncedCheckEmail);
        debouncedCheckEmail = setTimeout(async () => {
            if (email !== '') {
                try {
                    const response = await fetch(file + '?email=' + encodeURIComponent(email), {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    const data = await response.json();
                    if (data.isUnique) {
                        $('#email-msg').text("Email is unique.").removeClass("error").addClass("msg");
                        localStorage.setItem('email-error', false);
                    } else {
                        $('#email-msg').text("Email is not unique!").removeClass("msg").addClass("error");
                        localStorage.setItem('email-error', true);
                    }
                } catch (error) {
                    console.error('Error checking email uniqueness:', error);
                    localStorage.setItem('email-error', true);
                }
            }
            else
                $('#email-msg').text("");
        }, 300);
    }
    else if(email !== '') {        
        $('#email-msg').text("Not a valid email!").removeClass("msg").addClass("error");
        localStorage.setItem('email-error', true);
    }    
    else if(email === ''){
        $('#email-msg').text("");
        localStorage.setItem('email-error', false);
    }
}

var debouncedCheckPassword;

async function is_password_valid(e, file) {
    is_confirm_password_valid();
    const password = e.target.value.trim();
    clearTimeout(debouncedCheckPassword);
    debouncedCheckPassword = setTimeout(async () => {
        if (password !== '') {
            const passwordMsgElement = $('#password-msg');
            passwordMsgElement.empty().removeClass("error");
            try {
                const response = await fetch(file + '?password=' + encodeURIComponent(password), {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.length > 0) {
                    data.forEach(error => {
                        const errorMessage = $('<div>').text(error);
                        passwordMsgElement.append(errorMessage);
                    });
                    passwordMsgElement.addClass("error");
                    localStorage.setItem('password-error', true);
                } else
                     localStorage.setItem('password-error', false);
            } catch (error) {
                console.error('Error checking password validity:', error);
                localStorage.setItem('password-error', true);
            }
        } else {
            const passwordMsgElement = $('#password-msg');
            passwordMsgElement.empty().removeClass("error");
            localStorage.setItem('password-error', false);
        }
    }, 300);
}

function is_confirm_password_valid(){
    const password = $('#password').val().trim();
    const confirmPassword = $('#confirm_password').val().trim(); 
    const passwordMsgElement = $('#confirm-password-msg');
    passwordMsgElement.empty().removeClass("error");
    if (confirmPassword != '' && password !== confirmPassword) {
        const errorMessage = $('<div>').text("Password and Confirm Passowrd do not match.");
        passwordMsgElement.append(errorMessage);
        passwordMsgElement.addClass("error");
        localStorage.setItem('confirm-password-error', true);
    }
    else
        localStorage.setItem('confirm-password-error', false);
}

var isApiCallPending = false;

function throttle(fn, delay) {
    let timeoutId;

    return function (...args) {
        if (!isApiCallPending) {
            fn.apply(this, args);
            isApiCallPending = true;
            timeoutId = setTimeout(() => {
                isApiCallPending = false;
            }, delay);
        }
    };
}

function user_exists() {
    const user = $('#github').val().trim();
    const apiUrl = `https://api.github.com/users/${user}`;
    const throttled_api_call = throttle(async () => {
        try {
            const response = await fetch(apiUrl);
            if (response.status === 404) {
                $('#github-username-msg').text("User Not Found!").removeClass("msg").addClass("error");
                localStorage.setItem('github-error', true);
            } else if (response.status === 200) {
                $('#github-username-msg').text("User Found!").removeClass("error").addClass("msg");
                localStorage.setItem('github-error', false);
            } else {
                $('#github-username-msg').text("Api Error, try again later!").removeClass("msg").addClass("error");
                localStorage.setItem('github-error', true);
            }

        } catch (error) {
            console.error('Error checking user existence:', error);
            localStorage.setItem('github-error', true);
        }
    }, 2000); 
    throttled_api_call();
}

async function can_submit(event, file) {
    if (localStorage.getItem("username-error") === "true" ||
        localStorage.getItem("email-error") === "true" ||
        localStorage.getItem("password-error") === "true" ||
        localStorage.getItem("github-error") === "true" ||
        localStorage.getItem("confirm-password-error") === "true") {
        console.log("Cannot submit");
    } else {
        console.log("Can submit");
        const username = $('#username').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const github = $('#github').val();
        $.ajax({
            type: "POST",
            url: file,
            data: {
                username,
                email,
                password,
                github
            },
            success: function(response) {
                console.log("Form submitted successfully");
                window.location.href = "../index.php"
            },
            error: function(error) {
                console.log("Error submitting form:", error);
            }
        });
    }
}
