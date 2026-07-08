<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Membership No</label>
        <input type="text" name="membership_no" class="form-control" value="{{ old('membership_no', $member->membership_no ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $member->first_name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $member->last_name ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $member->email ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', $member->phone ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $member->address ?? '') }}">
    </div>
    @if(isset($member))
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
            <option value="suspended" {{ old('status', $member->status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
            <option value="expired" {{ old('status', $member->status) == 'expired' ? 'selected' : '' }}>Expired</option>
        </select>
    </div>
    @endif
</div>
