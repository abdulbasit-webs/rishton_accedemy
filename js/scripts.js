
// For mobile menu 

// Toggle mobile menu
const mobileMenu = document.getElementById('mobile-menu');
const navLinks = document.getElementById('nav-links');

mobileMenu.addEventListener('click', () => {
    mobileMenu.classList.toggle('is-active');
    navLinks.classList.toggle('active');
});

// Dropdown toggle for the additional menu
document.querySelector('.dropdown > a').addEventListener('click', function (event) {
    event.preventDefault();
    const dropdown = this.parentElement;
    dropdown.classList.toggle('active');
});





// Handle Modal Display
const modal = document.getElementById('modal');
const openModalBtn = document.querySelector('.open-modal-btn');
const closeModalBtn = document.querySelector('.close-modal');

openModalBtn.addEventListener('click', () => {
    modal.style.display = 'block';
});

closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

// Handle Sliding Search Tab
function toggleSearchTab() {
    const searchTab = document.getElementById('search-tab');
    if (searchTab.style.display === 'none' || searchTab.style.display === '') {
        searchTab.style.display = 'block';
    } else {
        searchTab.style.display = 'none';
    }
}

// Filter Classes (Search Functionality)
function filterClasses() {
    const input = document.getElementById('search-input');
    const filter = input.value.toLowerCase();
    const table = document.querySelector('.class-table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const className = rows[i].getElementsByTagName('td')[0].innerText.toLowerCase();
        const section = rows[i].getElementsByTagName('td')[1].innerText.toLowerCase();
        if (className.includes(filter) || section.includes(filter)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

// For search functionality in filterClasses section 
// Function to handle class search
function searchClasses() {
    const input = document.getElementById('search-input').value.toLowerCase();
    const table = document.querySelector('.class-table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const className = rows[i].getElementsByTagName('td')[0].innerText.toLowerCase();
        const teacherName = rows[i].getElementsByTagName('td')[2].innerText.toLowerCase();
        if (className.includes(input) || teacherName.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

// Add search functionality with Enter key
document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchClasses();
    }
});



// For Pupiles search functionality

// Function to handle pupil search
function searchPupils() {
    const input = document.getElementById('search-input').value.toLowerCase();
    const table = document.querySelector('.class-table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const pupilName = rows[i].getElementsByTagName('td')[0].innerText.toLowerCase();
        const className = rows[i].getElementsByTagName('td')[3].innerText.toLowerCase();
        if (pupilName.includes(input) || className.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

// Add search functionality with Enter key
document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchPupils();
    }
});



// Teachers Search functioanlity js


// Function to handle teacher search
function searchTeachers() {
    const input = document.getElementById('search-input').value.toLowerCase();
    const table = document.querySelector('.class-table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const teacherName = rows[i].getElementsByTagName('td')[0].innerText.toLowerCase();
        if (teacherName.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

// Add search functionality with Enter key
document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchTeachers();
    }
});



// parents js section


/// Function to handle parent search
function searchParents() {
    const input = document.getElementById('search-input').value.toLowerCase();
    const table = document.querySelector('.class-table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const parentName = rows[i].getElementsByTagName('td')[0].innerText.toLowerCase();
        const childName = rows[i].getElementsByTagName('td')[3].innerText.toLowerCase();
        if (parentName.includes(input) || childName.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

// Add search functionality with Enter key
document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchParents();
    }
});



// Js for teaching assitant

// Function to handle teaching assistant search
function searchAssistants() {
    const input = document.getElementById('search-input').value.toLowerCase();
    const table = document.querySelector('.class-table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const assistantName = rows[i].getElementsByTagName('td')[0].innerText.toLowerCase();
        if (assistantName.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

// Add search functionality with Enter key
document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchAssistants();
    }
});


// Js for diners Money

// Function to handle dinner money search
function searchDinnerMoney() {
    const input = document.getElementById('search-input').value.toLowerCase();
    const table = document.querySelector('.dinner-money-table tbody');
    const rows = table.getElementsByTagName('tr');

    for (let i = 0; i < rows.length; i++) {
        const pupilName = rows[i].getElementsByTagName('td')[0].innerText.toLowerCase();
        if (pupilName.includes(input)) {
            rows[i].style.display = '';
        } else {
            rows[i].style.display = 'none';
        }
    }
}

// Add search functionality with Enter key
document.getElementById('search-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchDinnerMoney();
    }
});

// Js for library book 

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const bookTable = document.querySelector('.book-table tbody');

    // Search Books Function
    function searchBooks() {
        const filter = searchInput.value.toLowerCase();
        const rows = bookTable.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const title = row.getElementsByTagName('td')[0].textContent.toLowerCase();
            row.style.display = title.includes(filter) ? '' : 'none';
        });
    }

    // Add event listener for search input
    searchInput.addEventListener('input', searchBooks);
});





document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('library-search-input');
    const bookTable = document.querySelector('.library-book-table tbody');

    // Search Books Function
    function searchBooks() {
        const filter = searchInput.value.toLowerCase();
        const rows = bookTable.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const title = row.getElementsByTagName('td')[0].textContent.toLowerCase();
            row.style.display = title.includes(filter) ? '' : 'none';
        });
    }

    // Add event listener for search input
    searchInput.addEventListener('input', searchBooks);
});
