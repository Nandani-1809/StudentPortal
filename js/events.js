// ================= FETCH EVENTS DATA =================

let events = [];
let currentPage = 1;

const recordsPerPage = 5;


// Fetch events from JSON file

async function fetchEvents() {

    const loadingMessage =
        document.getElementById("loadingMessage");

    const errorMessage =
        document.getElementById("errorMessage");

    loadingMessage.style.display = "block";
    loadingMessage.textContent = "Loading events...";

    errorMessage.style.display = "none";

    try {

        // Fetch external JSON file

        const response =
            await fetch("data/events.json");


        // Check whether JSON file was loaded successfully

        if (!response.ok) {

            throw new Error("Unable to load events.json");

        }


        // Convert JSON response into JavaScript data

        const data =
            await response.json();


        // Store fetched data

        events = data;


        // Store data in localStorage

        localStorage.setItem(
            "studentHub_events",
            JSON.stringify(events)
        );


        // Create category options

        loadCategories();


        // Start from first page

        currentPage = 1;


        // Display events

        displayEvents();


        // Hide loading message

        loadingMessage.style.display = "none";

    }

    catch (error) {

        console.error("Fetch Error:", error);


        // Try cached data

        const cachedData =
            localStorage.getItem("studentHub_events");


        if (cachedData) {

            events =
                JSON.parse(cachedData);


            loadCategories();


            currentPage = 1;


            displayEvents();


            loadingMessage.style.display = "block";

            loadingMessage.textContent =
                "Showing cached event data because the latest data could not be loaded.";

        }

        else {

            loadingMessage.style.display = "none";

            errorMessage.style.display = "block";

            errorMessage.textContent =
                "Error loading events. Please check events.json and try again.";

        }

    }

}



// ================= LOAD CATEGORIES =================

function loadCategories() {

    const categoryFilter =
        document.getElementById("categoryFilter");


    // Clear existing options

    categoryFilter.innerHTML = "";


    // Add All Categories option

    const allOption =
        document.createElement("option");

    allOption.value = "all";

    allOption.textContent = "All Categories";

    categoryFilter.appendChild(allOption);


    // Get all categories from events

    const categories =
        [...new Set(
            events.map(event => event.category)
        )];


    // Sort categories alphabetically

    categories.sort();


    // Add categories to dropdown

    categories.forEach(category => {

        const option =
            document.createElement("option");

        option.value = category;

        option.textContent = category;

        categoryFilter.appendChild(option);

    });

}



// ================= GET PROCESSED EVENTS =================

function getProcessedEvents() {

    // Create a copy of events

    let filteredEvents =
        [...events];


    // Get search text

    const searchText =
        document.getElementById("searchEvent")
        .value
        .toLowerCase()
        .trim();


    // Get selected category

    const selectedCategory =
        document.getElementById("categoryFilter").value;


    // Get selected sorting option

    const sortType =
        document.getElementById("sortEvent").value;



    // ================= SEARCH =================

    if (searchText !== "") {

        filteredEvents =
            filteredEvents.filter(event =>

                event.name.toLowerCase()
                    .includes(searchText)

                ||

                event.category.toLowerCase()
                    .includes(searchText)

                ||

                event.venue.toLowerCase()
                    .includes(searchText)

                ||

                event.date.toLowerCase()
                    .includes(searchText)

            );

    }



    // ================= FILTER =================

    if (selectedCategory !== "all") {

        filteredEvents =
            filteredEvents.filter(event =>

                event.category === selectedCategory

            );

    }



    // ================= SORT =================

    if (sortType === "dateAsc") {

        filteredEvents.sort((a, b) =>

            new Date(a.date) -
            new Date(b.date)

        );

    }

    else if (sortType === "dateDesc") {

        filteredEvents.sort((a, b) =>

            new Date(b.date) -
            new Date(a.date)

        );

    }

    else if (sortType === "titleAsc") {

        filteredEvents.sort((a, b) =>

            a.name.localeCompare(b.name)

        );

    }

    else if (sortType === "titleDesc") {

        filteredEvents.sort((a, b) =>

            b.name.localeCompare(a.name)

        );

    }



    return filteredEvents;

}



// ================= DISPLAY EVENTS =================

function displayEvents() {

    const filteredEvents =
        getProcessedEvents();


    const tableBody =
        document.getElementById(
            "eventsTableBody"
        );


    const pagination =
        document.getElementById(
            "pagination"
        );


    // Clear previous data

    tableBody.innerHTML = "";

    pagination.innerHTML = "";



    // ================= NO RECORDS =================

    if (filteredEvents.length === 0) {

        tableBody.innerHTML = `

            <tr>

                <td colspan="4"
                    style="text-align:center; padding:20px;">

                    No events found.

                </td>

            </tr>

        `;

        return;

    }



    // ================= PAGINATION =================

    const totalPages =
        Math.ceil(
            filteredEvents.length /
            recordsPerPage
        );


    // Prevent invalid page

    if (
        currentPage > totalPages
    ) {

        currentPage = totalPages;

    }


    const start =
        (currentPage - 1) *
        recordsPerPage;


    const end =
        start + recordsPerPage;


    const pageEvents =
        filteredEvents.slice(
            start,
            end
        );



    // ================= RENDER EVENTS =================

    pageEvents.forEach(event => {

        const row =
            document.createElement("tr");


        row.innerHTML = `

            <td>${event.name}</td>

            <td>${event.category}</td>

            <td>${formatDate(event.date)}</td>

            <td>${event.venue}</td>

        `;


        tableBody.appendChild(row);

    });



    // Display pagination

    displayPagination(totalPages);

}



// ================= FORMAT DATE =================

function formatDate(dateString) {

    const date =
        new Date(dateString);


    return date.toLocaleDateString(
        "en-IN",
        {
            day: "2-digit",
            month: "short",
            year: "numeric"
        }
    );

}



// ================= PAGINATION BUTTONS =================

function displayPagination(totalPages) {

    const pagination =
        document.getElementById(
            "pagination"
        );


    pagination.innerHTML = "";


    // No pagination needed

    if (totalPages <= 1) {

        return;

    }



    // ================= PREVIOUS BUTTON =================

    const previousButton =
        document.createElement("button");


    previousButton.textContent =
        "Previous";


    previousButton.disabled =
        currentPage === 1;


    previousButton.style.margin =
        "5px";


    previousButton.style.padding =
        "8px 15px";


    previousButton.addEventListener(
        "click",
        () => {

            if (currentPage > 1) {

                currentPage--;

                displayEvents();

            }

        }
    );


    pagination.appendChild(
        previousButton
    );



    // ================= PAGE NUMBERS =================

    for (
        let i = 1;
        i <= totalPages;
        i++
    ) {

        const button =
            document.createElement("button");


        button.textContent = i;


        button.style.margin =
            "5px";


        button.style.padding =
            "8px 12px";


        if (i === currentPage) {

            button.style.fontWeight =
                "bold";

        }


        button.addEventListener(
            "click",
            () => {

                currentPage = i;

                displayEvents();

            }
        );


        pagination.appendChild(
            button
        );

    }



    // ================= NEXT BUTTON =================

    const nextButton =
        document.createElement("button");


    nextButton.textContent =
        "Next";


    nextButton.disabled =
        currentPage === totalPages;


    nextButton.style.margin =
        "5px";


    nextButton.style.padding =
        "8px 15px";


    nextButton.addEventListener(
        "click",
        () => {

            if (
                currentPage <
                totalPages
            ) {

                currentPage++;

                displayEvents();

            }

        }
    );


    pagination.appendChild(
        nextButton
    );

}



// ================= SEARCH EVENT =================

document
    .getElementById("searchEvent")
    .addEventListener(
        "input",
        () => {

            currentPage = 1;

            displayEvents();

        }
    );



// ================= FILTER EVENT =================

document
    .getElementById("categoryFilter")
    .addEventListener(
        "change",
        () => {

            currentPage = 1;

            displayEvents();

        }
    );



// ================= SORT EVENT =================

document
    .getElementById("sortEvent")
    .addEventListener(
        "change",
        () => {

            currentPage = 1;

            displayEvents();

        }
    );



// ================= START APPLICATION =================

fetchEvents();