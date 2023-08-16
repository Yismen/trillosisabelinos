<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\InvoiceService;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Symfony\Component\HttpFoundation\Response;

class InvoiceDowloadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Payment $payment)
    {
        abort_unless(auth()->user()->hasAnyRole(['admin', 'Admin']), Response::HTTP_UNAUTHORIZED);

        $registration = $payment->registration;

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

        $invoice = InvoiceService::make()
            ->status(__($registration->status->name))
            // ->seller($client)
            // ->sequence(667)
            ->template('trillos')
            ->series($payment->code)
            ->buyer($customer)
            ->date(now())
            ->dateFormat('d/M/Y')
            ->notes('')
            ->currencyCode('RD')
            ->currencySymbol('$')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->images($payment->images)
            ->filename($client->name . ' ' . $customer->name)
            ->logo(public_path('images/logo.png'))
            ->addItems($items)
            ->save('public');


        // $link = $invoice->url();

        return $invoice->stream();
    }
}
