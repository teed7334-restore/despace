@if (isset($redirectMessage))
<script>
    alert('{{ $message }}');
    location.href = '{{ $url }}';
</script>
@endif