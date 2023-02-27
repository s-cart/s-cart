<form action="" method="GET" id="filter_sort">
    @php
    $queries = request()->except(['filter_sort','page']);
    @endphp
    @foreach ($queries as $key => $query)
    <input type="hidden" name="{{ $key }}" value="{{ $query }}">
    @endforeach
    
    <select class="form-control" name="filter_sort">
        <option value="">{{ sc_language_render('filter_sort.sort') }}</option>
        <option value="price_asc" {{ ($filterSort =='price_asc')?'selected':'' }}>
            {{ sc_language_render('filter_sort.price_asc') }}</option>
        <option value="price_desc" {{ ($filterSort =='price_desc')?'selected':'' }}>
            {{ sc_language_render('filter_sort.price_desc') }}</option>
        <option value="sort_asc" {{ ($filterSort =='sort_asc')?'selected':'' }}>
            {{ sc_language_render('filter_sort.sort_asc') }}</option>
        <option value="sort_desc" {{ ($filterSort =='sort_desc')?'selected':'' }}>
            {{ sc_language_render('filter_sort.sort_desc') }}</option>
        <option value="id_asc" {{ ($filterSort =='id_asc')?'selected':'' }}>
          {{ sc_language_render('filter_sort.id_asc') }}
        </option>
        <option value="id_desc" {{ ($filterSort =='id_desc')?'selected':'' }}>
            {{ sc_language_render('filter_sort.id_desc') }}</option>
    </select>
  </form>

@push('scripts')
<script type="text/javascript">
  $('[name="filter_sort"]').change(function(event) {
      $('#filter_sort').submit();
  });
</script>
@endpush