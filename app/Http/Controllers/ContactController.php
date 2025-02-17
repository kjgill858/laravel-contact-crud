<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;

class ContactController extends Controller
{
    const PAGINATION      = 5;
    const SUCCESS_MESSAGE = 'Contact Added Successfully';
    const UPDATE_MESSAGE  = 'Contact Updated Successfully';
    const DELETE_MESSAGE  = 'Contact Deleted Successfully';
    const STATUS          = 'success';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(self::PAGINATION);
        return view('contacts.index', compact('contacts'))
                    ->with('i', (request()->input('page', 1) - 1) * self::PAGINATION);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request): RedirectResponse
    {   
        Contact::create($request->validated());
           
        return redirect()->route('contacts.index')
                         ->with(self::STATUS, self::SUCCESS_MESSAGE);
    }
  
    /**
     * Display the specified resource.
     */
    public function show(Contact $contact): View
    {
        return view('contacts.show', compact('contact'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact): View
    {
        return view('contacts.edit', compact('contact'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(ContactUpdateRequest $request, Contact $contact): RedirectResponse
    {
        $contact->update($request->validated());
          
        return redirect()->route('contacts.index')
                        ->with(self::STATUS, self::UPDATE_MESSAGE);
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();
        return redirect()->route('contacts.index')
                        ->with(self::STATUS, self::UPDATE_MESSAGE);
    }
}
