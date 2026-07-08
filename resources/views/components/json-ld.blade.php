@props(['data'])
<script type="application/ld+json" @nonce>{!! json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
