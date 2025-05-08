@extends('layouts.app')

@section('title', 'Admin Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminprofile.css') }}">
@endpush

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle" style="font-size: 100px;"></i>
                    <h5 class="mt-3">{{ $user->full_name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Account Information</h3>
            <ul class="list-group">
                <li class="list-group-item"><strong>Username:</strong> {{ $user->username }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}</li>
            </ul>

            <h3 class="mt-4">Order History</h3>
            <table class="table">
                <thead class="orders">
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Delivery Status</th>
                        <th>Address</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody class="orders">
                    @foreach($user->orders as $order)
                    <tr>
                        <td>#{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $order->created_at->format('F d, Y') }}</td>
                        <td>{{ ucfirst($order->delivery_status) }}</td>
                        <td>{{ $order->delivery_address }}</td>
                        <td>
                            ${{ number_format(
                                $order->products->sum(function ($product) {
                                    return $product->pivot->price * $product->pivot->quantity;
                                }), 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div id="productUploadSection" class="mt-4 p-3">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 id="formTitle">Add New Product</h3>
                    <button type="button" id="toggleModeBtn" class="btn btn-secondary">Switch to Edit</button>
                </div>
                
                <form id="productUploadForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div id="productIdField" style="display: none;" class="mb-3">
                        <label for="productIdInput" class="form-label">Product ID</label>
                        <input type="number" class="form-control" id="productIdInput" name="product_id" placeholder="Enter product ID to edit">
                    </div>
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="name" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="productDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="productDescription" name="description" rows="3"></textarea>
                    </div>
            
                    <div class="mb-3">
                        <label for="productPrice" class="form-label">Price ($)</label>
                        <input type="number" step="0.01" class="form-control" id="productPrice" name="price" required>
                    </div>
            
                    <div class="mb-3">
                        <label for="productImages" class="form-label">Upload Images</label>
                        <input type="file" class="form-control file-insert" id="productImages" name="images[]" multiple accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="productReleaseYear" class="form-label">Release Year</label>
                        <input type="number" class="form-control" id="productReleaseYear" name="release_year">
                    </div>

                    <div class="mb-3">
                        <h5>Platforms</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="platforms[]" value="PC" id="platformPC">
                            <label class="form-check-label" for="platformPC">PC</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="platforms[]" value="Playstation" id="platformPlaystation">
                            <label class="form-check-label" for="platformPlaystation">PlayStation</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="platforms[]" value="Xbox" id="platformXbox">
                            <label class="form-check-label" for="platformXbox">Xbox</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h5>Genres</h5>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="Action" id="genreAction">
                            <label class="form-check-label" for="genreAction">Action</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="Adventure" id="genreAdventure">
                            <label class="form-check-label" for="genreAdventure">Adventure</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="Sports" id="genreSports">
                            <label class="form-check-label" for="genreSports">Sports</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="RPG" id="genreRPG">
                            <label class="form-check-label" for="genreRPG">RPG</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="Racing" id="genreRacing">
                            <label class="form-check-label" for="genreRacing">Racing</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="Horror" id="genreHorror">
                            <label class="form-check-label" for="genreHorror">Horror</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="Puzzle" id="genrePuzzle">
                            <label class="form-check-label" for="genrePuzzle">Puzzle</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="Strategy" id="genreStrategy">
                            <label class="form-check-label" for="genreStrategy">Strategy</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="genres[]" value="Fighting" id="genreFighting">
                            <label class="form-check-label" for="genreFighting">Fighting</label>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn" class="btn">Add Product</button>
                </form>
            </div>

            <div id="productRemoveSection" class="mt-4 p-3">
                <h3>Remove Product</h3>
                <form id="productRemoveForm" action="{{ route('products.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="mb-3">
                        <label for="productId" class="form-label">Product ID</label>
                        <input type="text" class="form-control" id="productId" name="product_id" required>
                    </div>
                    <button type="submit" class="btn">Remove Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleModeBtn');
        const formTitle = document.getElementById('formTitle');
        const productForm = document.getElementById('productUploadForm');
        const productIdField = document.getElementById('productIdField');
        const submitBtn = document.getElementById('submitBtn');
        
        let isEditMode = false;
        
        toggleBtn.addEventListener('click', function() {
            isEditMode = !isEditMode;
            
            if (isEditMode) {
                formTitle.textContent = 'Edit Product';
                toggleBtn.textContent = 'Switch to Add';
                productIdField.style.display = 'block';
                submitBtn.textContent = 'Update Product';
                productForm.action = "{{ route('products.update') }}";
                
                //remove required 
                document.querySelectorAll('input[required], textarea[required]').forEach(function(el) {
                    el.removeAttribute('required');
                });
            } else {
                formTitle.textContent = 'Add New Product';
                toggleBtn.textContent = 'Switch to Edit';
                productIdField.style.display = 'none';
                submitBtn.textContent = 'Add Product';
                productForm.action = "{{ route('products.store') }}";
                
                productForm.reset();
                
                document.getElementById('productName').setAttribute('required', '');
                document.getElementById('productDescription').setAttribute('required', '');
                document.getElementById('productPrice').setAttribute('required', '');
            }
        });
    });
</script>
@endpush