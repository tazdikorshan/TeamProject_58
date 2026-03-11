@extends('layouts.app')

@section('title', 'My Profile - HomeDome')

@section('content')
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-md-12">
            <h1>My Profile</h1>
            <p class="text-muted">Manage your personal details and saved addresses.</p>
        </div>
    </div>

    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Personal Details Section -->
        <div class="col-md-5 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Personal Details</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update-details') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('customer.change-password') }}" class="btn btn-outline-secondary btn-sm">Change Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Addresses Section -->
        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">My Addresses</h4>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        Add New Address
                    </button>
                </div>
                <div class="card-body p-0">
                    @if($addresses->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($addresses as $address)
                                <div class="list-group-item p-4">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $address->street }}</h5>
                                        <div>
                                            @if($address->is_shipping)
                                                <span class="badge bg-info">Shipping</span>
                                            @endif
                                            @if($address->is_billing)
                                                <span class="badge bg-secondary">Billing</span>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                    <p class="mb-1">{{ $address->city }}, {{ $address->postcode }}</p>
                                    
                                    <div class="mt-3">
                                        <form action="{{ route('profile.addresses.destroy', $address->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this address?');">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <p>You haven't saved any addresses yet.</p>
                            <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                Add Your First Address
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="street" class="form-label">Street Address</label>
                        <input type="text" class="form-control" id="street" name="street" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="mb-3">
                        <label for="postcode" class="form-label">Postcode</label>
                        <input type="text" class="form-control" id="postcode" name="postcode" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_shipping" name="is_shipping" value="1" checked>
                        <label class="form-check-label" for="is_shipping">Use as default shipping address</label>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_billing" name="is_billing" value="1">
                        <label class="form-check-label" for="is_billing">Use as default billing address</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
