<form action="{{ $action['url'] }}" method="POST">
    @csrf
    @foreach ($action['data'] as $key => $value)
    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach

    <p>Bạn có muốn tiếp tục thao tác trước đó không?</p>
    <button type="submit">Tiếp tục</button>
    <a href="{{ $action['from'] }}">Hủy</a>
</form>