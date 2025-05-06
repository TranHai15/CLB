<?php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\Transaction;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Carbon\Carbon;

// class FinanceController extends Controller
// {
//     public function index()
//     {
//         // Summary statistics
//         $totalIncome = Transaction::where('amount', '>', 0)->sum('amount');
//         $totalExpense = Transaction::where('amount', '<', 0)->sum('amount') * -1;
//         $balance = $totalIncome - $totalExpense;

//         // Get transactions for the current month
//         $monthStart = Carbon::now()->startOfMonth();
//         $monthEnd = Carbon::now()->endOfMonth();

//         $monthlyIncome = Transaction::where('amount', '>', 0)
//             ->whereBetween('created_at', [$monthStart, $monthEnd])
//             ->sum('amount');

//         $monthlyExpense = Transaction::where('amount', '<', 0)
//             ->whereBetween('created_at', [$monthStart, $monthEnd])
//             ->sum('amount') * -1;

//         // Recent transactions
//         $recentTransactions = Transaction::with('creator')
//             ->orderBy('created_at', 'desc')
//             ->take(10)
//             ->get();

//         return view('admin.finances.index', compact(
//             'totalIncome',
//             'totalExpense',
//             'balance',
//             'monthlyIncome',
//             'monthlyExpense',
//             'recentTransactions'
//         ));
//     }

//     public function income()
//     {
//         $incomeTransactions = Transaction::with('creator')
//             ->where('amount', '>', 0)
//             ->orderBy('created_at', 'desc')
//             ->paginate(10);

//         return view('admin.finances.income', compact('incomeTransactions'));
//     }

//     public function expense()
//     {
//         $expenseTransactions = Transaction::with('creator')
//             ->where('amount', '<', 0)
//             ->orderBy('created_at', 'desc')
//             ->paginate(10);

//         return view('admin.finances.expense', compact('expenseTransactions'));
//     }

//     public function indexTransactions()
//     {
//         $transactions = Transaction::with('creator')->orderBy('created_at', 'desc')->paginate(10);
//         return view('admin.finances.transactions.index', compact('transactions'));
//     }

//     public function create()
//     {
//         return view('admin.finances.transactions.create');
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
//             'amount' => 'required|numeric',
//             'description' => 'required|string',
//             'type' => 'required|in:income,expense'
//         ]);

//         // Convert expense to negative amounts
//         $amount = $validated['type'] === 'expense'
//             ? -1 * abs($validated['amount'])
//             : abs($validated['amount']);

//         Transaction::create([
//             'amount' => $amount,
//             'description' => $validated['description'],
//             'created_by' => Auth::id(),
//             'updated_by' => Auth::id()
//         ]);

//         return redirect()->route('admin.finances.transactions.index')
//             ->with('success', 'Giao dịch tài chính đã được tạo thành công!');
//     }

//     public function show(Transaction $transaction)
//     {
//         $transaction->load('creator');
//         return view('admin.finances.transactions.show', compact('transaction'));
//     }

//     public function edit(Transaction $transaction)
//     {
//         return view('admin.finances.transactions.edit', compact('transaction'));
//     }

//     public function update(Request $request, Transaction $transaction)
//     {
//         $validated = $request->validate([
//             'amount' => 'required|numeric',
//             'description' => 'required|string',
//             'type' => 'required|in:income,expense'
//         ]);

//         // Convert expense to negative amounts
//         $amount = $validated['type'] === 'expense'
//             ? -1 * abs($validated['amount'])
//             : abs($validated['amount']);

//         $transaction->update([
//             'amount' => $amount,
//             'description' => $validated['description'],
//             'updated_by' => Auth::id()
//         ]);

//         return redirect()->route('admin.finances.transactions.index')
//             ->with('success', 'Giao dịch tài chính đã được cập nhật thành công!');
//     }

//     public function destroy(Transaction $transaction)
//     {
//         $transaction->delete();

//         return redirect()->route('admin.finances.transactions.index')
//             ->with('success', 'Giao dịch tài chính đã được xóa thành công!');
//     }
// }
