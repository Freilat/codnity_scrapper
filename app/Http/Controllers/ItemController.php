<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

class ItemController extends Controller
{
    
    /**
     * Display the user's profile form.
     */



    public function getItems(Request $request) 
    {
        $items = Item::all();
        return ItemResource::collection($items);
    }

    
    /**
     * Delete the item.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => ['required','exists:items'],
        ]);
        $item = Item::find($validated['id']);
        $item->delete();
        return Redirect::route('items');
    }


}
