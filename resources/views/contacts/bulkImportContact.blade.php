@extends('contacts.layout')

@section('content')

<div class="card mt-5">
    <h2 class="card-header">Bulk Import Contacts</h2>
    <div class="card-body">

        @if(session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif

        <div class="d-grid gap-2 d-md-flex mb-3 justify-content-md-end">
            <a class="btn btn-primary btn-sm" href="{{ route('contacts.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>

        <div class="alert alert-warning" role="alert">
            <h4 class="alert-heading">XML File Format</h4>
            <p>Please upload the contacts in XML file to avoid errors.
            <hr>
            <textarea rows="12" cols="70" style="border:none;resize:none;" disabled>
                <?xml version="1.0" encoding="UTF-8"?>
                <contact_list>
                    <contact>
                        <name>KöktenAdal</name>
                        <phone_num>+90 333 8859342</phone_num>
                    </contact>
                    <contact>
                        <name>HammaAbdurrezak</name>
                        <phone_num>+90 333 1563682</phone_num>
                    </contact>
                </contact_list>
            </textarea>
        </div>

        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="inputName" class="form-label"><strong>Upload XML File:</strong></label>
                <input 
                    type="file" 
                    name="attachment" 
                    class="form-control @error('attachment') is-invalid @enderror" 
                    id="inputName" 
                    placeholder="Name">
                @error('attachment')
                    <div class="form-text text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-info"><i class="fa-solid fa-floppy-disk"></i> Submit</button>
        </form>

    </div>
</div>
@endsection
