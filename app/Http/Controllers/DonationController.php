<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function __construct()
    {
        \Midtrans\Config::$serverKey = config('services.midtrans.serverKey');
        \Midtrans\Config::$isProduction = config('services.midtrans.isProduction');
        \Midtrans\Config::$isSanitized = config('services.midtrans.isSanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index(): View
    {
        $donations = Donation::query()->latest()->paginate(8);
        return view('welcome', [
            'donations' => $donations,
        ]);
    }
    public function create(): View
    {
        return view('donation');
    }

    public function store(Request $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            $donation = Donation::create([
                'donation_code' => 'SANDBOX-' . uniqid(),
                'donor_name' => $request->donor_name,
                'donor_email' => $request->donor_email,
                'donation_type' => $request->donation_type,
                'amount' => floatval($request->amount),
                'note' => $request->note,
            ]);

            $payload = [
                'transaction_details' => [
                    'order_id' => $donation->donation_code,
                    'gross_amount' => $donation->amount,
                ],
                'item_details' => [
                    [
                        'id' => $donation->donation_type,
                        'price' => $donation->amount,
                        'quantity' => 1,
                        'name' => ucwords(str_replace('_', ' ', $donation->donation_type))
                    ]
                ],
                'customer_details' => [
                    'first_name' => $donation->donor_name,
                    'last_name' => '',
                    'email' => $donation->donor_email,
                ],

            ];

            $snapToken = \Midtrans\Snap::getSnapToken($payload);
            $donation->snap_token = $snapToken;
            $donation->save();

            $this->response['snap_token'] = $snapToken;
        });
        return response()->json($this->response);
    }

    public function notification()
    {
        $notif = new \Midtrans\Notification();
        DB::transaction(function () use ($notif) {
            $transactionStatus = $notif->transaction_status;
            $paymentType = $notif->payment_type;
            $orderId = $notif->order_id;
            $fraudStatus = $notif->fraud_status;
            $donation = Donation::where('donation_code', $orderId)->first();

            if ($transactionStatus == 'capture') {
                if ($paymentType == 'credit_card') {
                    if ($fraudStatus == 'challenge') {
                        $donation->setStatusPending();
                    } else {
                        $donation->setStatusSuccess();
                    }
                }
            } elseif ($transactionStatus == 'settlement') {
                $donation->setStatusSuccess();
            } elseif ($transactionStatus == 'pending') {
                $donation->setStatusPending();
            } elseif ($transactionStatus == 'deny') {
                $donation->setStatusFailed();
            } elseif ($transactionStatus == 'expire') {
                $donation->setStatusExpired();
            } elseif ($transactionStatus == 'cancel') {
                $donation->setStatusFailed();
            }
        });
        return;
    }
}
