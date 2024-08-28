

//  i make salaries js file seprate because its some listners conflicts with other pages



document.addEventListener('DOMContentLoaded', function () {
    const staffTypeSelect = document.getElementById('staff-type');
    const staffIdSelect = document.getElementById('staff-id');

    console.log('JavaScript loaded and running.');

    staffTypeSelect.addEventListener('change', function () {
        console.log('Staff type changed:', this.value);

        const staffType = this.value;
        staffIdSelect.innerHTML = '<option value="">Select a staff member</option>'; // Clear existing options

        if (staffType) {
            console.log('Sending request to fetch_staff.php for:', staffType);

            fetch('fetch_staff.php?staff_type=' + staffType)
                .then(response => response.json())
                .then(data => {
                    console.log('Received response:', data);

                    if (data.error) {
                        console.error(data.error);  // Log any errors received from the server
                    } else {
                        data.forEach(staff => {
                            const option = document.createElement('option');
                            option.value = staff.id;
                            option.text = staff.name;
                            staffIdSelect.add(option);  // Add new option to dropdown
                        });
                    }
                })
                .catch(error => console.error('Fetch error:', error));
        }
    });
});
