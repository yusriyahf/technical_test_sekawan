    @extends('layouts.main')

    @section('container')
    <div class="row">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body p-4">
                    <div class="mb-5 mb-sm-0">
                        <h5 class="card-title fw-semibold mb-3">Order Table</h5>
                      </div>
                    @can('IsAdmin')
                    <button id="bookingButton" class="btn btn-primary btn-lm mb-3" data-bs-toggle="modal" data-bs-target="#bookingModal">Add</button>
                    {{-- <a href="{{ route('orders.export') }}" class="btn btn-success mb-4">Export to Excel</a> --}}
                    <form id="filterForm" action="{{ route('order') }}" method="GET" class="mb-2">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="month" class="form-label">Select Month</label>
                                <select id="month" name="month" class="form-select">
                                    <option value="" selected>All Months</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="year" class="form-label">Select Year</label>
                                <select id="year" name="year" class="form-select">
                                    <option value="" selected>All Years</option>
                                    @for ($year = 2020; $year <= now()->year; $year++)
                                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="status" class="form-label">Select Status</label>
                                <select id="status" name="status" class="form-select">
                                    <option value="" selected>All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved_level_1" {{ request('status') == 'approved_level_1' ? 'selected' : '' }}>Approved Level 1</option>
                                    <option value="approved_level_2" {{ request('status') == 'approved_level_2' ? 'selected' : '' }}>Approved Level 2</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished</option>
                                </select>
                            </div>
                            <!-- Export Button -->
                            {{-- @can('IsAdmin') --}}
                            <div class="col-md-3">
                                <label for="status" class="form-label text-white">Export</label>
                                <a href="{{ route('orders.export', ['month' => request('month'), 'year' => request('year'), 'status' => request('status')]) }}" class="btn btn-success w-100 mb-4">Export to Excel</a>
                            </div>
                            @endcan

                        </div>
                    </form>
                    
                    @if (session()->has('success'))
                        <div class="alert alert-success col-lg-8 mt-3" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Vehicle</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Driver</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Location</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Start Date</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">End Date</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Action</h6>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $d)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">{{ $d->vehicle->vehicle_name }} - {{ $d->vehicle->vehicle_number }}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $d->driver->name }} - {{ $d->driver->license_number }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $d->location->name }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $d->start_date }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="mb-0 fw-normal">{{ $d->end_date }}</p>
                                    </td>
                                
                                    <td class="border-bottom-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge 
                                                @if($d->status == 'pending')
                                                    bg-secondary
                                                @elseif($d->status == 'approved_level_1' || $d->status == 'approved_level_2')
                                                    bg-primary
                                                @elseif($d->status == 'rejected')
                                                    bg-danger
                                                @elseif($d->status == 'finished')
                                                    bg-success
                                                @else
                                                    bg-light
                                                @endif
                                                rounded-3 fw-semibold">{{ $d->status }}</span>
                                        </div>
                                    </td>
                                    
                                    
                                    @can('IsAdmin')
                                    <td class="border-bottom-0">
                                        <button id="bookingButton" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>

                                    
                                        <button id="bookingButton" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                                    </td>
                                    @endcan
                                    @can('IsApprover')
                                    <td class="border-bottom-0">
                                        
                                    @if ($d->status == 'pending' && $d->approver1_id == Auth::user()->id)
                                        <button id="bookingButton" class="btn btn-primary btn-lm" data-bs-toggle="modal" data-bs-target="#bookingModal" data-kamar_id="{{ $d->kamar_id }}" data-harga="{{ $d->harga }}">Approve</button>
                                    @elseif ($d->status == 'approved_level_1' && $d->approver2_id == Auth::user()->id)
                                        <button id="bookingButton" class="btn btn-primary btn-lm" data-bs-toggle="modal" data-bs-target="#bookingModal" data-kamar_id="{{ $d->kamar_id }}" data-harga="{{ $d->harga }}">Approve</button>
                                    @else
                                        <button id="bookingButton" class="btn btn-primary btn-lm" disabled>Approve</button>
                                    @endif


                                    @if ($d->status == 'pending' && $d->approver1_id == Auth::user()->id)
                                        <button id="bookingButton" class="btn btn-danger btn-lm" data-bs-toggle="modal" data-bs-target="#rejectModal" data-kamar_id="{{ $d->kamar_id }}" data-harga="{{ $d->harga }}">Reject</button>
                                    @elseif ($d->status == 'approved_level_1' && $d->approver2_id == Auth::user()->id)
                                        <button id="bookingButton" class="btn btn-danger btn-lm" data-bs-toggle="modal" data-bs-target="#rejectModal" data-kamar_id="{{ $d->kamar_id }}" data-harga="{{ $d->harga }}">Reject</button>
                                    @else
                                        <button id="bookingButton" class="btn btn-danger btn-lm" disabled>Reject</button>
                                    @endif
                                    </td>
                                    @endcan
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('IsAdmin')
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Add Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-top: 0; margin-top: -10px;">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <form id="bookingForm" action="/order/create" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <select class="form-control @error('location') is-invalid @enderror" id="location" name="location" required>
                                        <option value="" disabled selected>Select a location</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location') == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

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
                
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success" style="background-color:#6986fd">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- EDIT --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Edit Driver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding-top: 0; margin-top: -10px;">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <form id="bookingForm" action="/order/{{ $d->id }}" method="POST">
                                @csrf
                                @method('put')
                                
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <select class="form-control @error('vehicle') is-invalid @enderror" id="location" name="location" required>
                                        <option value="" disabled selected>Select a Location</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location', $d->location_id) == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }} 
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="vehicle" class="form-label">Vehicle</label>
                                    <select class="form-control @error('vehicle') is-invalid @enderror" id="vehicle" name="vehicle" required>
                                        <option value="" disabled selected>Select a Vehicle</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle', $d->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
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
                                            <option value="{{ $driver->id }}" {{ old('driver', $d->driver_id) == $driver->id ? 'selected' : '' }}>
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
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $d->start_date) }}" min="{{ \Carbon\Carbon::today()->toDateString() }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $d->end_date) }}" min="{{ \Carbon\Carbon::today()->toDateString() }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="approval1" class="form-label">Approver 1</label>
                                    <select class="form-control @error('approval1') is-invalid @enderror" id="approval1" name="approval1" required>
                                        <option value="" disabled selected>Select Approver 1</option>
                                        @foreach($approvals as $approval)
                                            <option value="{{ $approval->id }}" {{ old('approval1', $d->approver1_id) == $approval->id ? 'selected' : '' }}>
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
                                            <option value="{{ $approval->id }}" {{ old('approval2', $d->approver2_id) == $approval->id ? 'selected' : '' }}>
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
                                    <textarea class="form-control @error('reason') is-invalid @enderror" id="reason" name="reason" rows="3" required>{{ old('reason', $d->reason) }}</textarea>
                                    @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                
                            
    
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success" style="background-color:#6986fd">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- DELETE --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <!-- Posisi tengah dan ukuran kecil -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Deskripsi di modal -->
                    <p class="mb-4">
                        Are you sure you want to delete this data?
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <form id="bookingForm" action="/order/{{ $d->id }}" method="POST">
                                @csrf
                                @method('delete')
                            
                            
                                <!-- Button dikemas dalam div dengan class d-flex untuk memposisikan -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger" >Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan


    @can('IsApprover')
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <!-- Posisi tengah dan ukuran kecil -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Deskripsi di modal -->
                    <p class="mb-4">
                        Are you sure you want to approve this order?
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <form id="bookingForm" action="/approve/{{ $d->id }}" method="POST">
                                @csrf
                                @method('PUT')
                            
                                <input type="hidden" name="id" value="{{ $d->id }}">
                                <input type="hidden" name="vehicle" value="{{ $d->vehicle->id }}">
                                <!-- Button dikemas dalam div dengan class d-flex untuk memposisikan -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success" style="background-color:#6986fd">Approve</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <!-- Posisi tengah dan ukuran kecil -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Deskripsi di modal -->
                    <p class="mb-4">
                        Are you sure you want to rejected this order?
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <form id="bookingForm" action="/rejected/{{ $d->id }}" method="POST">
                                @csrf
                                @method('PUT')
                            
                            
                                <!-- Button dikemas dalam div dengan class d-flex untuk memposisikan -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-danger" >Rejected</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    @endsection

    @push('scripts')
    <script>
        document.querySelectorAll('#month, #year, #status').forEach(select => {
            select.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });
    </script>

    @endpush
