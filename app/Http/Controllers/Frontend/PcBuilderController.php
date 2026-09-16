<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\BuilderProduct;
use App\Models\BuilderType;
use App\Models\PcBuilder;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\PcBuilderSuccessMail;
use App\Models\ShippingCharge;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PcBuilderController extends Controller
{
    /**
     * PC Builder listing page.
     */
    public function index()
    {
        $builderTypes = BuilderType::query()->where('status', true)->orderBy('name', 'asc')->get();
        $meta_title = 'PC Builder | Build Your Custom PC Online';
        $meta_keyword = 'PC builder, custom PC builder, build a PC, gaming PC builder, custom computer builder, PC components';
        $meta_description = 'Build your custom PC online with our PC Builder. Choose compatible components including processors, graphics cards, motherboards, RAM, storage and other PC parts.';
        return view( 'frontend.pc-builder.index',compact( 'builderTypes','meta_title','meta_keyword','meta_description')
        );
    }
    public function show($slug)
    {
        $builderType = BuilderType::query()
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $builderProducts = BuilderProduct::query()
            ->with([
                'product.productBrand',
                'product.category',
                'product.subCategory',
                'product.images',
            ])
            ->where('builder_type_id', $builderType->id)
            ->where('status', true)
            ->whereHas('product', function ($query) {
                $query->where('status', true);
            })
            ->orderBy('sort_order', 'asc')
            ->latest('id')
            ->get();

        $products = $builderProducts
            ->filter(function ($builderProduct) {
                return $builderProduct->product !== null;
            })
            ->map(function ($builderProduct) {
                return $builderProduct->product;
            })
            ->unique('id')
            ->values();

        $groupedProducts = $products
            ->groupBy(function ($product) {
                return optional($product->productBrand)->id ?? 0;
            })
            ->map(function ($brandProducts) {
                return $brandProducts
                    ->groupBy(function ($product) {
                        return optional($product->category)->id ?? 0;
                    })
                    ->map(function ($categoryProducts) {
                        return $categoryProducts
                            ->groupBy(function ($product) {
                                return optional($product->subCategory)->id ?? 0;
                            });
                    });
            });

        $brands = $products
            ->map(function ($product) {
                return $product->productBrand;
            })
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();

        $meta_title = $builderType->meta_title
            ?: $builderType->name.' | PC Builder';

        $meta_keyword = $builderType->meta_keywords
            ?: $builderType->name.', PC builder, custom PC, computer hardware, PC components';

        $meta_description = $builderType->meta_description
            ?: 'Build your '.$builderType->name.' with compatible computer components including processors, graphics cards, motherboards, RAM and storage.';

        return view(
            'frontend.pc-builder.show',
            compact(
                'builderType',
                'builderProducts',
                'products',
                'groupedProducts',
                'brands',
                'meta_title',
                'meta_keyword',
                'meta_description'
            )
        );
    }

    /**
     * PC Builder checkout page.
     */
    public function checkout()
    {
        $addresses = Address::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->latest('id')
            ->get();

        $defaultAddress = $addresses->firstWhere('is_default', true);

        if (! $defaultAddress) {
            $defaultAddress = $addresses->first();
        }

        $meta_title = 'PC Builder Checkout';
        $meta_keyword = 'PC builder checkout, custom PC checkout, computer hardware checkout';
        $meta_description = 'Complete your custom PC build order securely.';

        return view('frontend.pc-builder.checkout', compact(
            'addresses',
            'defaultAddress',
            'meta_title',
            'meta_keyword',
            'meta_description'
        ));

    }

    public function getProducts(Request $request)
    {
        $request->validate(['products' => 'required|array|min:1']);

        $selectedProducts = $request->input('products');

        $productIds = collect($selectedProducts)
            ->map(fn ($productId) => (int) $productId)
            ->filter()
            ->unique()
            ->values();

        if ($productIds->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Please select at least one product.',
            ], 422);
        }

        $products = Product::with(['productBrand', 'category', 'subCategory', 'images'])
            ->whereIn('id', $productIds)
            ->where('status', true)
            ->get()
            ->keyBy('id');

        $result = [];

        foreach ($selectedProducts as $builderType => $productId) {
            $productId = (int) $productId;

            if (! isset($products[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'One or more selected products are no longer available.',
                ], 422);
            }

            $product = $products[$productId];

            $builderProductExists = BuilderProduct::query()
                ->where('builder_type_id', function ($query) use ($builderType) {
                    $query->select('id')
                        ->from('builder_types')
                        ->where('name', $builderType)
                        ->where('status', true)
                        ->limit(1);
                })
                ->where('product_id', $product->id)
                ->where('status', true)
                ->exists();

            if (! $builderProductExists) {
                $builderProductExists = BuilderProduct::query()
                    ->where('product_id', $product->id)
                    ->where('status', true)
                    ->exists();
            }

            if (! $builderProductExists) {
                return response()->json([
                    'success' => false,
                    'message' => $product->name.' is not available for PC Builder.',
                ], 422);
            }

            $price = ! empty($product->sale_price) && (float) $product->sale_price < (float) $product->price
                ? (float) $product->sale_price
                : (float) $product->price;

            $gstRate = 0;
            $gstAmount = 0;

            if ($product->gst_type === 'yes' && ! empty($product->gst_id)) {
                $gst = DB::table('gsts')
                    ->where('id', $product->gst_id)
                    ->where('status', true)
                    ->first();

                if ($gst) {
                    $gstRate = (float) $gst->gst_amount;
                    $gstAmount = ($price * $gstRate) / 100;
                }
            }

            $image = null;

            if ($product->images && $product->images->count()) {
                $primaryImage = $product->images->where('is_primary', true)->first();
                $primaryImage = $primaryImage ?: $product->images->first();

                if ($primaryImage && $primaryImage->image) {
                    $image = asset('storage/'.$primaryImage->image);
                }
            }

            if (! $image) {
                $image = asset('assets/frontend/assets/images/product/large-size/1.jpg');
            }

            $result[] = [
                'builder_type' => $builderType,
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'sku' => $product->sku,
                'price' => $price,
                'original_price' => (float) $product->price,
                'gst_rate' => $gstRate,
                'gst_amount' => round($gstAmount, 2),
                'stock_quantity' => (int) $product->stock_quantity,
                'image' => $image,
                'brand' => optional($product->productBrand)->name,
                'category' => optional($product->category)->name,
                'sub_category' => optional($product->subCategory)->name,
            ];
        }

        return response()->json([
            'success' => true,
            'products' => $result,
        ]);
    }

    /**
     * Create PC Builder order and Razorpay order.
     */
    public function placeOrder(Request $request)
    {
        try {
            if ($request->has('products') && is_string($request->products)) {
                $decodedProducts = json_decode($request->products, true);
                if (! is_array($decodedProducts)) {
                    return response()->json(['success' => false, 'message' => 'Invalid products data.'], 422);
                }
                $request->merge(['products' => $decodedProducts]);
            }

            if ($request->has('quantities') && is_string($request->quantities)) {
                $decodedQuantities = json_decode($request->quantities, true);
                if (! is_array($decodedQuantities)) {
                    return response()->json(['success' => false, 'message' => 'Invalid quantities data.'], 422);
                }
                $request->merge(['quantities' => $decodedQuantities]);
            }

            $validated = $request->validate([
                'products' => 'required|array|min:1',
                'quantities' => 'required|array|min:1',
                'quantities.*' => 'required|integer|min:1',
                'customer_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'mobile_number' => 'required|string|max:20',
                'address' => 'required|string|max:1000',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'pincode' => 'required|string|max:10',
                'country' => 'required|string|max:100',
                'payment_method' => 'required|in:cod,razorpay',
                'order_notes' => 'nullable|string|max:2000',
            ]);

            $selectedProducts = $validated['products'];
            $quantities = $validated['quantities'];
            $paymentMethod = strtolower(trim($validated['payment_method']));

            $productIds = collect($selectedProducts)
                ->map(fn ($productId) => (int) $productId)
                ->filter(fn ($productId) => $productId > 0)
                ->unique()
                ->values();

            if ($productIds->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Please select at least one product.'], 422);
            }

            $products = Product::with('images')
                ->whereIn('id', $productIds)
                ->where('status', true)
                ->get()
                ->keyBy('id');

            if ($products->count() !== $productIds->count()) {
                return response()->json(['success' => false, 'message' => 'One or more selected products are no longer available.'], 422);
            }

            foreach ($selectedProducts as $builderType => $productId) {
                $productId = (int) $productId;
                $product = $products->get($productId);

                if (! $product) {
                    return response()->json(['success' => false, 'message' => 'Selected product not found.'], 422);
                }

                $quantity = (int) ($quantities[$productId] ?? $quantities[(string) $productId] ?? $quantities[$builderType] ?? 0);

                if ($quantity < 1) {
                    return response()->json(['success' => false, 'message' => 'Invalid quantity for '.$product->name.'.'], 422);
                }

                $stockQuantity = (int) ($product->stock_quantity ?? 0);

                if ($stockQuantity <= 0) {
                    return response()->json(['success' => false, 'message' => $product->name.' is out of stock.'], 422);
                }

                if ($quantity > $stockQuantity) {
                    return response()->json(['success' => false, 'message' => 'Only '.$stockQuantity.' quantity available for '.$product->name.'.'], 422);
                }

                $builderProductExists = BuilderProduct::query()
                    ->where('product_id', $product->id)
                    ->where('status', true)
                    ->exists();

                if (! $builderProductExists) {
                    return response()->json(['success' => false, 'message' => $product->name.' is not available for PC Builder.'], 422);
                }
            }

            $subtotal = 0;
            $gstAmount = 0;
            $cartItems = [];

            foreach ($selectedProducts as $builderType => $productId) {
                $productId = (int) $productId;
                $product = $products->get($productId);
                $quantity = (int) ($quantities[$productId] ?? $quantities[(string) $productId] ?? $quantities[$builderType] ?? 1);

                $price = (float) $product->price;

                if (! empty($product->sale_price) && (float) $product->sale_price < (float) $product->price) {
                    $price = (float) $product->sale_price;
                }

                $itemGst = 0;
                $gstRate = 0;

                if ($product->gst_type === 'yes' && ! empty($product->gst_id)) {
                    $gst = DB::table('gsts')
                        ->where('id', $product->gst_id)
                        ->where('status', true)
                        ->first();

                    if ($gst) {
                        $gstRate = (float) $gst->gst_amount;
                        $itemGst = ($price * $gstRate) / 100;
                    }
                }

                $itemSubtotal = $price * $quantity;
                $itemGstTotal = $itemGst * $quantity;

                $subtotal += $itemSubtotal;
                $gstAmount += $itemGstTotal;

                $image = null;

                if (! empty($product->image)) {
                    $image = $product->image;
                } elseif (! empty($product->product_image)) {
                    $image = $product->product_image;
                } elseif ($product->images && $product->images->count()) {
                    $primaryImage = $product->images->firstWhere('is_primary', true);
                    $image = $primaryImage ? $primaryImage->image : $product->images->first()->image;
                }

                $cartItems[] = [
                    'builder_type' => $builderType,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'price' => round($price, 2),
                    'quantity' => $quantity,
                    'gst_rate' => round($gstRate, 2),
                    'gst_amount' => round($itemGstTotal, 2),
                    'image' => $image,
                ];
            }

            $subtotal = round($subtotal, 2);
            $gstAmount = round($gstAmount, 2);
            $discountAmount = 0;
            $shippingAmount = (float) $request->input('shipping_charge', 0);
            $shippingAmount = round($shippingAmount, 2);
            if ($shippingAmount <= 0) {
                $verifiedShipping = ShippingCharge::where('pincode', $validated['pincode'])->first()
                    ?? ShippingCharge::whereNull('pincode')
                        ->whereNull('city')->whereNull('state')->first();

                if ($verifiedShipping) {
                    $shippingAmount = (float) $verifiedShipping->charges;
                }
            }

            $totalAmount = round($subtotal + $gstAmount + $shippingAmount - $discountAmount, 2);
            if ($totalAmount <= 0) {
                return response()->json(['success' => false, 'message' => 'Invalid order total.'], 422);
            }

            $builderNumber = 'PCB-'.date('YmdHis').'-'.strtoupper(substr(uniqid(), -6));

            if ($paymentMethod === 'cod') {
                $pcBuilder = DB::transaction(function () use ($validated, $selectedProducts, $quantities, $cartItems, $subtotal, $gstAmount, $shippingAmount, $discountAmount, $totalAmount, $builderNumber) {
                    foreach ($selectedProducts as $builderType => $productId) {
                        $productId = (int) $productId;
                        $quantity = (int) ($quantities[$productId] ?? $quantities[(string) $productId] ?? $quantities[$builderType] ?? 1);

                        $product = Product::where('id', $productId)->lockForUpdate()->first();

                        if (! $product) {
                            throw new \Exception('Selected product is no longer available.');
                        }

                        if ((int) $product->stock_quantity < $quantity) {
                            throw new \Exception('Insufficient stock for '.$product->name.'.');
                        }

                        $product->decrement('stock_quantity', $quantity);
                    }

                    return PcBuilder::create([
                        'user_id' => Auth::id(),
                        'builder_number' => $builderNumber,
                        'products' => $cartItems,
                        'subtotal' => $subtotal,
                        'gst_amount' => $gstAmount,
                        'shipping_amount' => $shippingAmount,
                        'discount_amount' => $discountAmount,
                        'total_amount' => $totalAmount,
                        'payment_method' => 'cod',
                        'payment_status' => 'pending',
                        'status' => 'pending',
                        'razorpay_order_id' => null,
                        'razorpay_payment_id' => null,
                        'razorpay_signature' => null,
                        'customer_name' => $validated['customer_name'],
                        'email' => $validated['email'],
                        'mobile_number' => $validated['mobile_number'],
                        'address' => $validated['address'],
                        'city' => $validated['city'],
                        'state' => $validated['state'],
                        'pincode' => $validated['pincode'],
                        'country' => $validated['country'],
                        'order_notes' => $validated['order_notes'] ?? null,
                    ]);
                });

                return response()->json([
                    'success' => true,
                    'payment_required' => false,
                    'payment_method' => 'cod',
                    'message' => 'PC Builder order placed successfully.',
                    'pc_builder_id' => $pcBuilder->id,
                    'builder_number' => $pcBuilder->builder_number,
                    'redirect_url' => route('pc-builder.index'),
                ]);
            }

            $amountInPaise = (int) round($totalAmount * 100);

            if ($amountInPaise < 100) {
                return response()->json(['success' => false, 'message' => 'Minimum Razorpay payment amount is ₹1.'], 422);
            }

            $razorpayKey = config('services.razorpay.key');
            $razorpaySecret = config('services.razorpay.secret');

            if (empty($razorpayKey) || empty($razorpaySecret)) {
                return response()->json(['success' => false, 'message' => 'Razorpay configuration is missing.'], 500);
            }

            $api = new \Razorpay\Api\Api($razorpayKey, $razorpaySecret);

            $rzpOrder = $api->order->create([
                'receipt' => $builderNumber,
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'notes' => [
                    'user_id' => Auth::id(),
                    'builder_number' => $builderNumber,
                ],
            ]);

            session([
                'pc_builder_razorpay_pending' => [
                    'razorpay_order_id' => $rzpOrder['id'],
                    'user_id' => Auth::id(),
                    'validated' => $validated,
                    'selected_products' => $selectedProducts,
                    'quantities' => $quantities,
                    'cart_items' => $cartItems,
                    'subtotal' => $subtotal,
                    'gst_amount' => $gstAmount,
                    'discount_amount' => $discountAmount,
                    'shipping_amount' => $shippingAmount,
                    'total_amount' => $totalAmount,
                    'builder_number' => $builderNumber,
                ],
            ]);

            return response()->json([
                'success' => true,
                'payment_required' => true,
                'payment_method' => 'razorpay',
                'razorpay_key' => $razorpayKey,
                'razorpay_order_id' => $rzpOrder['id'],
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile_number'],
                'pc_builder_id' => $rzpOrder['id'],
                'builder_number' => $builderNumber,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            Log::error('PC Builder place order failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify Razorpay payment and finalize PC Builder order.
     */
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $pending = session('pc_builder_razorpay_pending');

        if (! $pending || $pending['user_id'] != Auth::id() || $pending['razorpay_order_id'] !== $request->razorpay_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Payment session expired. Please try again.',
            ], 422);
        }

        try {
            $api = new \Razorpay\Api\Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            $payment = $api->payment->fetch($request->razorpay_payment_id);

            if (! isset($payment['status']) || ! in_array($payment['status'], ['captured', 'authorized'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment has not been successfully captured.',
                ], 400);
            }
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            Log::error('PC Builder Razorpay signature verification failed', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
            ], 400);
        } catch (\Throwable $e) {
            Log::error('PC Builder Razorpay verification error', [
                'message' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to verify payment.',
            ], 400);
        }

        DB::beginTransaction();

        try {
            $selectedProducts = $pending['selected_products'];
            $quantities = $pending['quantities'] ?? [];

            $productIds = collect($selectedProducts)
                ->map(fn ($productId) => (int) $productId)
                ->filter()
                ->unique()
                ->values();

            $products = Product::whereIn('id', $productIds)
                ->where('status', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== $productIds->count()) {
                throw new \Exception('One or more selected products are no longer available.');
            }

            foreach ($selectedProducts as $builderType => $productId) {
                $productId = (int) $productId;
                $product = $products->get($productId);
                $quantity = (int) ($quantities[$productId] ?? $quantities[(string) $productId] ?? $quantities[$builderType] ?? 1);

                if (! $product) {
                    throw new \Exception('A selected product is no longer available.');
                }

                if ($quantity < 1) {
                    throw new \Exception('Invalid quantity for '.$product->name.'.');
                }

                if ((int) $product->stock_quantity < $quantity) {
                    throw new \Exception('Only '.$product->stock_quantity.' unit(s) of '.$product->name.' are available.');
                }

                $builderProductExists = BuilderProduct::query()
                    ->where('product_id', $product->id)
                    ->where('status', true)
                    ->exists();

                if (! $builderProductExists) {
                    throw new \Exception($product->name.' is no longer available for PC Builder.');
                }
            }

            $validated = $pending['validated'];

            $alreadyExists = Address::where('user_id', Auth::id())
                ->where('mobile', $validated['mobile_number'])
                ->where('address', $validated['address'])
                ->where('city', $validated['city'])
                ->where('state', $validated['state'])
                ->where('pincode', $validated['pincode'])
                ->exists();

            if (! $alreadyExists) {
                $isFirstAddress = ! Address::where('user_id', Auth::id())->exists();

                if ($isFirstAddress) {
                    Address::where('user_id', Auth::id())->update([
                        'is_default' => false,
                    ]);
                }

                Address::create([
                    'user_id' => Auth::id(),
                    'address_type' => 'other',
                    'name' => $validated['customer_name'],
                    'mobile' => $validated['mobile_number'],
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'country' => $validated['country'] ?: 'India',
                    'pincode' => $validated['pincode'],
                    'is_default' => $isFirstAddress,
                ]);
            }

            $builderNumber = 'PCB-'.strtoupper(date('YmdHis').'-'.substr(uniqid(), -5));

            $pcBuilder = PcBuilder::create([
                'user_id' => Auth::id(),
                'builder_number' => $builderNumber,
                'products' => $pending['cart_items'],
                'subtotal' => $pending['subtotal'],
                'gst_amount' => $pending['gst_amount'],
                'shipping_amount' => $pending['shipping_amount'],
                'discount_amount' => $pending['discount_amount'],
                'total_amount' => $pending['total_amount'],
                'payment_method' => 'razorpay',
                'payment_status' => 'paid',
                'status' => 'confirmed',
                'razorpay_order_id' => $pending['razorpay_order_id'],
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'country' => $validated['country'],
                'order_notes' => $validated['order_notes'] ?? null,
            ]);

            foreach ($selectedProducts as $builderType => $productId) {
                $productId = (int) $productId;
                $product = $products->get($productId);
                $quantity = (int) ($quantities[$productId] ?? $quantities[(string) $productId] ?? $quantities[$builderType] ?? 1);
                $product->decrement('stock_quantity', $quantity);
            }

            DB::commit();
            session()->forget('pc_builder_razorpay_pending');
            try {
                if (!empty($pcBuilder->email)) {
                    Mail::to($pcBuilder->email)
                        ->send(new PcBuilderSuccessMail($pcBuilder));

                    Log::info('PC Builder customer email sent', [
                        'builder_number' => $pcBuilder->builder_number,
                        'email' => $pcBuilder->email,
                    ]);
                }
            } catch (\Throwable $e) {
                Log::error('PC Builder customer email failed', [
                    'builder_number' => $pcBuilder->builder_number,
                    'email' => $pcBuilder->email ?? null,
                    'error' => $e->getMessage(),
                ]);
            }

            // Send success email to admin
            try {
                $adminEmail = config('mail.admin_email');

                if (!empty($adminEmail)) {
                    Mail::to($adminEmail)
                        ->send(new PcBuilderSuccessMail($pcBuilder));

                    Log::info('PC Builder admin email sent', [
                        'builder_number' => $pcBuilder->builder_number,
                        'admin_email' => $adminEmail,
                    ]);
                }
            } catch (\Throwable $e) {
                Log::error('PC Builder admin email failed', [
                    'builder_number' => $pcBuilder->builder_number,
                    'admin_email' => $adminEmail ?? null,
                    'error' => $e->getMessage(),
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Payment successful. PC Builder order placed successfully.',
                'builder_number' => $pcBuilder->builder_number,
                'pc_builder_id' => $pcBuilder->id,
                'redirect_url' => route('home'),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('PC Builder order finalization failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id(),
                'razorpay_order_id' => $pending['razorpay_order_id'] ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Payment was successful but order finalization failed. Please contact support.',
            ], 500);
        }
    }
}
