@extends('layouts.app')

@section('title', 'My Profile - HomeDome')

@section('content')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

<div class="profile-container">
    <div class="profile-header">
        <h1>My Profile</h1>
        <p>Manage your personal details and saved addresses.</p>
    </div>

    @if (\Session::has('success'))
        <div class="alert-success">
            {!! \Session::get('success') !!}
        </div>
    @endif
    
    @if ($errors->any())
        <div class="alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="profile-content">
        <!-- Personal Details Section -->
        <div class="profile-card details-card">
            <div class="card-header">
                <h2>Personal Details</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update-details') }}" method="POST" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    
                    <div class="form-actions row-between mt-4">
                        <button type="submit" class="btn-primary">Save Changes</button>
                        <a href="{{ route('customer.change-password') }}" class="link-inline">Change Password</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Addresses Section -->
        <div class="profile-card addresses-card">
            <div class="card-header flex-header">
                <h2>My Addresses</h2>
                <button type="button" class="btn-secondary" onclick="document.getElementById('addAddressModal').style.display='flex'">
                    + Add New
                </button>
            </div>
            <div class="card-body p-0">
                @if($addresses->count() > 0)
                    <div class="address-list">
                        @foreach($addresses as $address)
                            <div class="address-item">
                                <div class="address-header">
                                    <h3>{{ $address->street }}</h3>
                                    <div class="badges">
                                        @if($address->is_shipping)
                                            <span class="badge shipping-badge">Shipping</span>
                                        @endif
                                        @if($address->is_billing)
                                            <span class="badge billing-badge">Billing</span>
                                        @endif
                                    </div>
                                </div>
                                <p class="address-details">{{ $address->city }}, {{ $address->postcode }}</p>
                                
                                <div class="address-actions">
                                    <form action="{{ route('profile.addresses.destroy', $address->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-text-danger" onclick="return confirm('Delete this address?');">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fa-regular fa-address-book empty-icon"></i>
                        <p>You haven't saved any addresses yet.</p>
                        <button type="button" class="btn-primary" onclick="document.getElementById('addAddressModal').style.display='flex'">
                            Add Your First Address
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div id="addAddressModal" class="custom-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Add New Address</h2>
            <button class="close-btn" onclick="document.getElementById('addAddressModal').style.display='none'">&times;</button>
        </div>
        <form action="{{ route('profile.addresses.store') }}" method="POST" class="auth-form">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label for="street">Street Address</label>
                    <input type="text" id="street" name="street" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                </div>
                <div class="form-group">
                    <label for="postcode">Postcode</label>
                    <input type="text" id="postcode" name="postcode" required>
                </div>
                <div class="checkbox-group mt-3">
                    <label class="checkbox">
                        <input type="checkbox" name="is_shipping" value="1" checked> Use as default shipping
                    </label>
                </div>
                <div class="checkbox-group">
                    <label class="checkbox">
                        <input type="checkbox" name="is_billing" value="1"> Use as default billing
                    </label>
                </div>
            </div>
            <div class="modal-footer row-between mt-4">
                <button type="button" class="btn-text" onclick="document.getElementById('addAddressModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn-primary inline-btn">Save Address</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        let modal = document.getElementById('addAddressModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
