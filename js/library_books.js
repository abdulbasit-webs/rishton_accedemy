document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const bookTable = document.querySelector('.book-table tbody');

    // Search books by title
    function searchBooks() {
        const input = searchInput.value.toLowerCase();
        const rows = bookTable.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const titleCell = rows[i].getElementsByTagName('td')[0];
            if (titleCell) {
                const title = titleCell.textContent.toLowerCase();
                if (title.includes(input)) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }
    }

    // Event listener for the search input
    searchInput.addEventListener('input', searchBooks);
});
