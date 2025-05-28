@props(['route', 'params' => []])

<div class="d-flex gap-2">
    <a href="{{ route($route, array_merge(['type' => 'pdf'], $params)) }}" class="btn btn-danger" id="pdfBtn-{{ $route }}">
        <i class="bx bxs-file-pdf me-1"></i>
        Export PDF
    </a>
    <a href="{{ route($route, array_merge(['type' => 'excel'], $params)) }}" class="btn btn-success" id="excelBtn-{{ $route }}">
        <i class="bx bxs-file me-1"></i>
        Export Excel
    </a>
</div>

@push('scripts')
<script>
function showLoading(buttonId) {
    console.log(`Menampilkan loading untuk tombol: ${buttonId}`);
    const button = document.getElementById(buttonId);
    if (!button) {
        console.error(`Tombol dengan ID ${buttonId} tidak ditemukan!`);
        return;
    }
    const icon = button.querySelector('i');
    const text = button.querySelector('span');
    
    button.disabled = true;
    if (icon) icon.className = 'bx bx-loader-alt bx-spin me-1';
    if (text) text.textContent = 'Memproses...';
}

function resetButton(buttonId, iconClass, text) {
    console.log(`Resetting tombol: ${buttonId}`);
    const button = document.getElementById(buttonId);
    if (!button) {
        console.error(`Tombol dengan ID ${buttonId} tidak ditemukan saat reset!`);
        return;
    }
    const icon = button.querySelector('i');
    const textSpan = button.querySelector('span');
    
    button.disabled = false;
    if (icon) icon.className = iconClass;
    if (textSpan) textSpan.textContent = text;
}

function showError(message) {
    console.error(`Error: ${message}`);
    alert('Error: ' + message);
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded. Mencari tombol ekspor...');
    // Mengambil route dari atribut data pada tombol
    const pdfButton = document.querySelector('a[id^="pdfBtn-"]');
    const excelButton = document.querySelector('a[id^="excelBtn-"]');

    if (pdfButton) {
        const route = pdfButton.id.replace('pdfBtn-', '');
        console.log(`Tombol PDF ditemukan untuk route: ${route}`);
        pdfButton.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah navigasi default
            console.log(`Tombol PDF diklik untuk route: ${route}`);
            // Langsung mengunduh file, tidak perlu fetch AJAX lagi karena link sudah mengarah ke route download
            window.location.href = this.href;
        });
    }

    if (excelButton) {
        const route = excelButton.id.replace('excelBtn-', '');
        console.log(`Tombol Excel ditemukan untuk route: ${route}`);
        excelButton.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah navigasi default
            console.log(`Tombol Excel diklik untuk route: ${route}`);
            // Langsung mengunduh file, tidak perlu fetch AJAX lagi karena link sudah mengarah ke route download
            window.location.href = this.href;
        });
    }
});
</script>
@endpush