<div class="table-scrollbar">
    <table class="table table-dark">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Heading</th>
            <th scope="col">Category</th>
            <th scope="col">Done</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $item->heading }}</td>
                <td class="{{ \App\Models\ItemCategory::findOrFail($item->category_id)->color() }}">{{ ucfirst($item->name) }}</td>
                <td>{{ ($item->done) ? 'Yes' : 'No' }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Actions
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form action="{{ route('items.done', [$item->id, 'done']) }}" method="GET">
                                <button class="dropdown-item" type="submit" id="make_finished">Done</button>
                            </form>
                            <form action="{{ route('items.done', [$item->id, 'undone']) }}" method="GET">
                                <button class="dropdown-item" type="submit">Undone</button>
                            </form>
                            @if (!auth()->user()->admin)
                                <form action="{{ route('items.show', $item->id) }}" method="GET">
                                    <button class="dropdown-item" type="submit" id="show_description">Show</button>
                                </form>
                            @endif
                            @if (auth()->user()->admin)
                                <form action="{{ route('items.done', [$item->id, 'pre_deleted']) }}" method="GET">
                                    <button class="dropdown-item" type="submit" id="make_finished">Delete</button>
                                </form>
                                <form action="{{ route('items.edit', $item->id) }}" method="GET">
                                    <button class="dropdown-item" type="submit">Edit</button>
                                </form>
                            @endif
                            @if (!auth()->user()->admin)
                                <form action="{{ route('items.done', [$item->id, 'pre_deleted']) }}" method="GET">
                                    <button class="dropdown-item" type="submit" id="make_finished">Delete</button>
                                </form>
                            @endif

                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>