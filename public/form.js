// Add click event listener to table rows
document.querySelectorAll('.table-row').forEach(row => {
    row.addEventListener('click', () => {
        // Remove highlight from all rows
        document.querySelectorAll('.table-row').forEach(row => {
            row.classList.remove('highlight');
        });

        // Highlight the clicked row
        row.classList.add('highlight');
    });
});