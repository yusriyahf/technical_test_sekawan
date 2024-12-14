@extends('layouts.main')

@section('container')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Create Vehicle Reservation</h5>
                <form action="/order/create" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="vehicle" class="form-label">Vehicle</label>
                        <select class="form-control @error('vehicle') is-invalid @enderror" id="vehicle" name="vehicle" required>
                            <option value="" disabled selected>Select a Vehicle</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ old('vehicle') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->vehicle_name }} - {{ $vehicle->vehicle_number }} (Vehicle Number)
                                </option>
                            @endforeach
                        </select>
                        @error('vehicle')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    
                    <div class="mb-3">
                        <label for="driver" class="form-label">Driver</label>
                        <select class="form-control @error('driver') is-invalid @enderror" id="driver" name="driver" required>
                            <option value="" disabled selected>Select a Driver</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" {{ old('driver') == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->name }} - {{ $driver->license_number }} (License Number)
                                </option>
                            @endforeach
                        </select>
                        @error('driver')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date') }}" min="{{ \Carbon\Carbon::today()->toDateString() }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" min="{{ \Carbon\Carbon::today()->toDateString() }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="approval1" class="form-label">Approver 1</label>
                        <select class="form-control @error('approval1') is-invalid @enderror" id="approval1" name="approval1" required>
                            <option value="" disabled selected>Select Approver 1</option>
                            @foreach($approvals as $approval)
                                <option value="{{ $approval->id }}" {{ old('approval1') == $approval->id ? 'selected' : '' }}>
                                    {{ $approval->username }} - {{ $approval->position }} (Position)
                                </option>
                            @endforeach
                        </select>
                        @error('approval1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="approval2" class="form-label">Approver 2</label>
                        <select class="form-control @error('approval2') is-invalid @enderror" id="approval2" name="approval2" required>
                            <option value="" disabled selected>Select Approver 2</option>
                            @foreach($approvals as $approval)
                                <option value="{{ $approval->id }}" {{ old('approval2') == $approval->id ? 'selected' : '' }}>
                                    {{ $approval->username }} - {{ $approval->position }} (Position)
                                </option>
                            @endforeach
                        </select>
                        @error('approval2')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    

                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason</label>
                        <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3" required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    
                    <div class="mb-3 text-end">
                        <a href="" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('approval1').addEventListener('change', function() {
        var selectedApprover1 = this.value;
        
        var approval2Options = document.getElementById('approval2').options;
        
        // Reset styles and enable all options in approval2
        for (var i = 0; i < approval2Options.length; i++) {
            approval2Options[i].classList.remove('disabled-option');
            approval2Options[i].disabled = false; // Enable all options
        }
        
        // Disable the selected approver in approval1 from approval2
        for (var i = 0; i < approval2Options.length; i++) {
            if (approval2Options[i].value == selectedApprover1) {
                approval2Options[i].disabled = true;
                approval2Options[i].classList.add('disabled-option');
            }
        }
    });
</script>
@endpush