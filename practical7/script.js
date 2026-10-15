
// ============================================================
// STUDENT HUB PORTAL
// COMPLETE JAVASCRIPT
// ============================================================


// ============================================================
// REGISTRATION FORM VALIDATION
// ============================================================

const form = document.getElementById("registrationForm");

if (form) {

    // --------------------------------------------------------
    // GET FORM ELEMENTS
    // --------------------------------------------------------

    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const enrollment = document.getElementById("enrollment");
    const email = document.getElementById("email");
    const mobile = document.getElementById("mobile");
    const dob = document.getElementById("dob");
    const password = document.getElementById("password");
    const confirmPassword =
        document.getElementById("confirmPassword");
    const course = document.getElementById("course");
    const year = document.getElementById("year");
    const terms = document.getElementById("terms");


    // --------------------------------------------------------
    // REGULAR EXPRESSIONS
    // --------------------------------------------------------

    const nameRegex = /^[A-Za-z ]+$/;

    // Example: 25CS073
    const enrollmentRegex = /^[0-9]{2}[A-Z]{2}[0-9]{3}$/;

    // Example: student@example.com
    const emailRegex =
        /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

    // Exactly 10 digits
    const mobileRegex = /^[0-9]{10}$/;

    // At least:
    // 8 characters
    // 1 uppercase
    // 1 lowercase
    // 1 number
    // 1 special character
    const passwordRegex =
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/;


    // --------------------------------------------------------
    // SHOW ERROR
    // --------------------------------------------------------

    function showError(input, message) {

        if (!input) {
            return false;
        }

        const errorElement =
            document.getElementById(input.id + "Error");

        if (errorElement) {
            errorElement.textContent = message;
        }

        input.classList.add("error");

        return false;
    }


    // --------------------------------------------------------
    // CLEAR ERROR
    // --------------------------------------------------------

    function clearError(input) {

        if (!input) {
            return;
        }

        const errorElement =
            document.getElementById(input.id + "Error");

        if (errorElement) {
            errorElement.textContent = "";
        }

        input.classList.remove("error");
    }


    // ========================================================
    // FIRST NAME VALIDATION
    // ========================================================

    function validateFirstName() {

        if (!firstName) {
            return false;
        }

        const value = firstName.value.trim();

        if (value === "") {

            return showError(
                firstName,
                "First name is required."
            );
        }

        if (!nameRegex.test(value)) {

            return showError(
                firstName,
                "First name should contain only letters."
            );
        }

        clearError(firstName);

        return true;
    }


    // ========================================================
    // LAST NAME VALIDATION
    // ========================================================

    function validateLastName() {

        if (!lastName) {
            return false;
        }

        const value = lastName.value.trim();

        if (value === "") {

            return showError(
                lastName,
                "Last name is required."
            );
        }

        if (!nameRegex.test(value)) {

            return showError(
                lastName,
                "Last name should contain only letters."
            );
        }

        clearError(lastName);

        return true;
    }


    // ========================================================
    // ENROLLMENT VALIDATION
    // ========================================================

    function validateEnrollment() {

        if (!enrollment) {
            return false;
        }

        const value =
            enrollment.value.trim().toUpperCase();

        // Convert typed enrollment to uppercase
        enrollment.value = value;

        if (value === "") {

            return showError(
                enrollment,
                "Enrollment number is required."
            );
        }

        if (!enrollmentRegex.test(value)) {

            return showError(
                enrollment,
                "Enter a valid enrollment number. Example: 25CS073"
            );
        }

        clearError(enrollment);

        return true;
    }


    // ========================================================
    // EMAIL VALIDATION
    // ========================================================

    function validateEmail() {

        if (!email) {
            return false;
        }

        const value = email.value.trim();

        if (value === "") {

            return showError(
                email,
                "Email address is required."
            );
        }

        if (!emailRegex.test(value)) {

            return showError(
                email,
                "Enter a valid email address."
            );
        }

        clearError(email);

        return true;
    }


    // ========================================================
    // MOBILE VALIDATION
    // ========================================================

    function validateMobile() {

        if (!mobile) {
            return false;
        }

        const value = mobile.value.trim();

        if (value === "") {

            return showError(
                mobile,
                "Mobile number is required."
            );
        }

        if (!mobileRegex.test(value)) {

            return showError(
                mobile,
                "Mobile number must contain exactly 10 digits."
            );
        }

        clearError(mobile);

        return true;
    }


    // ========================================================
    // DATE OF BIRTH VALIDATION
    // ========================================================

    function validateDOB() {

        if (!dob) {
            return false;
        }

        const value = dob.value;

        if (value === "") {

            return showError(
                dob,
                "Date of birth is required."
            );
        }

        const selectedDate = new Date(value);
        const today = new Date();

        // Remove time portion for accurate comparison
        today.setHours(0, 0, 0, 0);

        if (selectedDate > today) {

            return showError(
                dob,
                "Date of birth cannot be in the future."
            );
        }

        clearError(dob);

        return true;
    }


    // ========================================================
    // PASSWORD VALIDATION
    // ========================================================

    function validatePassword() {

        if (!password) {
            return false;
        }

        const value = password.value;

        if (value === "") {

            return showError(
                password,
                "Password is required."
            );
        }

        if (!passwordRegex.test(value)) {

            return showError(
                password,
                "Password must contain at least 8 characters, one uppercase letter, one lowercase letter, one number and one special character."
            );
        }

        clearError(password);

        return true;
    }


    // ========================================================
    // CONFIRM PASSWORD VALIDATION
    // ========================================================

    function validateConfirmPassword() {

        if (!confirmPassword) {
            return false;
        }

        const value = confirmPassword.value;

        if (value === "") {

            return showError(
                confirmPassword,
                "Please confirm your password."
            );
        }

        if (!password || value !== password.value) {

            return showError(
                confirmPassword,
                "Passwords do not match."
            );
        }

        clearError(confirmPassword);

        return true;
    }


    // ========================================================
    // COURSE VALIDATION
    // ========================================================

    function validateCourse() {

        if (!course) {
            return false;
        }

        if (course.value === "") {

            return showError(
                course,
                "Please select your course."
            );
        }

        clearError(course);

        return true;
    }


    // ========================================================
    // YEAR VALIDATION
    // ========================================================

    function validateYear() {

        if (!year) {
            return false;
        }

        if (year.value === "") {

            return showError(
                year,
                "Please select your year."
            );
        }

        clearError(year);

        return true;
    }


    // ========================================================
    // GENDER VALIDATION
    // ========================================================

    function validateGender() {

        const selectedGender =
            document.querySelector(
                'input[name="gender"]:checked'
            );

        const genderError =
            document.getElementById("genderError");

        if (!selectedGender) {

            if (genderError) {
                genderError.textContent =
                    "Please select your gender.";
            }

            return false;
        }

        if (genderError) {
            genderError.textContent = "";
        }

        return true;
    }


    // ========================================================
    // TERMS VALIDATION
    // ========================================================

    function validateTerms() {

        if (!terms) {
            return false;
        }

        const termsError =
            document.getElementById("termsError");

        if (!terms.checked) {

            if (termsError) {
                termsError.textContent =
                    "You must accept the terms and conditions.";
            }

            return false;
        }

        if (termsError) {
            termsError.textContent = "";
        }

        return true;
    }


    // ========================================================
    // PASSWORD STRENGTH
    // ========================================================

    function checkPasswordStrength() {

        if (!password) {
            return;
        }

        const value = password.value;

        const strengthElement =
            document.getElementById("passwordStrength");

        // If the HTML doesn't have this element,
        // simply skip this feature.
        if (!strengthElement) {
            return;
        }

        if (value.length === 0) {

            strengthElement.textContent = "";

            return;
        }

        let score = 0;

        if (value.length >= 8) {
            score++;
        }

        if (/[A-Z]/.test(value)) {
            score++;
        }

        if (/[a-z]/.test(value)) {
            score++;
        }

        if (/[0-9]/.test(value)) {
            score++;
        }

        if (/[^A-Za-z0-9]/.test(value)) {
            score++;
        }


        if (score <= 2) {

            strengthElement.textContent =
                "Weak password";

        }
        else if (score <= 4) {

            strengthElement.textContent =
                "Medium password";

        }
        else {

            strengthElement.textContent =
                "Strong password";
        }
    }


    // ========================================================
    // REAL-TIME VALIDATION
    // ========================================================

    if (firstName) {

        firstName.addEventListener(
            "blur",
            validateFirstName
        );
    }


    if (lastName) {

        lastName.addEventListener(
            "blur",
            validateLastName
        );
    }


    if (enrollment) {

        enrollment.addEventListener(
            "blur",
            validateEnrollment
        );
    }


    if (email) {

        email.addEventListener(
            "blur",
            validateEmail
        );
    }


    if (mobile) {

        mobile.addEventListener(
            "blur",
            validateMobile
        );
    }


    if (dob) {

        dob.addEventListener(
            "change",
            validateDOB
        );
    }


    if (password) {

        password.addEventListener(
            "input",
            checkPasswordStrength
        );

        password.addEventListener(
            "blur",
            validatePassword
        );
    }


    if (confirmPassword) {

        confirmPassword.addEventListener(
            "blur",
            validateConfirmPassword
        );
    }


    if (course) {

        course.addEventListener(
            "change",
            validateCourse
        );
    }


    if (year) {

        year.addEventListener(
            "change",
            validateYear
        );
    }


    if (terms) {

        terms.addEventListener(
            "change",
            validateTerms
        );
    }


    // Gender radio buttons
    document
        .querySelectorAll('input[name="gender"]')
        .forEach(function (radio) {

            radio.addEventListener(
                "change",
                validateGender
            );

        });


    // ========================================================
    // FORM SUBMISSION
    // ========================================================

    form.addEventListener(
        "submit",
        function (event) {

            // Run every validation
            const validFirstName =
                validateFirstName();

            const validLastName =
                validateLastName();

            const validEnrollment =
                validateEnrollment();

            const validEmail =
                validateEmail();

            const validMobile =
                validateMobile();

            const validDOB =
                validateDOB();

            const validPassword =
                validatePassword();

            const validConfirmPassword =
                validateConfirmPassword();

            const validCourse =
                validateCourse();

            const validYear =
                validateYear();

            const validGender =
                validateGender();

            const validTerms =
                validateTerms();


            // Check all validation results
            const allValid =
                validFirstName &&
                validLastName &&
                validEnrollment &&
                validEmail &&
                validMobile &&
                validDOB &&
                validPassword &&
                validConfirmPassword &&
                validCourse &&
                validYear &&
                validGender &&
                validTerms;


            // ------------------------------------------------
            // INVALID FORM
            // ------------------------------------------------

            if (!allValid) {

                // STOP the form
                // PHP will NOT receive invalid data.
                event.preventDefault();


                const successMessage =
                    document.getElementById(
                        "successMessage"
                    );

                if (successMessage) {

                    successMessage.textContent = "";
                }


                // Move user to the first invalid field
                const firstError =
                    form.querySelector(
                        ".error"
                    );

                if (firstError) {

                    firstError.focus();
                }

                return;
            }
        }
    );
}
if (window.history.replaceState) {
    window.history.replaceState(null,null,window.location.href);
}
