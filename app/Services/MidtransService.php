<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Buat Snap Token untuk pembayaran
     */
    public function createSnapToken($booking)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $booking->order_id,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
            'item_details' => [
                [
                    'id' => 'trip-' . $booking->trip_id,
                    'price' => (int) $booking->total_price,
                    'quantity' => $booking->participants,
                    'name' => $booking->trip->title,
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Handle notifikasi dari Midtrans
     */
    public function handleNotification($notification)
    {
        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $paymentType = $notification['payment_type'] ?? null;
        $fraudStatus = $notification['fraud_status'] ?? null;

        \Log::info('Midtrans Notification', [
            'order_id' => $orderId,
            'status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
        ]);

        // Mapping status dari Midtrans ke aplikasi
        $status = $this->mapTransactionStatus($transactionStatus, $fraudStatus);

        return [
            'order_id' => $orderId,
            'status' => $status,
            'payment_type' => $paymentType,
        ];
    }

    /**
     * Map Midtrans status ke status lokal
     */
    private function mapTransactionStatus($transactionStatus, $fraudStatus)
    {
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                return 'processing';
            } elseif ($fraudStatus == 'accept') {
                return 'success';
            }
        } elseif ($transactionStatus == 'settlement') {
            return 'success';
        } elseif ($transactionStatus == 'pending') {
            return 'pending';
        } elseif ($transactionStatus == 'deny') {
            return 'failed';
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'expire') {
            return 'cancelled';
        } elseif ($transactionStatus == 'refund') {
            return 'refunded';
        }

        return 'pending';
    }

    /**
     * Verify transaction ke Midtrans
     */
    public function verifyTransaction($orderId)
    {
        try {
            $status = \Midtrans\Transaction::status($orderId);
            return $status;
        } catch (\Exception $e) {
            \Log::error('Midtrans Verify Error: ' . $e->getMessage());
            throw $e;
        }
    }
}
