<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class FileUploadsController extends Controller
{
    public function create()
    {
        return view('file-uploads.create');
    }

    public function store()
    {
        /** Form validation */
        request()->validate([
            'message' => 'required'
        ]);
        /** Get the message body */
        $message = request()->get('message');

        /** PHP DomDocument For Manipulating The HTML DOM 
         * We will find all images from message_body
         * Each image has base64 encoded string
         * We will use Intervention package to create image using the base64 string
         * Then save the new image generated with Intervention in Public folder
         * Make sure to save the new image name in some variable
         * Once saved now replace the message body images image source from base64 to the new uploaded image path
         * Now you have manipulated the DOM of message. It's ready to save in the database
         */
        $dom = new \DomDocument();

        /**
         * LIBXML_HTML_NOIMPLIED - Turns off automatic adding of implied elements
         * LIBXML_HTML_NODEFDTD - Prevents adding HTML doctype if default not found
         */
        $dom->loadHtml($message, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        /** I want all the images to upload them locally and replace from base64 to new image name */
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $image) {
            $imageSrc = $image->getAttribute('src');
            /** if image source is 'data-url' */
            if (preg_match('/data:image/', $imageSrc)) {
                /** etch the current image mimetype and stores in $mime */
                preg_match('/data:image\/(?<mime>.*?)\;/', $imageSrc, $mime);
                $mimeType = $mime['mime'];
                /** Create new file name with random string */
                $filename = uniqid();

                /** Public path. Make sure to create the folder
                 * public/uploads
                 */
                $filePath = "/uploads/$filename.$mimeType";

                /** Using Intervention package to create Image */
                Image::make($imageSrc)
                    /** encode file to the specified mimeType */
                    ->encode($mimeType, 100)
                    /** public_path - points directly to public path */
                    ->save(public_path($filePath));

                $newImageSrc = asset($filePath);
                $image->removeAttribute('src');
                $image->setAttribute('src', $newImageSrc);
            }
        }
        echo $dom->saveHTML();
        exit;
    }
}
