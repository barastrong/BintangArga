@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        .product-card {
            display: flex;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            position: relative;
        }
        .product-image {
            width: 215px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .product-details {
            flex: 1;
            padding: 20px;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
        }
        .quantity-btn {
            width: 32px;
            height: 32px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background-color: #fff;
            border: 1px solid #ddd;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.2s ease;
        }
        .quantity-btn:hover {
            background-color: #f8f8f8;
            border-color: #bbb;
        }
        .quantity-input {
            width: 60px;
            height: 32px;
            text-align: center;
            border: 1px solid #ddd;
            border-left: none;
            border-right: none;
            font-size: 14px;
            outline: none;
            -moz-appearance: textfield; /* Firefox */
        }
        .quantity-input:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 0 1px #fbbf24;
        }
        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .total-price {
            text-align: right;
            margin-top: 20px;
        }
        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 10;
        }
        .remove-btn:hover {
            background-color: #f8f8f8;
            color: #ff4444;
            border-color: #ff4444;
        }
    </style>
</head>
<body>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">Checkout</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold mb-4">Selected Items</h2>
                
                @foreach($selectedItems as $item)
                    <div class="product-card mb-4" id="item-{{ $item->id }}">
                        <div class="product-image">
                            <img src="{{ Storage::url($item->size->gambar_size) }}" 
                                alt="{{ $item->product->nama_barang }} - {{ $item->size->size }}"  
                                 alt="{{ $item->product->nama_barang }}" 
                                 class="object-contain">
                        </div>
                        <button type="button" 
                                class="remove-btn" 
                                onclick="removeItem({{ $item->id }}, '{{ $item->product->nama_barang }}')">
                            x
                        </button>
                        <div class="product-details">
                            <h3 class="text-lg font-medium">{{ $item->product->nama_barang }}</h3>
                            
                            <div class="text-sm text-gray-500 mt-1">UKURAN</div>
                            <div>{{ $item->size->size }}</div>
                            
                            <div class="text-sm text-gray-500 mt-3">Jumlah</div>
                            <div class="flex items-center mt-1">
                                <div class="quantity-controls">
                                    <button type="button" 
                                            class="quantity-btn" 
                                            onclick="updateQuantity({{ $item->id }}, 'decrease')">
                                        -
                                    </button>
                                    <input type="number" 
                                           id="quantity-{{ $item->id }}" 
                                           class="quantity-input"
                                           value="{{ $item->quantity }}"
                                           min="0"
                                           max="{{ $item->size->stock }}"
                                           onchange="updateQuantityManual({{ $item -> id }})"
                                           onkeyup="updateQuantityManual({{ $item -> id }})"
                                           onblur="validateQuantity({{ $item->id }})">
                                    <button type="button" 
                                            class="quantity-btn" 
                                            onclick="updateQuantity({{ $item->id }}, 'increase')">
                                        +
                                    </button>
                                </div>
                            </div>
                            
                            <div class="total-price">
                                <div class="text-sm text-gray-500">Total harga</div>
                                <p class="text-gray-800 font-medium" id="price-{{ $item->id }}" 
                                   data-unit-price="{{ $item->size->harga }}">
                                    Rp {{ number_format($item->size->harga * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>

                            <input type="hidden" id="stock-{{ $item->id }}" value="{{ $item->size->stock }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 sticky top-4">
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                
                <div class="mb-4 pb-4 border-b">
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mb-4 pb-4 border-b">
                    <div class="flex justify-between mb-2">
                        <span>Tax (10%)</span>
                        <span id="tax-amount">Rp {{ number_format($totalPrice *0.1 , 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Delivery Tax (3%)</span>
                        <span id="delivery-tax">Rp {{ number_format($totalPrice * 0.03, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between mb-2 font-semibold">
                        <span>Total</span>
                        <span id="total-price">Rp {{ number_format($totalPrice + ($totalPrice * 0.1) + ($totalPrice * 0.03), 0, ',', '.') }}</span>
                    </div>
                </div>
                    
                <form id="checkout-form" action="{{ route('cart.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="total_with_tax" id="input-total-with-tax" value="{{ $totalPrice + ($totalPrice * 0.1) }}">

                    <div id="cart-items-container">
                        @foreach($selectedItems as $item)
                            <input type="hidden" name="cart_items[]" value="{{ $item->id }}" id="input-item-{{ $item->id }}">
                            <input type="hidden" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" id="input-quantity-{{ $item->id }}">
                        @endforeach
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="border rounded p-3 cursor-pointer hover:border-yellow-500 payment-option" data-method="gopay">
                                <input type="radio" name="payment_method" value="gopay" id="payment_gopay" class="hidden">
                                <label for="payment_gopay" class="cursor-pointer flex flex-col items-center">
                                    <span class="text-sm font-medium">Gopay</span>
                                </label>
                            </div>
                            
                            <div class="border rounded p-3 cursor-pointer hover:border-yellow-500 payment-option" data-method="qris">
                                <input type="radio" name="payment_method" value="qris" id="payment_qris" class="hidden">
                                <label for="payment_qris" class="cursor-pointer flex flex-col items-center">
                                    <span class="text-sm font-medium">Qris</span>
                                </label>
                            </div>
                            
                            <div class="border rounded p-3 cursor-pointer hover:border-orange-850 payment-option" data-method="dana">
                                <input type="radio" name="payment_method" value="dana" id="payment_dana" class="hidden">
                                <label for="payment_dana" class="cursor-pointer flex flex-col items-center">
                                    <span class="text-sm font-medium">Dana</span>
                                </label>
                            </div>
                        </div>
                        <div id="payment-method-error" class="text-red-500 text-sm mt-1 hidden">Pilih untuk melakukan pembayaran</div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Alamat Pengiriman</label>
                        <textarea name="shipping_address" rows="3" 
                                  class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                                  required></textarea>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2">Nomor Telepone</label>
                        <input type="text" name="phone_number" 
                               class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                               required>
                    </div>
                    <div class="mb-6">
                        <label for="description" class="block text-gray-700 font-medium mb-2">Catatan Pembelian</label>
                        <textarea name="description" id="description" rows="2" 
                                  class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                  required></textarea>
                    </div>
                    
                    <button type="submit" 
                           class="w-full bg-yellow-500 text-white px-6 py-3 rounded-lg text-center hover:bg-yellow-600 transition">
                        Complete Order
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function showErrorPopup(message) {
        if (!document.getElementById('error-popup')) {
            const popup = document.createElement('div');
            popup.id = 'error-popup';
            popup.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded shadow-lg z-50 transform transition-all duration-300 translate-x-full';
            popup.style.maxWidth = '350px';
            document.body.appendChild(popup);
        }
        
        const popup = document.getElementById('error-popup');
        popup.innerHTML = message;
        
        setTimeout(() => {
            popup.classList.remove('translate-x-full');
        }, 10);
        
        setTimeout(() => {
            popup.classList.add('translate-x-full');
        }, 3000);
    }

    function updateQuantity(itemId, action) {
        const quantityElement = document.getElementById(`quantity-${itemId}`);
        const priceElement = document.getElementById(`price-${itemId}`);
        const quantityInput = document.getElementById(`input-quantity-${itemId}`);
        const stockElement = document.getElementById(`stock-${itemId}`);
        
        let currentQuantity = parseInt(quantityElement.value);
        const unitPrice = parseFloat(priceElement.getAttribute('data-unit-price'));
        const stockAvailable = parseInt(stockElement ? stockElement.value : 9999);
        
        if (action === 'increase') {
            if (currentQuantity + 1 > stockAvailable) {
                showErrorPopup(`Stock tidak mencukupi. Tersedia: ${stockAvailable}`);
                return;
            }
            currentQuantity++;
        } else if (action === 'decrease' && currentQuantity > 1) {
            currentQuantity--;
        }
        
        quantityElement.value = currentQuantity;
        
        quantityInput.value = currentQuantity;
        
        const newPrice = unitPrice * currentQuantity;
        priceElement.innerText = `Rp ${formatNumber(newPrice)}`;
        
        updateSubtotal();
        
        // Send AJAX request to update quantity in database
        updateQuantityInDatabase(itemId, currentQuantity);
    }

    function updateQuantityManual(itemId) {
        const quantityElement = document.getElementById(`quantity-${itemId}`);
        const priceElement = document.getElementById(`price-${itemId}`);
        const quantityInput = document.getElementById(`input-quantity-${itemId}`);
        const stockElement = document.getElementById(`stock-${itemId}`);
        
        let currentQuantity = parseInt(quantityElement.value);
        const unitPrice = parseFloat(priceElement.getAttribute('data-unit-price'));
        const stockAvailable = parseInt(stockElement ? stockElement.value : 9999);
        
        // Validate quantity
        if (isNaN(currentQuantity) || currentQuantity < 1) {
            currentQuantity = 1;
            quantityElement.value = currentQuantity;
        } else if (currentQuantity > stockAvailable) {
            showErrorPopup(`Stock tidak mencukupi. Tersedia: ${stockAvailable}`);
            currentQuantity = stockAvailable;
            quantityElement.value = currentQuantity;
        }
        
        // Update hidden input for form submission
        quantityInput.value = currentQuantity;
        
        // Update price display
        const newPrice = unitPrice * currentQuantity;
        priceElement.innerText = `Rp ${formatNumber(newPrice)}`;
        
        // Update overall subtotal, tax, and total
        updateSubtotal();
    }

    function validateQuantity(itemId) {
        const quantityElement = document.getElementById(`quantity-${itemId}`);
        const stockElement = document.getElementById(`stock-${itemId}`);
        
        let currentQuantity = parseInt(quantityElement.value);
        const stockAvailable = parseInt(stockElement ? stockElement.value : 9999);
        
        // Final validation on blur
        if (isNaN(currentQuantity) || currentQuantity < 1) {
            currentQuantity = 1;
            quantityElement.value = currentQuantity;
        } else if (currentQuantity > stockAvailable) {
            currentQuantity = stockAvailable;
            quantityElement.value = currentQuantity;
        }
        
        // Update in database
        updateQuantityInDatabase(itemId, currentQuantity);
    }

    function updateQuantityInDatabase(itemId, quantity) {
        // Send AJAX request to update quantity in database
        fetch(`/cart/update/${itemId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                quantity: quantity
            })
        }).then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.error || 'Error updating quantity');
                });
            }
            return response.json();
        }).then(data => {
            if (data.success) {
                console.log('Quantity updated successfully');
            }
        }).catch(error => {
            console.error('Error updating quantity:', error);
            showErrorPopup(error.message);
        });
    }

    // Modify form submission validation to handle stock validation
    document.getElementById('checkout-form').addEventListener('submit', function(event) {
        // Check if payment method is selected
        const paymentSelected = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentSelected) {
            event.preventDefault();
            document.getElementById('payment-method-error').classList.remove('hidden');
        }
        
        // Check stock availability for all items before submission
        let stockError = false;
        const cartItems = document.querySelectorAll('[id^="item-"]');
        
        cartItems.forEach(item => {
            const itemId = item.id.split('-')[1];
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            const stockElement = document.getElementById(`stock-${itemId}`);
            
            if (stockElement) {
                const quantity = parseInt(quantityElement.value);
                const stock = parseInt(stockElement.value);
                
                if (quantity > stock) {
                    event.preventDefault();
                    stockError = true;
                    const productName = document.querySelector(`#item-${itemId} h3`).innerText;
                    const sizeName = document.querySelector(`#item-${itemId} div:nth-child(4)`).innerText;
                    showErrorPopup(`Stock untuk ${productName} - ${sizeName} tidak mencukupi. Tersedia: ${stock}`);
                }
            }
        });
    });
    
    function removeItem(itemId, itemName) {
        // Remove item from DOM
        const itemElement = document.getElementById(`item-${itemId}`);
        const inputElement = document.getElementById(`input-item-${itemId}`);
        const quantityInput = document.getElementById(`input-quantity-${itemId}`);
        
        if (itemElement) itemElement.remove();
        if (inputElement) inputElement.remove();
        if (quantityInput) quantityInput.remove();
        
        // Update subtotal
        updateSubtotal();
        
        // Check if checkout is empty
        const cartItems = document.querySelectorAll('[id^="item-"]');
        if (cartItems.length === 0) {
            // Redirect to cart page if no items left in checkout
            window.location.href = "{{ route('cart.index') }}";
        }
    }
    
    // Function to update subtotal
    function updateSubtotal() {
        let subtotal = 0;
        const priceElements = document.querySelectorAll('[id^="price-"]');
        
        priceElements.forEach(element => {
            const itemId = element.id.split('-')[1];
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            const unitPrice = parseFloat(element.getAttribute('data-unit-price'));
            const quantity = parseInt(quantityElement.value);
            
            subtotal += unitPrice * quantity;
        });
        
        subtotal = Math.round(subtotal * 100) / 100;
        document.getElementById('subtotal').innerText = `Rp ${formatNumber(subtotal)}`;

        const tax = Math.round(subtotal * 0.1 * 100) / 100;
        const deliveryTax = Math.round(subtotal * 0.03 * 100) / 100;
        
        // Update tax display
        document.getElementById('tax-amount').innerText = `Rp ${formatNumber(tax)}`;
        document.getElementById('delivery-tax').innerText = `Rp ${formatNumber(deliveryTax)}`;
        
        // Calculate total with tax - round to avoid floating point issues
        const totalWithTax = Math.round((subtotal + tax + deliveryTax) * 100) / 100;
        
        // Update total price display
        document.getElementById('total-price').innerText = `Rp ${formatNumber(totalWithTax)}`;
        
        // Also update hidden input for form submission if needed
        if (document.getElementById('input-total-with-tax')) {
            document.getElementById('input-total-with-tax').value = totalWithTax;
        }
    }
    
    // Function to format number as currency
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Add event listeners for payment method selection
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            document.querySelectorAll('.payment-option').forEach(el => {
                el.classList.remove('border-yellow-500', 'border-orange-850');
                el.classList.add('border');
            });
            
            // Add active class to selected option
            const method = this.getAttribute('data-method');
            if (method === 'nyicil') {
                this.classList.add('border-orange-850');
            } else {
                this.classList.add('border-yellow-500');
            }
            
            // Select the radio button
            document.getElementById(`payment_${method}`).checked = true;
            
            // Hide error message if shown
            document.getElementById('payment-method-error').classList.add('hidden');
        });
    });

    @if(session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            showErrorPopup("{{ session('error') }}");
        });
    @endif
</script>
</body>
</html>
@endsection
