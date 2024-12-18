@extends('layouts.main')

@section('container')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="mb-5 mb-sm-0">
                    <h5 class="card-title fw-semibold mb-3">Location Table</h5>
                  </div>
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
                                    <h6 class="fw-semibold mb-0">Name</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Address</h6>
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
                                    <h6 class="fw-semibold mb-0">{{ $d->name }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{ $d->address }}</p>
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


{{-- CREATE --}}
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Add Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding-top: 0; margin-top: -10px;">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <form id="bookingForm" action="/location/create" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="name" class="form-label mt-3">Location Name</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Input Location Name" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label mt-3">Address</label>
                                <input type="text" id="address" class="form-control" name="address" placeholder="Input Address" required>
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
                <h5 class="modal-title" id="bookingModalLabel">Edit Location</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding-top: 0; margin-top: -10px;">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <form id="bookingForm" action="/location/{{ $d->id }}" method="POST">
                            @csrf
                            @method('put')
                            
                            <div class="mb-3">
                                <label for="name" class="form-label mt-3">Location Name</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Input Location Name" required value="{{ $d->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label mt-3">Address</label>
                                <input type="text" id="address" class="form-control" name="address" placeholder="Input Address" required value="{{ $d->address }}">
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
                        <form id="bookingForm" action="/location/{{ $d->id }}" method="POST">
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
@endsection
