@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Family Member</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('family-members.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="relationship" class="form-label">Relationship</label>
                            <input type="text" class="form-control" id="relationship" name="relationship" value="{{ old('relationship') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="age" class="form-label">Age</label>
                            <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="parent_id" class="form-label">Parent (optional)</label>
                            <input type="number" class="form-control" id="parent_id" name="parent_id" value="{{ old('parent_id') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Family Member</button>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary ms-2">Back to Dashboard</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 