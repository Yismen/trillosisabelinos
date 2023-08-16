<?php

namespace App\Services;

use LaravelDaily\Invoices\Invoice;
use Symfony\Component\HttpFoundation\File\File;

class InvoiceService extends Invoice
{
    public $images;

    public function images(array | null $images)
    {
        $this->images = $images;

        return $this;
    }

    public function getImage(string $url)
    {
        $file = new File("storage/" . $url);

        return 'data:' . $file->getMimeType() . ';base64,' . base64_encode($file->getContent());
    }
}
