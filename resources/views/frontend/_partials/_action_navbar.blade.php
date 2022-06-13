<div class="col">
    <div class="row">
        <div class="col-sm-6">
            @if(auth()->user()->admin)
                <a type="button" class="btn btn-warning" href="{{ route('items.deleted_items') }}">Deleted items</a>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addItemModal">Add item</button>
            @endif
        </div>
    </div>
</div>
