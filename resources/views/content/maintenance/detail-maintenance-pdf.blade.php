<style>
/* Existing CSS for image containers */
.image-container {
    display: inline-block;
    width: 45%;
    margin: 10px;
    vertical-align: top;
    page-break-inside: avoid;
}

/* CSS for 'Gambar Sebelum Perbaikan' section */
.before-images {
    clear: both;
    margin-top: 20px;
    @if(count($maintenance->beforeImages) > 4)
        page-break-before: always;
    @endif
}

/* CSS for 'Gambar Setelah Perbaikan' section */
.after-images {
    clear: both;
    margin-top: 20px;
    @if(count($maintenance->afterImages) > 4 || count($maintenance->beforeImages) > 4)
        page-break-before: always;
    @endif
}

/* Add other existing styles here */

</style>

<div class="before-images">
    <h3>Gambar Sebelum Perbaikan</h3>
    @foreach($maintenance->beforeImages as $image)
        <div class="image-container">
            <img src="{{ storage_path('app/public/maintenance/before/' . $image->hashed_name) }}" alt="Before Maintenance" style="width: 100%; height: auto;">
            <p>{{ $image->original_name }}</p>
        </div>
    @endforeach
</div>

<div class="after-images">
    <h3>Gambar Setelah Perbaikan</h3>
    @foreach($maintenance->afterImages as $image)
        <div class="image-container">
            <img src="{{ storage_path('app/public/maintenance/after/' . $image->hashed_name) }}" alt="After Maintenance" style="width: 100%; height: auto;">
            <p>{{ $image->original_name }}</p>
        </div>
    @endforeach
</div> 