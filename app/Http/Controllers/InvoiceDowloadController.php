<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Symfony\Component\HttpFoundation\Response;

class InvoiceDowloadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Registration $registration)
    {
        abort_if($registration->payments->count() === 0, Response::HTTP_NOT_FOUND);

        abort_unless(auth()->user()->hasAnyRole(['admin', 'Admin']), Response::HTTP_UNAUTHORIZED);

        $client = new Party([
            'name' => 'Trillos Isabelinos 2023',
            'custom_fields' => [
                'telefono' => '829-993-7940',
                'email' => 'trillosisabelinos@gmail.com',
            ],
        ]);

        $customer = new Party([
            'name'          => $registration->name,
            'custom_fields' => [
                'telefono' => $registration->phone,
                'email' => $registration->email,
                'grupo' => $registration->group,
            ],
        ]);

        $items = [];

        foreach ($registration->sales as $sale) {
            $items[] = (new InvoiceItem())
                ->title($sale->plan->name)
                ->pricePerUnit($sale->unit_price)
                ->quantity($sale->count);
        }

        $invoice = Invoice::make()
            ->status(__($registration->status->name))
            // ->seller($client)
            // ->sequence(667)
            ->series($registration->payments->first()->code)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('d/M/Y')
            ->notes('')
            ->currencyCode('RD')
            ->currencySymbol('$')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->filename($client->name . ' ' . $customer->name)
            ->logo(public_path('images/logo.png'))
            ->addItems($items)
            ->save('public');


        $link = $invoice->url();

        return $invoice->stream();
    }
}
