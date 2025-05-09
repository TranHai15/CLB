<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the transactions.
     */
    public function index()
    {
        // Get all transactions for summary calculations
        $allTransactions = Transaction::all();

        // Get paginated transactions for display
        $transactions = Transaction::with(['creator'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.transaction.index', compact('transactions', 'allTransactions'));
    }

    /**
     * Show the form for creating a new transaction.
     */
    public function create()
    {
        return view('admin.transaction.create');
    }

    /**
     * Store a newly created transaction in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
            'type' => 'required|in:in,out',
        ]);

        if ($validated['type'] === 'out') {
            $balance = Transaction::where('type', 'in')->sum('amount') - Transaction::where('type', 'out')->sum('amount');

            if ($validated['amount'] > $balance || $balance < 0) {
                return redirect()->back()
                    ->withErrors(['amount' => 'Số dư tài khoản không đủ.']);
            }
        }

        Transaction::create([
            'amount' => $validated['amount'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return to_route('admin.transactions.index')
            ->with('success', 'Giao dịch đã được tạo thành công.');
    }

    /**
     * Display the specified transaction.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['creator', 'updater']);

        return view('admin.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified transaction.
     */
    public function edit(Transaction $transaction)
    {
        return view('admin.transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified transaction in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'description' => 'required|string|max:255',
            'type' => 'required|in:in,out',
        ]);

        if ($validated['type'] === 'out') {
            $balance = Transaction::where('type', 'in')->sum('amount') - Transaction::where('type', 'out')->sum('amount');

            if ($validated['amount'] > $balance || $balance < 0) {
                return redirect()->back()
                    ->withErrors(['amount' => 'Số dư tài khoản không đủ.']);
            }
        }

        $transaction->amount = $validated['amount'];
        $transaction->description = $validated['description'];
        $transaction->type = $validated['type'];
        $transaction->updated_by = Auth::id();
        $transaction->save();

        return to_route('admin.transactions.index')
            ->with('success', 'Giao dịch đã được cập nhật thành công.');
    }

    /**
     * Remove the specified transaction from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('admin.transactions.index')
            ->with('success', 'Giao dịch đã được xóa thành công.');
    }
}
