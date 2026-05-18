<!DOCTYPE html>
<html class="light" lang="en"><head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>My Bids - FarmDirect</title>
<script src="/js/tailwind.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&amp;family=Plus+Jakarta+Sans:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#2E7D32",
                        "secondary": "#8D6E63",
                        "background": "#FDFDFB",
                        "surface": "#FFFFFF",
                        "surface-container": "#F4F5F2",
                        "on-surface": "#1A1C19",
                        "on-surface-variant": "#43493E",
                        "outline": "#73796E",
                        "outline-variant": "#C3C8BC",
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "3xl": "2rem",
                        "full": "9999px"
                    },
                    fontFamily: {
                        "headline": ["Manrope", "sans-serif"],
                        "body": ["Manrope", "sans-serif"],
                        "label": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    boxShadow: {
                        "premium": "0 20px 40px -12px rgba(0, 0, 0, 0.05)",
                        "soft": "0 8px 30px rgba(0, 0, 0, 0.03)"
                    }
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .fill-icon {
            font-variation-settings: 'FILL' 1;
        }
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body class="bg-background font-body text-on-surface overflow-x-hidden">

<header class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl border-b border-outline-variant/30 h-20">
<div class="max-w-[1600px] mx-auto h-full flex justify-between items-center px-8">
<div class="flex items-center gap-12">
<a href="/" class="flex items-center gap-2">
    <span class="material-symbols-outlined text-primary text-3xl" style="font-variation-settings: 'FILL' 1;">eco</span>
    <span class="text-2xl font-black tracking-tighter text-on-surface">Farm<span class="text-primary">Direct</span></span>
</a>
</div>
<div class="flex items-center gap-6">
    <div class="flex items-center gap-3 pr-2 border-r border-outline-variant/30">
        <a href="{{ route('buyer.notifications') }}" class="p-2 hover:bg-surface-container rounded-full transition-all text-on-surface-variant relative">
            <span class="material-symbols-outlined">notifications</span>
            <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
        </a>
        @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
        <a href="{{ route('checkout') }}" class="p-2 hover:bg-surface-container rounded-full transition-all text-on-surface-variant relative">
            <span class="material-symbols-outlined">shopping_cart</span>
            @if($cartCount > 0)
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-primary text-white text-[10px] font-black rounded-full flex items-center justify-center border-2 border-white">{{ $cartCount }}</span>
            @endif
        </a>
    </div>
<div class="flex items-center gap-3 pl-2">
<div class="text-right hidden sm:block">
<p class="text-xs font-bold text-primary uppercase tracking-widest leading-none mb-1">Role: Buyer</p>
<p class="text-sm font-semibold text-on-surface leading-none">{{ $user->name }}</p>
</div>
<div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-lg cursor-pointer relative group">
    {{ substr($user->name, 0, 1) }}
    <div class="absolute right-0 top-12 w-48 bg-white rounded-3xl shadow-premium border border-outline-variant/30 p-5 hidden group-hover:block z-50">
        <p class="text-[10px] font-bold text-on-surface-variant/60 uppercase tracking-widest">ID: #{{ substr($user->id, -6) }}</p>
        <p class="text-sm font-black text-on-surface mt-1">{{ $user->name }}</p>
        <p class="text-xs text-on-surface-variant font-medium">Verified Buyer</p>
        <div class="border-t border-outline-variant/30 my-3"></div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 text-xs font-bold text-red-500 hover:text-red-600 transition-colors w-full">
                <span class="material-symbols-outlined text-sm">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
</div>
</div>
</div>
</header>

<main class="pt-32 pb-24 px-8 max-w-[1600px] mx-auto flex flex-col lg:flex-row gap-12">
<aside class="hidden lg:flex flex-col w-72 shrink-0 space-y-8">
<div class="p-6 bg-white rounded-3xl border border-outline-variant/30 shadow-soft">
<div class="flex items-center gap-4 mb-8">
<div class="relative">
<div class="w-14 h-14 rounded-2xl bg-stone-100 flex items-center justify-center text-primary font-bold text-xl border-2 border-primary/10">
    {{ substr($user->name, 0, 1) }}
</div>
<div class="absolute -bottom-1 -right-1 bg-primary text-white p-1 rounded-lg border-2 border-white">
<span class="material-symbols-outlined text-[10px] fill-icon">verified</span>
</div>
</div>
<div>
<h4 class="font-bold text-on-surface text-lg">{{ $user->name }}</h4>
<p class="text-xs text-on-surface-variant font-medium">Enterprise Buyer</p>
</div>
</div>
<nav class="space-y-2">
<a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary hover:bg-primary/5 rounded-2xl transition-all group" href="{{ route('buyer.dashboard') }}">
<span class="material-symbols-outlined group-hover:fill-icon">dashboard</span>
<span class="font-bold text-sm">Dashboard</span>
</a>
<a class="flex items-center gap-4 px-4 py-3 bg-primary text-white rounded-2xl font-bold shadow-lg shadow-primary/20" href="{{ route('buyer.bids') }}">
<span class="material-symbols-outlined fill-icon">gavel</span>
<span class="text-sm">My Bids</span>
</a>
<a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary hover:bg-primary/5 rounded-2xl transition-all group" href="{{ route('buyer.orders') }}">
<span class="material-symbols-outlined group-hover:fill-icon">history</span>
<span class="font-bold text-sm">Orders & History</span>
</a>
<a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary hover:bg-primary/5 rounded-2xl transition-all group" href="{{ route('buyer.logistics') }}">
<span class="material-symbols-outlined group-hover:fill-icon">local_shipping</span>
<span class="font-bold text-sm">Logistics</span>
</a>
<a class="flex items-center gap-4 px-4 py-3 text-on-surface-variant hover:text-primary hover:bg-primary/5 rounded-2xl transition-all group" href="{{ route('buyer.account') }}">
<span class="material-symbols-outlined group-hover:fill-icon">account_circle</span>
<span class="font-bold text-sm">Account Center</span>
</a>
</nav>
</div>
</aside>

<section class="flex-1">
<header class="mb-10">
    <h1 class="text-5xl font-black text-on-surface tracking-tighter mb-2">My Bids</h1>
    <p class="text-on-surface-variant font-medium">Track your active negotiations and historical bids on agricultural produce.</p>
</header>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($bids as $bid)
        <div class="bg-white p-8 rounded-3xl border border-outline-variant/30 shadow-soft relative overflow-hidden group">
            @php
                $statusColor = match($bid->status) {
                    'pending' => 'amber',
                    'accepted' => 'green',
                    'rejected' => 'red',
                    'negotiating' => 'blue',
                    default => 'stone'
                };
            @endphp
            <div class="absolute top-0 right-0 p-6">
                <span class="px-4 py-1.5 bg-{{ $statusColor }}-100 text-{{ $statusColor }}-700 text-[10px] font-black rounded-lg uppercase tracking-widest border border-{{ $statusColor }}-200">
                    {{ $bid->status }}
                </span>
            </div>

            <div class="flex items-start gap-5 mb-8">
                <div class="w-16 h-16 bg-surface-container rounded-2xl flex items-center justify-center border border-outline-variant/20 shrink-0">
                    <span class="material-symbols-outlined text-primary text-3xl">eco</span>
                </div>
                <div>
                    <h3 class="font-black text-on-surface text-xl group-hover:text-primary transition-colors">{{ $bid->crop->name ?? 'Unknown Crop' }}</h3>
                    <p class="text-sm text-on-surface-variant font-medium">{{ $bid->quantity }} {{ $bid->crop->unit ?? 'kg' }} requested</p>
                    <p class="text-xs text-stone-400 mt-1 font-bold">{{ $bid->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 p-4 bg-surface-container rounded-2xl mb-6">
                <div>
                    <p class="text-[9px] font-black text-on-surface-variant/60 uppercase tracking-widest mb-1">Your Bid Price</p>
                    <p class="text-lg font-black text-primary">₹{{ number_format($bid->price, 2) }} <span class="text-xs text-on-surface-variant font-medium">/{{ $bid->crop->unit ?? 'kg' }}</span></p>
                </div>
                <div>
                    <p class="text-[9px] font-black text-on-surface-variant/60 uppercase tracking-widest mb-1">Total Value</p>
                    <p class="text-lg font-black text-on-surface">₹{{ number_format($bid->price * $bid->quantity, 2) }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-stone-100 flex items-center justify-center text-[10px] font-bold text-primary">
                        {{ substr($bid->crop->farmer->name ?? 'F', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-on-surface-variant/60 uppercase tracking-widest">Farmer</p>
                        <p class="text-xs font-bold text-on-surface">{{ $bid->crop->farmer->name ?? 'Unknown' }}</p>
                    </div>
                </div>
                @if($bid->status === 'accepted')
                    <button onclick="openPaymentModal('{{ $bid->id }}', '{{ $bid->crop->name ?? 'Crop Listing' }}', '{{ $bid->quantity }}', '{{ $bid->price }}', '{{ $bid->crop->farmer->name ?? 'Farmer' }}')" class="px-4 py-2 bg-primary text-white font-black text-[10px] uppercase tracking-widest rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 flex items-center gap-2 transition-all">
                        Pay & Confirm <span class="material-symbols-outlined text-sm">payments</span>
                    </button>
                @elseif($bid->status === 'paid')
                    <span class="text-green-600 font-black text-[10px] uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">check_circle</span> Paid & Confirmed
                    </span>
                @elseif($bid->status === 'pending')
                    <span class="text-stone-400 font-black text-[10px] uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">hourglass_empty</span> Waiting
                    </span>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full bg-white p-14 rounded-3xl border border-outline-variant/30 shadow-soft text-center">
            <span class="material-symbols-outlined text-6xl text-outline-variant mb-4 block">gavel</span>
            <h3 class="text-xl font-bold text-on-surface mb-2">No Bids Found</h3>
            <p class="text-on-surface-variant">You haven't placed any bids on crops yet.</p>
            <a href="{{ route('buyer.discover') }}" class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-primary text-white font-black text-xs rounded-2xl uppercase tracking-widest shadow-lg shadow-primary/20">
                Start Bidding <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
    @endforelse
</div>

<div class="mt-12">
    {{ $bids->links() }}
</div>
</section>
</main>
@include('partials.buyer_footer')
@include('partials.live_notifications')

<!-- Premium Payment & Review Modal -->
<div id="payment-modal" class="fixed inset-0 bg-stone-900/60 backdrop-blur-md z-[9999] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="bg-white w-[550px] max-w-[90%] rounded-[2.5rem] p-8 shadow-[0_30px_70px_rgba(0,0,0,0.15)] border border-stone-100 transform scale-95 transition-transform duration-300 relative overflow-hidden">
        <!-- Close Button -->
        <button onclick="closePaymentModal()" class="absolute top-6 right-6 w-10 h-10 rounded-full hover:bg-stone-100 flex items-center justify-center text-stone-400 hover:text-stone-700 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>

        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-2xl">shopping_bag</span>
            </div>
            <div>
                <h3 class="text-xl font-black text-stone-900 tracking-tight">Checkout & Review</h3>
                <p class="text-xs text-stone-500 font-medium">Complete payment and rate the farmer to confirm order.</p>
            </div>
        </div>

        <form id="payment-form" onsubmit="submitPayment(event)">
            @csrf
            <input type="hidden" id="modal-bid-id" name="bid_id">

            <!-- Summary Card -->
            <div class="bg-stone-50 rounded-3xl p-5 mb-6 border border-stone-100 flex justify-between items-center">
                <div>
                    <h4 id="modal-crop-name" class="text-sm font-black text-stone-800">Crop Name</h4>
                    <p class="text-xs text-stone-500 font-medium mt-0.5"><span id="modal-crop-qty">0</span> units @ ₹<span id="modal-crop-price">0</span>/unit</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-stone-400 uppercase tracking-widest leading-none mb-1">Total Payable</p>
                    <p class="text-lg font-black text-primary">₹<span id="modal-total-payable">0</span></p>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mb-6">
                <label class="text-xs font-black text-stone-800 uppercase tracking-widest block mb-3">Select Payment Method</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="border-2 border-stone-100 hover:border-primary/30 rounded-2xl p-4 flex flex-col items-center gap-2 cursor-pointer transition-all relative" onclick="selectPaymentMethod('upi')">
                        <input type="radio" name="payment_method" value="UPI" class="absolute top-3 right-3 accent-primary" checked>
                        <span class="material-symbols-outlined text-2xl text-stone-600">qr_code_2</span>
                        <span class="text-xs font-bold text-stone-700">UPI / QR</span>
                    </label>
                    <label class="border-2 border-stone-100 hover:border-primary/30 rounded-2xl p-4 flex flex-col items-center gap-2 cursor-pointer transition-all relative" onclick="selectPaymentMethod('card')">
                        <input type="radio" name="payment_method" value="Card" class="absolute top-3 right-3 accent-primary">
                        <span class="material-symbols-outlined text-2xl text-stone-600">credit_card</span>
                        <span class="text-xs font-bold text-stone-700">Debit / Card</span>
                    </label>
                    <label class="border-2 border-stone-100 hover:border-primary/30 rounded-2xl p-4 flex flex-col items-center gap-2 cursor-pointer transition-all relative" onclick="selectPaymentMethod('netbanking')">
                        <input type="radio" name="payment_method" value="Netbanking" class="absolute top-3 right-3 accent-primary">
                        <span class="material-symbols-outlined text-2xl text-stone-600">account_balance</span>
                        <span class="text-xs font-bold text-stone-700">Net Banking</span>
                    </label>
                </div>
            </div>

            <!-- Dynamic Payment Fields -->
            <div id="payment-fields-upi" class="bg-stone-50 rounded-3xl p-5 mb-6 border border-stone-100">
                <label class="text-xs font-black text-stone-700 uppercase tracking-widest block mb-2">UPI ID / Phone Number</label>
                <input type="text" class="w-full bg-white border border-stone-200 rounded-xl px-4 py-3 text-sm font-semibold text-stone-800 focus:outline-none focus:border-primary" placeholder="name@upi">
            </div>
            
            <div id="payment-fields-card" class="bg-stone-50 rounded-3xl p-5 mb-6 border border-stone-100 hidden">
                <label class="text-xs font-black text-stone-700 uppercase tracking-widest block mb-2">Card Number</label>
                <input type="text" class="w-full bg-white border border-stone-200 rounded-xl px-4 py-3 text-sm font-semibold text-stone-800 focus:outline-none focus:border-primary mb-3" placeholder="XXXX XXXX XXXX XXXX">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-[10px] font-black text-stone-500 uppercase tracking-widest block mb-1">Expiry</label>
                        <input type="text" class="w-full bg-white border border-stone-200 rounded-xl px-3 py-2 text-sm font-semibold text-stone-800 focus:outline-none" placeholder="MM/YY">
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-stone-500 uppercase tracking-widest block mb-1">CVV</label>
                        <input type="password" class="w-full bg-white border border-stone-200 rounded-xl px-3 py-2 text-sm font-semibold text-stone-800 focus:outline-none" placeholder="***">
                    </div>
                </div>
            </div>

            <!-- Review / Rating Section -->
            <div class="mb-6">
                <label class="text-xs font-black text-stone-800 uppercase tracking-widest block mb-2">Rate Farmer <span id="modal-farmer-name" class="text-primary font-black">Farmer</span></label>
                <div class="flex items-center gap-2 mb-3">
                    <input type="hidden" id="modal-rating" name="rating" value="5">
                    @for($i = 1; $i <= 5; $i++)
                        <span onclick="setRating({{ $i }})" onmouseover="hoverRating({{ $i }})" onmouseout="resetRating()" class="star-rating material-symbols-outlined text-3xl text-amber-400 cursor-pointer transition-all hover:scale-110 fill-icon" data-value="{{ $i }}">star</span>
                    @endfor
                    <span id="rating-label" class="text-xs font-bold text-amber-500 ml-2">Excellent (5/5)</span>
                </div>
                <label class="text-xs font-black text-stone-800 uppercase tracking-widest block mb-2">Leave a Review (Optional)</label>
                <textarea name="comment" rows="2" class="w-full border border-stone-200 rounded-2xl p-4 text-sm font-medium text-stone-800 focus:outline-none focus:border-primary" placeholder="How was your bidding and communication experience with the farmer?"></textarea>
            </div>

            <!-- Submit -->
            <button type="submit" id="btn-pay-submit" class="w-full bg-primary text-white font-black py-4 rounded-2xl uppercase tracking-widest hover:bg-primary/95 transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                <span>Confirm Payment</span>
                <span class="material-symbols-outlined text-lg">verified_user</span>
            </button>
        </form>
    </div>
</div>

<script>
    function openPaymentModal(bidId, cropName, qty, price, farmerName) {
        document.getElementById('modal-bid-id').value = bidId;
        document.getElementById('modal-crop-name').innerText = cropName;
        document.getElementById('modal-crop-qty').innerText = qty;
        document.getElementById('modal-crop-price').innerText = Number(price).toFixed(2);
        document.getElementById('modal-farmer-name').innerText = farmerName;
        document.getElementById('modal-total-payable').innerText = (Number(qty) * Number(price)).toFixed(2);
        
        const modal = document.getElementById('payment-modal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.querySelector('div').classList.remove('scale-95');
        }, 50);
    }

    function closePaymentModal() {
        const modal = document.getElementById('payment-modal');
        modal.classList.add('opacity-0');
        modal.querySelector('div').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function selectPaymentMethod(type) {
        document.getElementById('payment-fields-upi').classList.add('hidden');
        document.getElementById('payment-fields-card').classList.add('hidden');
        
        if (type === 'upi') {
            document.getElementById('payment-fields-upi').classList.remove('hidden');
        } else if (type === 'card') {
            document.getElementById('payment-fields-card').classList.remove('hidden');
        }
    }

    let currentRating = 5;
    const ratingTexts = {
        1: 'Poor (1/5)',
        2: 'Fair (2/5)',
        3: 'Good (3/5)',
        4: 'Very Good (4/5)',
        5: 'Excellent (5/5)'
    };

    function setRating(val) {
        currentRating = val;
        document.getElementById('modal-rating').value = val;
        updateStars(val);
    }

    function hoverRating(val) {
        updateStars(val);
    }

    function resetRating() {
        updateStars(currentRating);
    }

    function updateStars(val) {
        const stars = document.querySelectorAll('.star-rating');
        stars.forEach(star => {
            const starVal = Number(star.getAttribute('data-value'));
            if (starVal <= val) {
                star.classList.add('text-amber-400', 'fill-icon');
                star.classList.remove('text-stone-300');
            } else {
                star.classList.remove('text-amber-400', 'fill-icon');
                star.classList.add('text-stone-300');
            }
        });
        document.getElementById('rating-label').innerText = ratingTexts[val] || '';
    }

    function submitPayment(e) {
        e.preventDefault();
        const bidId = document.getElementById('modal-bid-id').value;
        const submitBtn = document.getElementById('btn-pay-submit');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin text-lg">sync</span> <span>Processing Payment...</span>';

        const formData = new FormData(document.getElementById('payment-form'));

        fetch(`/dashboard/buyer/bids/${bidId}/pay`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                submitBtn.innerHTML = '<span class="material-symbols-outlined text-lg">check_circle</span> <span>Paid successfully!</span>';
                submitBtn.classList.remove('bg-primary');
                submitBtn.classList.add('bg-green-600');
                
                // Show floating toast
                if (window.showToast) {
                    window.showToast({
                        title: 'Payment Successful! 🎉',
                        message: 'Your order was successfully paid and initialized.',
                        type: 'success'
                    });
                }
                
                setTimeout(() => {
                    window.location.href = '{{ route("buyer.logistics") }}';
                }, 2000);
            } else {
                alert(data.message || 'Error occurred during payment. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<span>Confirm Payment</span> <span class="material-symbols-outlined text-lg">verified_user</span>';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error occurred. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Confirm Payment</span> <span class="material-symbols-outlined text-lg">verified_user</span>';
        });
    }
</script>

</body>
</html>
