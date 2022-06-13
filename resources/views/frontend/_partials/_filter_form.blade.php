<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Categories</label>
                    <select class="form-control" name="category_id">
                        <option value="">None</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="">None</option>
                        <option value="finished">Finished</option>
                        <option value="unfinished">Unfinished</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Shared</label>
                    <select class="form-control" name="shared">
                        <option value="">None</option>
                        @if(!auth()->user()->admin)
                            <option value="{{ auth()->user()->id }}">My</option>
                            <option value="-1">Shared</option>
                        @endif
                        @if(auth()->user()->admin)
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->username }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </div>
</div>
<div class="dropdown-divider"></div>
