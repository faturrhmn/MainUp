import DataTable from 'datatables.net-dt';

document.addEventListener('DOMContentLoaded', function () {
  let table = new DataTable('#assetsTable', {
    processing: true,
    pageLength: 10,
    language: {
      search: 'Cari:',
      lengthMenu: 'Tampilkan _MENU_ data per halaman',
      zeroRecords: 'Tidak ada data yang ditemukan',
      info: 'Menampilkan halaman _PAGE_ dari _PAGES_',
      infoEmpty: 'Tidak ada data yang tersedia',
      infoFiltered: '(difilter dari _MAX_ total data)',
      paginate: {
        first: 'Pertama',
        last: 'Terakhir',
        next: 'Selanjutnya',
        previous: 'Sebelumnya'
      }
    },
    columnDefs: [{ orderable: true, targets: '_all' }],
    order: [[0, 'asc']]
  });
});
