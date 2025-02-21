<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_num',
    ];

    /**
     * Insert the data from file and check the format of data.
     */
    public static function bulkImport(string $filePath): bool
    {
        $xmlData = (array) simplexml_load_file($filePath);
        $isXMLDataInFormat = false;
        if (isset($xmlData['contact'])) {
            array_filter($xmlData['contact'], );
            $isXMLDataInFormat = true;
            $contacts = array_map(fn($v) => (array) $v, $xmlData['contact']);
            Contact::insert($contacts);
        }
        return $isXMLDataInFormat;
    }
}
