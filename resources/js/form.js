document.querySelector('#pegawaiTable').addEventListener('change', function(event) {
    if (event.target.classList.contains('namaPegawai')) {
        const selectedOption = event.target.options[event.target.selectedIndex];
        const row = event.target.closest('tr');
        const departemenInput = row.querySelector('.departemen');
        const nikInput = row.querySelector('.nik');

        if (selectedOption && departemenInput && nikInput) {
            departemenInput.value = selectedOption.getAttribute('data-departemen');
            nikInput.value = selectedOption.getAttribute('data-nik');
        }
    }
});

document.querySelector('#pegawaiTable').addEventListener('click', function(event) {
    if (event.target.classList.contains('namaPegawaiDisplay')) {
        const row = event.target.closest('tr');
        const dropdown = row.querySelector('.namaPegawai');
        dropdown.style.display = 'block';
        event.target.style.display = 'none';
    }
});

document.getElementById('add-field').addEventListener('click', function() {
    const rowToClone = document.querySelector('#pegawaiTable tbody tr');
    if (rowToClone) {
        const newRow = rowToClone.cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(input => input.value = '');
        document.querySelector('#pegawaiTable tbody').appendChild(newRow);
        $(newRow).find('.select2').select2();
    }
});

document.querySelector('#pegawaiTable').addEventListener('click', function(event) {
    if (event.target.classList.contains('btn-remove')) {
        event.target.closest('tr').remove();
    }
});

document.querySelector('form').addEventListener('submit', function(e) {
    const namaPegawaiInputs = document.querySelectorAll('.namaPegawai');
    namaPegawaiInputs.forEach((select, index) => {
        const selectedOption = select.options[select.selectedIndex];
        const nama = selectedOption.getAttribute('data-nama');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = `namaPegawaiNama[${index}]`;
        input.value = nama;
        this.appendChild(input);
    });
});

$(document).ready(function() {
    $('.select2').select2();
});