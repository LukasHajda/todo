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
                <td class="{{ $item->category->color() }}">{{ ucfirst($item->category->name) }}</td>
                <td>{{ ($item->done) ? 'Yes' : 'No' }}</td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dropdown button
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @if (auth()->user()->admin)
                                <form action="{{ route('items.delete', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit" id="make_finished">Hard delete</button>
                                </form>
                                <form action="{{ route('items.restore', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Restore</button>
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
