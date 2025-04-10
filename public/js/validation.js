/**
 * Client-side form validation utilities
 */

// Email validation function
function validateEmail(email) {
    const re =
        /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

// Password strength check (at least 8 characters, with at least one number and one letter)
function checkPasswordStrength(password) {
    if (password.length < 8) {
        return {
            valid: false,
            message: "パスワードは8文字以上で入力してください。",
        };
    }

    const hasLetter = /[a-zA-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);

    if (!hasLetter || !hasNumber) {
        return {
            valid: false,
            message:
                "パスワードには少なくとも1つの文字と1つの数字を含める必要があります。",
        };
    }

    return {
        valid: true,
        message: "",
    };
}

// Add error message after an element
function addErrorMessage(element, message) {
    return;
    const errorElement = document.createElement("span");
    errorElement.className = "jp-error-message";
    errorElement.textContent = message;

    // Remove any existing error messages
    const existingError = element.parentNode.querySelector(".jp-error-message");
    if (existingError) {
        existingError.remove();
    }

    // Add new error message
    if (
        element.parentNode.className.includes("jp-input-wrapper") ||
        element.parentNode.className.includes("jp-select-wrapper")
    ) {
        element.parentNode.after(errorElement);
    } else {
        element.after(errorElement);
    }
}

// Remove error message
function removeErrorMessage(element) {
    let errorElement;

    if (
        element.parentNode.className.includes("jp-input-wrapper") ||
        element.parentNode.className.includes("jp-select-wrapper")
    ) {
        errorElement = element.parentNode.nextElementSibling;
    } else {
        errorElement = element.nextElementSibling;
    }

    if (errorElement && errorElement.className.includes("jp-error-message")) {
        errorElement.remove();
    }
}

// Add input validation listeners
document.addEventListener("DOMContentLoaded", function () {
    // Add validation to email inputs
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach((input) => {
        input.addEventListener("blur", function () {
            if (this.value && !validateEmail(this.value)) {
                addErrorMessage(
                    this,
                    "有効なメールアドレスを入力してください。"
                );
            } else {
                removeErrorMessage(this);
            }
        });
    });

    // Add validation to password inputs
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    passwordInputs.forEach((input) => {
        // Only add validation to password creation fields, not login fields
        if (
            input.id === "password" &&
            document.getElementById("password-confirm")
        ) {
            input.addEventListener("blur", function () {
                if (this.value) {
                    const result = checkPasswordStrength(this.value);
                    if (!result.valid) {
                        addErrorMessage(this, result.message);
                    } else {
                        removeErrorMessage(this);
                    }
                }
            });
        }
    });

    // Add validation to password confirmation
    const passwordConfirm = document.getElementById("password-confirm");
    if (passwordConfirm) {
        passwordConfirm.addEventListener("blur", function () {
            const password = document.getElementById("password").value;
            if (this.value && this.value !== password) {
                addErrorMessage(this, "パスワードが一致しません。");
            } else {
                removeErrorMessage(this);
            }
        });
    }

    // Add validation to required inputs
    const requiredInputs = document.querySelectorAll("input[required]");
    requiredInputs.forEach((input) => {
        input.addEventListener("blur", function () {
            if (!this.value.trim()) {
                let fieldName = this.previousElementSibling
                    ? this.previousElementSibling.textContent
                    : "このフィールド";
                addErrorMessage(this, `${fieldName}を入力してください。`);
            } else {
                removeErrorMessage(this);
            }
        });
    });
});
