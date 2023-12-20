<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);

        return Inertia::render('Listing/Index', [
                'filters' => $filters,
                'listings' => Listing::mostRecent()
                    ->filter($filters)
                    ->withoutSold()
                    ->paginate(10)
                    ->withQueryString()
            ]
        );
    }

    public function show(Listing $listing)
    {
        //$this->authorize('view', $listing);

        $listing->load(['images']);

        $offer = Offer::query()
            ->where('listing_id', $listing->id)
            ->where('bidder_id', auth()->id())
            ->first();

        return Inertia::render('Listing/Show', [
                'listing' => $listing,
                'offerMade' => $offer
            ]);
    }
}
