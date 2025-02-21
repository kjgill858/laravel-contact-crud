<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\BulkImportContactRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Contact;
use Illuminate\Support\Facades\File;
use Illuminate\Database\UniqueConstraintViolationException;
use PhpParser\Node\Expr\Throw_;

class BulkImportContactController extends Controller
{
    const SUCCESS_MESSAGE                  = 'All the contacts added successfully.';
    const SUCCESS_STATUS                   = 'success';
    const UNIQUE_CONTACT_NUM_ERROR_MESSAGE = 'Please remove the existing contact numbers before uploading again.';
    const ERROR_STATUS                     = 'error';
    const XML_DATA_FORMAT_ERROR_MESSAGE    = 'Please upload the file in the same format mentioned above.';
    const GENERAL_ERROR_MESSAGE            = 'Something went wrong. That might be due to the format of the uploaded XML data. Please try again.';

    /**
     * Import the contacts from the uploaded file.
     */
    public function import(BulkImportContactRequest $request): RedirectResponse
    {
        $file = $request->file('attachment');
        try {
            $isXMLDataInFormat = Contact::bulkImport($file->getRealPath());
            if (!$isXMLDataInFormat) {
                return redirect()->route('upload')
                         ->with(self::ERROR_STATUS, self::XML_DATA_FORMAT_ERROR_MESSAGE);
            }
        } catch (UniqueConstraintViolationException $e) {
            return redirect()->route('upload')
                            ->with(self::ERROR_STATUS, self::UNIQUE_CONTACT_NUM_ERROR_MESSAGE);
        } catch (\Exception $e) {
            return redirect()->route('upload')
                            ->with(self::ERROR_STATUS, self::GENERAL_ERROR_MESSAGE);
        }
        return redirect()->route('contacts.index')
                         ->with(self::SUCCESS_STATUS, self::SUCCESS_MESSAGE);

    }

    /**
     * Show the form for uploading a XML file.
     */
    public function upload()
    {
        return view('contacts.bulkImportContact');

    }
}
