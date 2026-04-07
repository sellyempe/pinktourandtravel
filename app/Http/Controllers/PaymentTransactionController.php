<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use Illuminate\Http\Request;

class PaymentTransactionController extends Controller
{
    // GET /api/payments - Get user's payment transactions
    public function index()
    {
        $user = auth()->user();
        $payments = $user->paymentTransactions()
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($payments, 200);
    }

    // GET /api/payments/{id} - Get single payment
    public function show($id)
    {
        $payment = PaymentTransaction::findOrFail($id);
        $this->authorize('view', $payment);
        return response()->json($payment, 200);
    }

    // POST /api/payments - Create payment transaction
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_id' => 'required|string|unique:payment_transactions',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'nullable|string',
            'gateway' => 'nullable|string',
            'metadata' => 'nullable|json',
        ]);

        $payment = PaymentTransaction::create([
            'user_id' => auth()->id(),
            'reference_id' => $validated['reference_id'],
            'amount' => $validated['amount'],
            'status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'gateway' => $validated['gateway'],
            'metadata' => $validated['metadata'],
        ]);

        return response()->json($payment, 201);
    }

    // PUT /api/payments/{id} - Update payment status
    public function update(Request $request, $id)
    {
        $payment = PaymentTransaction::findOrFail($id);
        $this->authorize('update', $payment);

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,success,failed,cancelled,refunded',
            'gateway_transaction_id' => 'nullable|string',
            'transaction_date' => 'nullable|date',
            'metadata' => 'nullable|json',
        ]);

        $payment->update($validated);
        return response()->json($payment, 200);
    }

    // GET /api/payments/by-reference/{referenceId} - Get by reference
    public function getByReference($referenceId)
    {
        $payment = PaymentTransaction::where('reference_id', $referenceId)
            ->first();

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $this->authorize('view', $payment);
        return response()->json($payment, 200);
    }
}
