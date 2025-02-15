@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h3><i class="bi bi-tags"></i> Categories</h3>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-lg"></i> Add Category
            </button>
        </div>
    </div>

    <!-- Category Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-warning editCategoryBtn"
                                    data-id="{{ $category->id }}"
                                    data-name="{{ $category->name }}"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editCategoryModal">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>

                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include Modals -->
@include('categories.partials.add_modal')
@include('categories.partials.edit_modal')

@endsection

@section('scripts')
<script>
    document.querySelectorAll('.editCategoryBtn').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('editCategoryForm').action = '/categories/' + this.dataset.id;
            document.getElementById('editName').value = this.dataset.name;
        });
    });
</script>
@endsection
