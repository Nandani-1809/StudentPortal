const themeToggle = document.getElementById("themeToggle");

function applyTheme(theme) {

    if (theme === "dark") {

        document.body.classList.add("dark-theme");

        if (themeToggle) {
            themeToggle.textContent = "☀️ Light Mode";
        }

    } else {

        document.body.classList.remove("dark-theme");

        if (themeToggle) {
            themeToggle.textContent = "🌙 Dark Mode";
        }
    }
}
const savedTheme = localStorage.getItem("studentHubTheme");

if (savedTheme) {
    applyTheme(savedTheme);
} else {
    applyTheme("light");
}
if (themeToggle) {

    themeToggle.addEventListener("click", function () {

        if (document.body.classList.contains("dark-theme")) {

            applyTheme("light");

            localStorage.setItem(
                "studentHubTheme",
                "light"
            );

        } else {

            applyTheme("dark");

            localStorage.setItem(
                "studentHubTheme",
                "dark"
            );
        }

    });
}


const menuToggle = document.getElementById("menuToggle");
const navigation = document.querySelector("header nav");

if (menuToggle && navigation) {

    menuToggle.addEventListener("click", function () {

        navigation.classList.toggle("show-menu");

        const isOpen =
            navigation.classList.contains("show-menu");

        menuToggle.setAttribute(
            "aria-expanded",
            isOpen
        );

    });
}


const notificationBanner =
    document.getElementById("notificationBanner");

const closeNotification =
    document.getElementById("closeNotification");

if (closeNotification && notificationBanner) {

    closeNotification.addEventListener(
        "click",
        function () {

            notificationBanner.style.display = "none";

        }
    );
}
const faqQuestions =
    document.querySelectorAll(".faq-question");

faqQuestions.forEach(function (question) {

    question.addEventListener("click", function () {

        const answer =
            question.nextElementSibling;

        const isOpen =
            answer.classList.contains("show");


        // Close all other FAQ answers

        document
            .querySelectorAll(".faq-answer")
            .forEach(function (item) {

                item.classList.remove("show");

            });


        document
            .querySelectorAll(".faq-question")
            .forEach(function (item) {

                item.classList.remove("open");

                item.setAttribute(
                    "aria-expanded",
                    "false"
                );

            });


        // Open selected FAQ

        if (!isOpen) {

            answer.classList.add("show");

            question.classList.add("open");

            question.setAttribute(
                "aria-expanded",
                "true"
            );
        }

    });

});


// ==========================================
// PRACTICAL 4
// MODAL
// ==========================================

const openModal =
    document.getElementById("openModal");

const closeModal =
    document.getElementById("closeModal");

const infoModal =
    document.getElementById("infoModal");


if (openModal && infoModal) {

    openModal.addEventListener(
        "click",
        function () {

            infoModal.classList.add("show");

            document.body.style.overflow = "hidden";

        }
    );
}


if (closeModal && infoModal) {

    closeModal.addEventListener(
        "click",
        function () {

            infoModal.classList.remove("show");

            document.body.style.overflow = "";

        }
    );
}


// Close modal by clicking outside

if (infoModal) {

    infoModal.addEventListener(
        "click",
        function (event) {

            if (event.target === infoModal) {

                infoModal.classList.remove("show");

                document.body.style.overflow = "";
            }

        }
    );
}


// Close modal with Escape key

document.addEventListener(
    "keydown",
    function (event) {

        if (
            event.key === "Escape" &&
            infoModal &&
            infoModal.classList.contains("show")
        ) {

            infoModal.classList.remove("show");

            document.body.style.overflow = "";
        }

    }
);


// ==========================================
// PRACTICAL 4
// CONTENT SLIDER
// ==========================================

const slides =
    document.querySelectorAll(".slide");

const previousSlide =
    document.getElementById("prevSlide");

const nextSlide =
    document.getElementById("nextSlide");

let currentSlide = 0;


function showSlide(index) {

    if (slides.length === 0) {
        return;
    }


    if (index >= slides.length) {
        currentSlide = 0;
    }

    else if (index < 0) {
        currentSlide = slides.length - 1;
    }

    else {
        currentSlide = index;
    }


    slides.forEach(function (slide) {

        slide.classList.remove("active-slide");

    });


    slides[currentSlide]
        .classList.add("active-slide");
}


if (nextSlide) {

    nextSlide.addEventListener(
        "click",
        function () {

            showSlide(currentSlide + 1);

        }
    );
}


if (previousSlide) {

    previousSlide.addEventListener(
        "click",
        function () {

            showSlide(currentSlide - 1);

        }
    );
}


// ==========================================
// PRACTICAL 5
// FRONTEND FORM VALIDATION
// ==========================================

const form = document.getElementById("registrationForm");

if (form) {

    // ======================================
    // GET FORM ELEMENTS
    // ======================================

    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const enrollment = document.getElementById("enrollment");
    const email = document.getElementById("email");
    const mobile = document.getElementById("mobile");
    const dob = document.getElementById("dob");
    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("confirmPassword");
    const course = document.getElementById("course");
    const year = document.getElementById("year");
    const terms = document.getElementById("terms");

    // ======================================
    // REGULAR EXPRESSIONS
    // ======================================

    // Only letters and spaces; 2 to 30 characters
    const nameRegex = /^[A-Za-z ]{2,30}$/;

    // Allows enrollment formats such as 25CS073
    const enrollmentRegex = /^[A-Za-z0-9-]{5,20}$/;

    // Standard email format
    const emailRegex =
        /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

    // Indian mobile number:
    // exactly 10 digits and starts with 6, 7, 8 or 9
    const mobileRegex = /^[6-9][0-9]{9}$/;

    // Password must contain uppercase, lowercase,
    // digit and special character
    const passwordRegex =
        /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[^A-Za-z0-9]).{8,}$/;


    // ======================================
    // SHOW ERROR
    // ======================================

    function showError(input, errorId, message) {

        input.classList.add("invalid");
        input.classList.remove("valid");

        input.setAttribute(
            "aria-invalid",
            "true"
        );

        const errorElement =
            document.getElementById(errorId);

        if (errorElement) {

            errorElement.textContent =
                message;
        }
    }


    // ======================================
    // SHOW VALID
    // ======================================

    function showValid(input, errorId) {

        input.classList.remove("invalid");

        input.classList.add("valid");

        input.setAttribute(
            "aria-invalid",
            "false"
        );

        const errorElement =
            document.getElementById(errorId);

        if (errorElement) {

            errorElement.textContent =
                "";
        }
    }


    // ======================================
    // FIRST NAME
    // ======================================

    function validateFirstName() {

        const value =
            firstName.value.trim();

        if (value === "") {

            showError(
                firstName,
                "firstNameError",
                "First name is required."
            );

            return false;
        }

        if (!nameRegex.test(value)) {

            showError(
                firstName,
                "firstNameError",
                "First name must contain only letters and spaces (2-30 characters)."
            );

            return false;
        }

        showValid(
            firstName,
            "firstNameError"
        );

        return true;
    }


    // ======================================
    // LAST NAME
    // ======================================

    function validateLastName() {

        const value =
            lastName.value.trim();

        if (value === "") {

            showError(
                lastName,
                "lastNameError",
                "Last name is required."
            );

            return false;
        }

        if (!nameRegex.test(value)) {

            showError(
                lastName,
                "lastNameError",
                "Last name must contain only letters and spaces (2-30 characters)."
            );

            return false;
        }

        showValid(
            lastName,
            "lastNameError"
        );

        return true;
    }


    // ======================================
    // ENROLLMENT NUMBER
    // ======================================

    function validateEnrollment() {

        const value =
            enrollment.value.trim().toUpperCase();

        if (value === "") {

            showError(
                enrollment,
                "enrollmentError",
                "Enrollment number is required."
            );

            return false;
        }

        if (!enrollmentRegex.test(value)) {

            showError(
                enrollment,
                "enrollmentError",
                "Enter a valid enrollment number using 5-20 letters, digits or hyphens."
            );

            return false;
        }

        showValid(
            enrollment,
            "enrollmentError"
        );

        return true;
    }


    // ======================================
    // EMAIL
    // ======================================

    function validateEmail() {

        const value =
            email.value.trim();

        if (value === "") {

            showError(
                email,
                "emailError",
                "Email address is required."
            );

            return false;
        }

        if (!emailRegex.test(value)) {

            showError(
                email,
                "emailError",
                "Enter a valid email address, for example student@example.com."
            );

            return false;
        }

        showValid(
            email,
            "emailError"
        );

        return true;
    }


    // ======================================
    // MOBILE NUMBER
    // ======================================

    function validateMobile() {

        const value =
            mobile.value.trim();

        if (value === "") {

            showError(
                mobile,
                "mobileError",
                "Mobile number is required."
            );

            return false;
        }


        // Check whether the value contains only digits

        if (!/^[0-9]+$/.test(value)) {

            showError(
                mobile,
                "mobileError",
                "Mobile number must contain digits only."
            );

            return false;
        }


        // Check exactly 10 digits

        if (value.length !== 10) {

            showError(
                mobile,
                "mobileError",
                "Mobile number must contain exactly 10 digits."
            );

            return false;
        }


        // Check first digit for Indian mobile number

        if (!/^[6-9]/.test(value)) {

            showError(
                mobile,
                "mobileError",
                "For an Indian mobile number, the first digit must be 6, 7, 8 or 9."
            );

            return false;
        }


        // Final regex validation

        if (!mobileRegex.test(value)) {

            showError(
                mobile,
                "mobileError",
                "Enter a valid 10-digit Indian mobile number."
            );

            return false;
        }


        showValid(
            mobile,
            "mobileError"
        );

        return true;
    }


    // ======================================
    // DATE OF BIRTH
    // ======================================

    function validateDOB() {

        if (dob.value === "") {

            showError(
                dob,
                "dobError",
                "Please select your date of birth."
            );

            return false;
        }

        const selectedDate =
            new Date(dob.value);

        const today =
            new Date();

        if (selectedDate > today) {

            showError(
                dob,
                "dobError",
                "Date of birth cannot be in the future."
            );

            return false;
        }

        showValid(
            dob,
            "dobError"
        );

        return true;
    }


    // ======================================
    // PASSWORD STRENGTH
    // ======================================

    function checkPasswordStrength() {

        const value =
            password.value;

        const strengthBar =
            document.getElementById("strengthBar");

        const strengthText =
            document.getElementById("strengthText");

        let strength = 0;


        // Minimum 8 characters

        if (value.length >= 8) {
            strength++;
        }


        // Uppercase

        if (/[A-Z]/.test(value)) {
            strength++;
        }


        // Lowercase

        if (/[a-z]/.test(value)) {
            strength++;
        }


        // Number

        if (/[0-9]/.test(value)) {
            strength++;
        }


        // Special character

        if (/[^A-Za-z0-9]/.test(value)) {
            strength++;
        }


        // Display password strength

        if (value.length === 0) {

            strengthBar.style.width =
                "0%";

            strengthText.textContent =
                "";

        }

        else if (strength <= 2) {

            strengthBar.style.width =
                "40%";

            strengthText.textContent =
                "Weak Password";

        }

        else if (strength <= 4) {

            strengthBar.style.width =
                "70%";

            strengthText.textContent =
                "Medium Password";

        }

        else {

            strengthBar.style.width =
                "100%";

            strengthText.textContent =
                "Strong Password";
        }

        return strength;
    }


    // ======================================
    // PASSWORD
    // ======================================

    function validatePassword() {

        const value =
            password.value;

        if (value === "") {

            showError(
                password,
                "passwordError",
                "Password is required."
            );

            return false;
        }


        // Check minimum length

        if (value.length < 8) {

            showError(
                password,
                "passwordError",
                "Password must contain at least 8 characters."
            );

            return false;
        }


        // Check uppercase

        if (!/[A-Z]/.test(value)) {

            showError(
                password,
                "passwordError",
                "Password must contain at least one uppercase letter (A-Z)."
            );

            return false;
        }


        // Check lowercase

        if (!/[a-z]/.test(value)) {

            showError(
                password,
                "passwordError",
                "Password must contain at least one lowercase letter (a-z)."
            );

            return false;
        }


        // Check number

        if (!/[0-9]/.test(value)) {

            showError(
                password,
                "passwordError",
                "Password must contain at least one number (0-9)."
            );

            return false;
        }


        // Check special character

        if (!/[^A-Za-z0-9]/.test(value)) {

            showError(
                password,
                "passwordError",
                "Password must contain at least one special character, such as @, # or $."
            );

            return false;
        }


        // Final password regex

        if (!passwordRegex.test(value)) {

            showError(
                password,
                "passwordError",
                "Use uppercase, lowercase, number and special character."
            );

            return false;
        }


        showValid(
            password,
            "passwordError"
        );

        return true;
    }


    // ======================================
    // CONFIRM PASSWORD
    // ======================================

    function validateConfirmPassword() {

        const value =
            confirmPassword.value;

        if (value === "") {

            showError(
                confirmPassword,
                "confirmPasswordError",
                "Please confirm your password."
            );

            return false;
        }

        if (value !== password.value) {

            showError(
                confirmPassword,
                "confirmPasswordError",
                "Passwords do not match. Please enter the same password."
            );

            return false;
        }

        showValid(
            confirmPassword,
            "confirmPasswordError"
        );

        return true;
    }


    // ======================================
    // COURSE
    // ======================================

    function validateCourse() {

        if (course.value === "") {

            showError(
                course,
                "courseError",
                "Please select your department."
            );

            return false;
        }

        showValid(
            course,
            "courseError"
        );

        return true;
    }


    // ======================================
    // YEAR
    // ======================================

    function validateYear() {

        if (year.value === "") {

            showError(
                year,
                "yearError",
                "Please select your year of study."
            );

            return false;
        }

        showValid(
            year,
            "yearError"
        );

        return true;
    }


    // ======================================
    // GENDER
    // ======================================

    function validateGender() {

        const selected =
            document.querySelector(
                'input[name="gender"]:checked'
            );

        const error =
            document.getElementById("genderError");

        if (!selected) {

            error.textContent =
                "Please select your gender.";

            return false;
        }

        error.textContent = "";

        return true;
    }


    // ======================================
    // TERMS AND CONDITIONS
    // ======================================

    function validateTerms() {

        const error =
            document.getElementById("termsError");

        if (!terms.checked) {

            error.textContent =
                "You must accept the Terms and Conditions to register.";

            return false;
        }

        error.textContent = "";

        return true;
    }


    // ======================================
    // REAL-TIME VALIDATION
    // ======================================

    firstName.addEventListener(
        "input",
        validateFirstName
    );


    lastName.addEventListener(
        "input",
        validateLastName
    );


    enrollment.addEventListener(
        "input",
        function () {

            enrollment.value =
                enrollment.value.toUpperCase();

            validateEnrollment();
        }
    );


    email.addEventListener(
        "input",
        validateEmail
    );


    mobile.addEventListener(
        "input",
        function () {

            // Keep only digits
            // and limit input to 10 digits

            mobile.value =
                mobile.value
                    .replace(/\D/g, "")
                    .slice(0, 10);

            validateMobile();
        }
    );


    dob.addEventListener(
        "change",
        validateDOB
    );


    password.addEventListener(
        "input",
        function () {

            checkPasswordStrength();

            validatePassword();


            // Recheck confirmation
            // if the original password changes

            if (confirmPassword.value !== "") {

                validateConfirmPassword();
            }
        }
    );


    confirmPassword.addEventListener(
        "input",
        validateConfirmPassword
    );


    course.addEventListener(
        "change",
        validateCourse
    );


    year.addEventListener(
        "change",
        validateYear
    );


    document
        .querySelectorAll(
            'input[name="gender"]'
        )
        .forEach(function (radio) {

            radio.addEventListener(
                "change",
                validateGender
            );

        });


    terms.addEventListener(
        "change",
        validateTerms
    );


    // ======================================
    // FORM SUBMIT
    // ======================================

    form.addEventListener(
        "submit",
        function (event) {

            event.preventDefault();


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


            if (
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
                validTerms
            ) {

                document
                    .getElementById("successMessage")
                    .textContent =
                    "Registration successful! All details are valid.";

            } else {

                document
                    .getElementById("successMessage")
                    .textContent =
                    "";
            }

        }
    );


    // ======================================
    // CLEAR BUTTON
    // ======================================

    form.addEventListener(
        "reset",
        function () {

            setTimeout(
                function () {

                    const fields =
                        form.querySelectorAll(
                            "input, select, textarea"
                        );


                    fields.forEach(
                        function (field) {

                            field.classList.remove(
                                "valid",
                                "invalid"
                            );

                            field.removeAttribute(
                                "aria-invalid"
                            );

                        }
                    );


                    const errors =
                        form.querySelectorAll(
                            ".error"
                        );


                    errors.forEach(
                        function (error) {

                            error.textContent =
                                "";

                        }
                    );


                    document
                        .getElementById("strengthBar")
                        .style.width =
                        "0%";


                    document
                        .getElementById("strengthText")
                        .textContent =
                        "";


                    document
                        .getElementById("successMessage")
                        .textContent =
                        "";

                },
                0
            );

        }
    );

}
const datasetSelect = document.getElementById("datasetSelect");
const searchInput = document.getElementById("searchInput");
const filterSelect = document.getElementById("filterSelect");
const sortSelect = document.getElementById("sortSelect");

const dataContainer = document.getElementById("dataContainer");
const pagination = document.getElementById("pagination");

const loadingMessage = document.getElementById("loadingMessage");
const errorMessage = document.getElementById("errorMessage");

// Store currently loaded data
let practical6Data = [];

// Current page number
let currentPage = 1;

// Number of records shown on one page
const recordsPerPage = 6;
async function fetchPractical6Data(dataset) {

    // Show loading message
    if (loadingMessage) {
        loadingMessage.style.display = "block";
        loadingMessage.textContent = "Loading data...";
    }

    // Hide previous error
    if (errorMessage) {
        errorMessage.style.display = "none";
    }

    try {

        const filePath = "data/" + dataset + ".json";

        // Fetch external JSON file
        const response = await fetch(filePath);

        // Check whether request was successful
        if (!response.ok) {
            throw new Error(
                "Unable to load " + dataset + ".json"
            );
        }

        // Convert JSON response into JavaScript object/array
        const data = await response.json();

        // Store data
        practical6Data = data;

        // Cache latest JSON response in localStorage
        localStorage.setItem(
            "studentHub_" + dataset,
            JSON.stringify(data)
        );

        currentPage = 1;

        // Update filter options
        updateFilterOptions(dataset);

        // Display records
        renderPractical6Data();

    }

    catch (error) {

        console.error(
            "Fetch Error:",
            error
        );

        // Try to load cached data
        const cachedData =
            localStorage.getItem(
                "studentHub_" + dataset
            );

        if (cachedData) {

            practical6Data =
                JSON.parse(cachedData);

            currentPage = 1;

            updateFilterOptions(dataset);

            renderPractical6Data();

            if (loadingMessage) {
                loadingMessage.style.display =
                    "block";

                loadingMessage.textContent =
                    "Showing cached data because the latest data could not be loaded.";
            }

        }

        else {

            practical6Data = [];

            dataContainer.innerHTML = "";

            pagination.innerHTML = "";

            if (errorMessage) {

                errorMessage.style.display =
                    "block";

                errorMessage.textContent =
                    "Error loading data. Please check the JSON file or try again.";
            }

        }

    }

    finally {

        if (
            loadingMessage &&
            !loadingMessage.textContent.includes(
                "cached"
            )
        ) {

            loadingMessage.style.display =
                "none";

        }

    }

}


// ==========================================
// UPDATE FILTER OPTIONS
// ==========================================

function updateFilterOptions(dataset) {

    if (!filterSelect) {
        return;
    }

    filterSelect.innerHTML =
        '<option value="all">All</option>';

    let filterValues = [];

    if (dataset === "events") {

        filterValues =
            practical6Data.map(
                function (item) {
                    return item.category;
                }
            );

    }

    else if (dataset === "students") {

        filterValues =
            practical6Data.map(
                function (item) {
                    return item.course;
                }
            );

    }

    else if (dataset === "faqs") {

        filterValues =
            practical6Data.map(
                function (item) {
                    return item.category;
                }
            );

    }

    // Remove duplicate values
    filterValues =
        [...new Set(filterValues)];

    filterValues.forEach(
        function (value) {

            if (value) {

                const option =
                    document.createElement(
                        "option"
                    );

                option.value = value;

                option.textContent = value;

                filterSelect.appendChild(
                    option
                );

            }

        }
    );

}


// ==========================================
// GET FILTERED DATA
// ==========================================

function getFilteredData() {

    let filteredData =
        [...practical6Data];

    const searchText =
        searchInput.value
            .toLowerCase()
            .trim();

    const selectedFilter =
        filterSelect.value;

    const selectedSort =
        sortSelect.value;


    // ======================================
    // SEARCH
    // ======================================

    if (searchText !== "") {

        filteredData =
            filteredData.filter(
                function (item) {

                    return Object.values(item)
                        .join(" ")
                        .toLowerCase()
                        .includes(searchText);

                }
            );

    }


    // ======================================
    // FILTER
    // ======================================

    if (selectedFilter !== "all") {

        filteredData =
            filteredData.filter(
                function (item) {

                    return (
                        item.category ===
                        selectedFilter ||

                        item.course ===
                        selectedFilter
                    );

                }
            );

    }


    // ======================================
    // SORT
    // ======================================

    if (selectedSort === "az") {

        filteredData.sort(
            function (a, b) {

                const valueA =
                    (
                        a.name ||
                        a.question ||
                        ""
                    ).toLowerCase();

                const valueB =
                    (
                        b.name ||
                        b.question ||
                        ""
                    ).toLowerCase();

                return valueA.localeCompare(
                    valueB
                );

            }
        );

    }

    else if (selectedSort === "za") {

        filteredData.sort(
            function (a, b) {

                const valueA =
                    (
                        a.name ||
                        a.question ||
                        ""
                    ).toLowerCase();

                const valueB =
                    (
                        b.name ||
                        b.question ||
                        ""
                    ).toLowerCase();

                return valueB.localeCompare(
                    valueA
                );

            }
        );

    }


    return filteredData;

}


// ==========================================
// RENDER DATA
// ==========================================

function renderPractical6Data() {

    const filteredData =
        getFilteredData();

    dataContainer.innerHTML = "";

    pagination.innerHTML = "";


    // No records found
    if (filteredData.length === 0) {

        dataContainer.innerHTML =
            "<p class='no-data'>No records found.</p>";

        return;

    }


    // ======================================
    // PAGINATION CALCULATION
    // ======================================

    const totalPages =
        Math.ceil(
            filteredData.length /
            recordsPerPage
        );

    if (currentPage > totalPages) {
        currentPage = totalPages;
    }

    const startIndex =
        (currentPage - 1) *
        recordsPerPage;

    const endIndex =
        startIndex +
        recordsPerPage;

    const pageData =
        filteredData.slice(
            startIndex,
            endIndex
        );


    // ======================================
    // CREATE CARDS
    // ======================================

    pageData.forEach(
        function (item) {

            const card =
                document.createElement(
                    "div"
                );

            card.className =
                "json-card";


            // EVENTS
            if (
                item.name &&
                item.date &&
                item.venue
            ) {

                card.innerHTML = `
                    <h3>📅 ${item.name}</h3>

                    <p>
                        <strong>Date:</strong>
                        ${item.date}
                    </p>

                    <p>
                        <strong>Venue:</strong>
                        ${item.venue}
                    </p>

                    <p>
                        <strong>Category:</strong>
                        ${item.category}
                    </p>
                `;

            }


            // STUDENTS
            else if (
                item.name &&
                item.course &&
                item.year
            ) {

                card.innerHTML = `
                    <h3>👤 ${item.name}</h3>

                    <p>
                        <strong>Course:</strong>
                        ${item.course}
                    </p>

                    <p>
                        <strong>Year:</strong>
                        ${item.year}
                    </p>

                    <p>
                        <strong>City:</strong>
                        ${item.city}
                    </p>
                `;

            }


            // FAQ
            else if (
                item.question &&
                item.answer
            ) {

                card.innerHTML = `
                    <h3>❓ ${item.question}</h3>

                    <p>
                        ${item.answer}
                    </p>

                    <p>
                        <strong>Category:</strong>
                        ${item.category}
                    </p>
                `;

            }


            dataContainer.appendChild(
                card
            );

        }
    );


    // Create pagination buttons
    createPagination(
        totalPages
    );

}


// ==========================================
// PAGINATION
// ==========================================

function createPagination(totalPages) {

    pagination.innerHTML = "";


    // Previous button

    const previousButton =
        document.createElement(
            "button"
        );

    previousButton.textContent =
        "← Previous";

    previousButton.disabled =
        currentPage === 1;

    previousButton.addEventListener(
        "click",
        function () {

            if (currentPage > 1) {

                currentPage--;

                renderPractical6Data();

            }

        }
    );

    pagination.appendChild(
        previousButton
    );


    // Page number buttons

    for (
        let page = 1;
        page <= totalPages;
        page++
    ) {

        const pageButton =
            document.createElement(
                "button"
            );

        pageButton.textContent =
            page;

        if (page === currentPage) {

            pageButton.classList.add(
                "active-page"
            );

        }

        pageButton.addEventListener(
            "click",
            function () {

                currentPage = page;

                renderPractical6Data();

            }
        );

        pagination.appendChild(
            pageButton
        );

    }


    // Next button

    const nextButton =
        document.createElement(
            "button"
        );

    nextButton.textContent =
        "Next →";

    nextButton.disabled =
        currentPage === totalPages;

    nextButton.addEventListener(
        "click",
        function () {

            if (
                currentPage <
                totalPages
            ) {

                currentPage++;

                renderPractical6Data();

            }

        }
    );

    pagination.appendChild(
        nextButton
    );

}


// ==========================================
// EVENT LISTENERS
// ==========================================

// Change dataset

if (datasetSelect) {

    datasetSelect.addEventListener(
        "change",
        function () {

            searchInput.value = "";

            sortSelect.value =
                "default";

            currentPage = 1;

            fetchPractical6Data(
                datasetSelect.value
            );

        }
    );

}


// Search

if (searchInput) {

    searchInput.addEventListener(
        "input",
        function () {

            currentPage = 1;

            renderPractical6Data();

        }
    );

}


// Filter

if (filterSelect) {

    filterSelect.addEventListener(
        "change",
        function () {

            currentPage = 1;

            renderPractical6Data();

        }
    );

}


// Sort

if (sortSelect) {

    sortSelect.addEventListener(
        "change",
        function () {

            currentPage = 1;

            renderPractical6Data();

        }
    );

}
if (datasetSelect && dataContainer) {
    fetchPractical6Data(datasetSelect.value);
}
// ================================================
// Registration Form Validation
// ================================================

const registrationForm = document.getElementById("registrationForm");

if (registrationForm) {

    registrationForm.addEventListener("submit", function (event) {

        let valid = true;

        // ------------------------------------------
        // Get fields
        // ------------------------------------------

        const name = document.getElementById("name");
        const enrollment = document.getElementById("enrollment");
        const email = document.getElementById("email");
        const mobile = document.getElementById("mobile");
        const dob = document.getElementById("dob");
        const department = document.getElementById("department");
        const year = document.getElementById("year");
        const password = document.getElementById("password");
        const confirmPassword =
            document.getElementById("confirmPassword");
        const terms = document.getElementById("terms");


        // ------------------------------------------
        // Remove old invalid classes
        // ------------------------------------------

        const fields = [
            name,
            enrollment,
            email,
            mobile,
            dob,
            department,
            year,
            password,
            confirmPassword
        ];

        fields.forEach(function (field) {

            if (field) {
                field.classList.remove("invalid");
            }

        });


        // ------------------------------------------
        // Name
        // ------------------------------------------

        if (
            name.value.trim() === "" ||
            !/^[a-zA-Z ]+$/.test(name.value.trim())
        ) {

            name.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // Enrollment
        // ------------------------------------------

        if (enrollment.value.trim() === "") {

            enrollment.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // Email
        // ------------------------------------------

        const emailPattern =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(email.value.trim())) {

            email.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // Mobile
        // ------------------------------------------

        const mobilePattern = /^[0-9]{10}$/;

        if (!mobilePattern.test(mobile.value.trim())) {

            mobile.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // DOB
        // ------------------------------------------

        if (dob.value === "") {

            dob.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // Department
        // ------------------------------------------

        if (department.value === "") {

            department.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // Year
        // ------------------------------------------

        if (year.value === "") {

            year.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // Password
        // ------------------------------------------

        if (password.value.length < 6) {

            password.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // Confirm Password
        // ------------------------------------------

        if (
            confirmPassword.value !== password.value ||
            confirmPassword.value === ""
        ) {

            confirmPassword.classList.add("invalid");

            valid = false;

        }


        // ------------------------------------------
        // Terms
        // ------------------------------------------

        if (!terms.checked) {

            valid = false;

        }
        if (!valid) {

            event.preventDefault();

            alert(
                "Please correct the highlighted fields before submitting."
            );

        }

    });

}