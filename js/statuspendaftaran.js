document.addEventListener('DOMContentLoaded', function () {
    const pendaftaranTable = document.getElementById('pendaftaran-table');
    const addPenerimaBtn = document.getElementById('add-penerima');

    // Fetch data when the page loads
    fetchData();

    // Fetch Data Function
    function fetchData() {
        fetch('../php/crud.php?action=fetch')
            .then(response => response.json())
            .then(data => {
                pendaftaranTable.innerHTML = ''; // Clear current data
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.setAttribute('data-id', row.id);
                    tr.innerHTML = `
                        <td contenteditable="true" data-column="nama_pendaftar">${row.nama_pendaftar}</td>
                        <td contenteditable="true" data-column="program">${row.program}</td>
                        <td contenteditable="true" data-column="status">${row.status}</td>
                        <td contenteditable="true" data-column="sekolah">${row.sekolah}</td>
                        <td>
                            <button class="edit-button">Edit</button>
                            <button class="delete-button">Delete</button>
                        </td>
                    `;
                    pendaftaranTable.appendChild(tr);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Add event listener for adding a new entry
    addPenerimaBtn.addEventListener('click', function () {
        const formData = {
            nama_pendaftar: 'New Name', // Placeholder, you can create a form for input
            program: 'Beasiswa Cendekia', // Placeholder
            status: 'Diterima', // Placeholder
            sekolah: 'Sekolah Baru', // Placeholder
            action: 'create'
        };

        fetch('../php/crud.php', {
            method: 'POST',
            body: new URLSearchParams(formData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                fetchData(); // Reload data
            } else {
                alert(data.message);
            }
        });
    });

    // Handle Edit Button Click
    pendaftaranTable.addEventListener('click', function (event) {
        if (event.target.classList.contains('edit-button')) {
            const tr = event.target.closest('tr');
            const id = tr.getAttribute('data-id');
            const cells = tr.querySelectorAll('td[data-column]');
            const updatedData = {};

            cells.forEach(cell => {
                updatedData[cell.getAttribute('data-column')] = cell.textContent;
            });

            updatedData.id = id;
            updatedData.action = 'update';

            fetch('../php/crud.php', {
                method: 'POST',
                body: new URLSearchParams(updatedData),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Data updated');
                } else {
                    alert(data.message);
                }
            });
        }

        // Handle Delete Button Click
        if (event.target.classList.contains('delete-button')) {
            const tr = event.target.closest('tr');
            const id = tr.getAttribute('data-id');

            if (confirm('Are you sure you want to delete this entry?')) {
                fetch('../php/crud.php', {
                    method: 'POST',
                    body: new URLSearchParams({ id: id, action: 'delete' }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        tr.remove(); // Remove row from table
                    } else {
                        alert(data.message);
                    }
                });
            }
        }
    });
});
