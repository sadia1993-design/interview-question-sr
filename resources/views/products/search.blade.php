@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
        <a href="{{ url()->previous() }}">Back</a>
    </div>


    <div class="card">


        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>

                    @forelse ($titleProduct as $titleP)
                      <tr>
                        <td style="width: 5%">{{ $loop->iteration }}</td>

                        <td style="width: 5%">{{ $titleP->title }} <br> Created at : {{ \Carbon\Carbon::parse($titleP->created_at)->diffForhumans() }}</td>
                        <td style="width: 30%">{{ $titleP->description }}</td>
                        <td style="width: 40%">
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                <dt class="col-sm-3 col-xl-3 pb-0" >

                                       <span>1 / 6</span><br>

                                </dt>
                                <dd class="col-sm-9 col-xl-9">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 pb-0">

                                                <span> Price: {{ number_format(10,2) }}</span><br>


                                        </dt>
                                        <dd class="col-sm-8 pb-0">

                                              InStock: {{ number_format(5,2) }}<br>


                                        </dd>
                                    </dl>
                                </dd>
                            </dl>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td style="width: 20%">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', 1) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @empty

                    @endforelse


                    </tbody>

                </table>
            </div>

        </div>


    </div>

@endsection
