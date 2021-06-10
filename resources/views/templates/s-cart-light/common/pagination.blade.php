<div class="pagination-wrap">
    <nav aria-label="Page navigation">
      <ul class="pagination">
        {{ $items->appends(request()->except(['page','_token']))->links() }}
      </ul>
    </nav>
</div>