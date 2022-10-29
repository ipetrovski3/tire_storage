<label for="brand">Бренд</label>
<select class="form-control" name="pattern" id="pattern">
    <option value="">Избери модел....</option>
    @foreach($patterns as $pattern)
        <option value="{{ $pattern->id }}">{{ $pattern->name }}</option>
    @endforeach
</select>
