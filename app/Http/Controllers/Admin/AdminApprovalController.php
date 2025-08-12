<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Seller;

class AdminApprovalController extends Controller
{
    public function deliveryApprovals()
    {
        $deliveries = Delivery::with('user')
            ->withCount('purchases')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.approvals.deliveries', compact('deliveries'));
    }

    public function sellerApprovals()
    {
        $sellers = Seller::with('user')
            ->withCount('products')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.approvals.sellers', compact('sellers'));
    }

    public function approveDelivery($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->update(['is_proved' => 1]);
        
        return back()->with('success', 'Delivery person approved successfully!');
    }

    public function rejectDelivery($id)
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->update(['is_proved' => 0]);
        
        return back()->with('success', 'Delivery person approval revoked!');
    }

    public function approveSeller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->update(['is_proved' => 1]);
        
        return back()->with('success', 'Seller approved successfully!');
    }

    public function rejectSeller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->update(['is_proved' => 0]);
        
        return back()->with('success', 'Seller approval revoked!');
    }

    public function searchDeliveries(Request $request)
    {
        $query = $request->get('query', '');
        
        $deliveries = Delivery::with('user')
            ->withCount('purchases')
            ->where(function($q) use ($query) {
                $q->where('nama', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('delivery_serial', 'LIKE', "%{$query}%")
                  ->orWhere('no_telepon', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($delivery) {
                return [
                    'id' => $delivery->id,
                    'nama' => $delivery->nama,
                    'email' => $delivery->email,
                    'delivery_serial' => $delivery->delivery_serial,
                    'no_telepon' => $delivery->no_telepon,
                    'foto_profile' => $delivery->foto_profile,
                    'purchases_count' => $delivery->purchases_count,
                    'is_proved' => $delivery->is_proved,
                    'user_name' => $delivery->user ? $delivery->user->name : null,
                    'created_at_formatted' => $delivery->created_at ? $delivery->created_at->format('M d, Y') : 'Unknown'
                ];
            });
        
        return response()->json(['deliveries' => $deliveries]);
    }

    public function searchSellers(Request $request)
    {
        $query = $request->get('query', '');
        
        $sellers = Seller::with('user')
            ->withCount('products')
            ->where(function($q) use ($query) {
                $q->where('nama_toko', 'LIKE', "%{$query}%")
                  ->orWhere('email', 'LIKE', "%{$query}%")
                  ->orWhere('seller_serial', 'LIKE', "%{$query}%")
                  ->orWhere('no_telepon', 'LIKE', "%{$query}%");
            })
            ->get()
            ->map(function($seller) {
                return [
                    'id' => $seller->id,
                    'nama_toko' => $seller->nama_toko,
                    'email' => $seller->email,
                    'seller_serial' => $seller->seller_serial,
                    'no_telepon' => $seller->no_telepon,
                    'foto_profile' => $seller->foto_profile,
                    'products_count' => $seller->products_count,
                    'is_proved' => $seller->is_proved,
                    'user_name' => $seller->user ? $seller->user->name : null,
                    'created_at_formatted' => $seller->created_at ? $seller->created_at->format('M d, Y') : 'Unknown'
                ];
            });
        
        return response()->json(['sellers' => $sellers]);
    }
}