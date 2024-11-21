<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\{Payer, Item, ItemList, Amount, Transaction, RedirectUrls, Payment, Authorization};

class PayPalController extends Controller
{
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                config('services.paypal.client_id'),
                config('services.paypal.client_secret')
            )
        );
        $this->apiContext->setConfig(config('services.paypal.settings'));
    }

    public function createPayment(Request $request, $productoId)
    {
        $producto = Producto::findOrFail($productoId);
        $precioTotal = $request->input('precio_total') * 0.95;
        $comision = $precioTotal * 0.05;
        $montoUsuario = $precioTotal - $comision;

        $payer = new Payer();
        $payer->setPaymentMethod("paypal");

        // Artículo alquilado
        $item = new Item();
        $item->setName($producto->nombre)
            ->setCurrency("EUR")
            ->setQuantity(1)
            ->setPrice($montoUsuario);

        $itemList = new ItemList();
        $itemList->setItems([$item]);

        $amount = new Amount();
        $amount->setCurrency("EUR")
            ->setTotal($precioTotal);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($itemList)
            ->setDescription("Alquiler del producto: " . $producto->nombre);

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('paypal.success', $productoId))
            ->setCancelUrl(route('paypal.cancel'));

        $payment = new Payment();
        $payment->setIntent("authorize") // Autorizar el pago
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions([$transaction]);

        try {
            $payment->create($this->apiContext);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->away($payment->getApprovalLink());
    }

    public function successPayment(Request $request, $productoId)
    {
        $paymentId = $request->query('paymentId');
        $payerId = $request->query('PayerID');

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $payment->execute($execution, $this->apiContext);

            // Bloquear la reserva
            Reserva::create([
                'producto_id' => $productoId,
                'user_id' => auth()->id(),
                'fecha_inicio' => $request->input('fecha_inicio'),
                'fecha_fin' => $request->input('fecha_fin'),
            ]);

            return redirect()->route('productos.ver', $productoId)->with('success', 'Pago realizado con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('productos.ver', $productoId)->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function capturePayment($authorizationId)
    {
        $authorization = Authorization::get($authorizationId, $this->apiContext);

        $capture = new Capture();
        $amount = new Amount();
        $amount->setCurrency('EUR')->setTotal($authorization->getAmount()->getTotal());
        $capture->setAmount($amount);

        try {
            $authorization->capture($capture, $this->apiContext);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
