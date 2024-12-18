@extends('layouts.main')

@section('container')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="mb-5 mb-sm-0">
                    <h5 class="card-title fw-semibold mb-3">Vehicle Table</h5>
                  </div>
                {{-- <a href="/user/create" class="btn btn-primary mb-4">Add</a> --}}

                <button id="bookingButton" class="btn btn-primary btn-lm" data-bs-toggle="modal" data-bs-target="#bookingModal">Add</button>

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
                                    <h6 class="fw-semibold mb-0">Vehicle Number</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Type</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Fuel Consumption</h6>
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
                                    <h6 class="fw-semibold mb-0">{{ $d->vehicle_number }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{ $d->type }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{ $d->fuel_consumption }}</p>
                                </td>
                                <td class="border-bottom-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge rounded-3 fw-semibold 
                                            @if($d->status == 'available') bg-success 
                                            @elseif($d->status == 'in_use') bg-danger 
                                            @endif">
                                            {{ $d->status }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="border-bottom-0">
                                    <button id="bookingButton" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>

                                    
                                    <button id="bookingButton" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Add Vehicle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding-top: 0; margin-top: -10px;">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <form id="bookingForm" action="/vehicle/create" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="vehicle_name" class="form-label mt-3">Vehicle Name</label>
                                <input type="text" id="vehicle_name" class="form-control" name="vehicle_name" placeholder="Input Vehicle Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="vehicle_number" class="form-label mt-3">Vehicle Number</label>
                                <input type="text" id="vehicle_number" class="form-control" name="vehicle_number" placeholder="Input Vehicle Number" required>
                            </div>
                            <div class="mb-3">
                                <label for="fuel_consumption" class="form-label mt-3">Fuel Consumption</label>
                                <input type="number" id="fuel_consumption" class="form-control" name="fuel_consumption" placeholder="Input Fuel Consumption" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label mt-3">Vehicle Type</label>
                                <select id="type" class="form-control" name="type" required>
                                    <option value="personal">Personal</option>
                                    <option value="rental">Rental</option>
                                </select>
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
                        <form id="bookingForm" action="/vehicle/{{ $d->id }}" method="POST">
                            @csrf
                            @method('put')
                            
                            <div class="mb-3">
                                <label for="vehicle_name" class="form-label mt-3">Vehicle Name</label>
                                <input type="text" id="vehicle_name" class="form-control" name="vehicle_name" placeholder="Input Vehicle Name" required value="{{ $d->vehicle_name }}">
                            </div>
                            <div class="mb-3">
                                <label for="vehicle_number" class="form-label mt-3">Vehicle Number</label>
                                <input type="text" id="vehicle_number" class="form-control" name="vehicle_number" placeholder="Input Vehicle Number" required value="{{ $d->vehicle_number }}">
                            </div>
                            <div class="mb-3">
                                <label for="fuel_consumption" class="form-label mt-3">Fuel Consumption</label>
                                <input type="number" id="fuel_consumption" class="form-control" name="fuel_consumption" placeholder="Input Fuel Consumption" required value="{{ $d->fuel_consumption }}">
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label mt-3">Vehicle Type</label>
                                <select id="type" class="form-control" name="type" required>
                                    <option value="personal" {{ $d->type == 'personal' ? 'selected' : '' }}>Personal</option>
                                    <option value="rental" {{ $d->type == 'rental' ? 'selected' : '' }}>Rental</option>
                                </select>
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
                        <form id="bookingForm" action="/vehicle/{{ $d->id }}" method="POST">
                            @csrf
                            @method('delete')
                        
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
@endsection
