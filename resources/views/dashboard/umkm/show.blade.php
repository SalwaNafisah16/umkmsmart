<h3>{{ $umkm->nama_umkm }}</h3>

<p>
    📍 {{ $umkm->alamat }}
</p>

<iframe
    src="https://www.google.com/maps?q={{ $umkm->latitude }},{{ $umkm->longitude }}&output=embed"
    width="100%"
    height="300"
    style="border:0;"
    loading="lazy">
</iframe>
