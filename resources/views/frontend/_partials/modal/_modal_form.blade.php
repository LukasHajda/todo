<div class="modal fade bd-example-modal-lg {{ isset($edit) && $edit == 1 ? 'edit-modal' : '' }}" id="addItemModal" data-route="{{ route('index') }}" tabindex="-1" role="dialog" aria-labelledby="addItemModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">New item</h5>
                <button type="button" class="close {{ isset($edit) && $edit == 1 ? 'close-edit-modal' : '' }}" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form method="POST" action="{{  isset($edit) && $edit == 1 ? route('items.update', $item->id) : route('items.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Heading:</label>
                                        <input type="text" class="form-control" name="heading" id="recipient-name" value="{{ isset($item) ? $item->heading : '' }}">
                                        @include('frontend._partials._errors', ['error_name' => 'heading'])
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Description:</label>
                                        <textarea class="form-control" id="message-text" name="description">{{ isset($item) ? $item->description : '' }}</textarea>
                                        @include('frontend._partials._errors', ['error_name' => 'description'])
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Categories</label>
                                        <select class="form-control" name="category_id">
                                            <option value="">None</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ isset($item) && $item->category_id == $category->id ? 'selected' : '' }}>{{ ucfirst($category->name) }}</option>
                                            @endforeach
                                        </select>
                                        @include('frontend._partials._errors', ['error_name' => 'category_id'])
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>User</label>
{{--                                        <h1>{{ $item->users()->count() }}</h1>--}}
                                        <select class="form-control select2-selection--multiple" name="user_id[]" multiple="multiple">
                                            @foreach($users as $user)
                                                @if(isset($item))
                                                    @foreach($item->users as $item_user)
                                                        <option value="{{ $user->id }}" {{ $user->id == $item_user->id ? 'selected' : '' }}>{{ ucfirst($user->username) }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="{{ $user->id }}">{{ ucfirst($user->username) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @include('frontend._partials._errors', ['error_name' => 'user_id'])
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">{{ isset($edit) && $edit == 1 ? 'Edit' : 'Add' }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
