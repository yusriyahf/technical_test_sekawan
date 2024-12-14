@extends('layouts.main')

@section('container')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4 text-primary">Order List</h5>
                @can('IsAdmin')
                <a href="/order/create" class="btn btn-primary mb-4">Add Order</a>

                
                @endcan
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
                                    <h6 class="fw-semibold mb-0">Start Date</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">End Date</h6>
                                </th>
                                {{-- <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Location</h6>
                                </th> --}}
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
                                    <a href="user/{{ $d->id }}/edit" class="btn btn-warning btn-lm">Edit</a>
                                    <form action="user/{{$d->id }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-lm" onclick="return confirm('Yakin ingin menghapus data?')">Hapus</button>
                                    </form>
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
