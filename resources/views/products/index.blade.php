@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="" class="form-control">

                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

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

                    @forelse ($products as $product)
                      <tr>
                        <td style="width: 5%">{{ $loop->iteration }}</td>

                        <td style="width: 5%">{{ $product->title}} <br> Created at : {{ \Carbon\Carbon::parse($product->created_at)->diffForhumans() }}</td>
                        <td style="width: 30%">{{ $product->description}}</td>
                        <td style="width: 40%">
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">

                                <dt class="col-sm-3 col-xl-3 pb-0" >
                                   @foreach ($product->ProductVariantPrices as $productVariantprices)
                                       <span>{{ $productVariantprices->product_variant_one }} / {{$productVariantprices->product_variant_two}}</span><br>
                                   @endforeach
                                </dt>
                                <dd class="col-sm-9 col-xl-9">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 pb-0">
                                            @foreach ($product->ProductVariantPrices as $productVariantprices)
                                                <span> Price: {{ number_format($productVariantprices->price,2) }}</span><br>
                                            @endforeach

                                        </dt>
                                        <dd class="col-sm-8 pb-0">
                                            @foreach ($product->ProductVariantPrices as $productVariantprices)
                                              InStock: {{ number_format($productVariantprices->stock,2) }}<br>
                                            @endforeach

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

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} out of {{ $products->total() }}</p>
                </div>
                <div class="col-md-2">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
