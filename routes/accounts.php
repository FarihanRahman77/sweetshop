<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Accounts\AccountController;
use App\Http\Controllers\Admin\Journal\JournalController;
use App\Http\Controllers\Admin\Accounts\Expense\ExpenseController;
use App\Http\Controllers\Admin\Setup\AccountSettingController; 
use App\Http\Controllers\Admin\Accounts\BillController; 
use App\Http\Controllers\Admin\Accounts\BankController; 
use App\Http\Controllers\Admin\Accounts\TransactionController; 
use App\Http\Controllers\Admin\Reports\ReportController; 









Route::group(['middleware' => ['auth']], function () {

	/* helpers for voucher insert  */
	Route::get('/helpers/function',function(){
		return enterVoucher();
	 });


	/* Account settings */
	Route::get('account/settings/view', [AccountSettingController::class, 'index'])->name('accountSettingView');
	Route::post('account/settings/store', [AccountSettingController::class, 'store'])->name('accountSettingStore');

	/* Accounts */
	Route::get('chart/Of/Accounts/view', [AccountController::class, 'index'])->name('chartOfAccounts');
	Route::post('chart/Of/Accounts/store', [AccountController::class, 'store'])->name('coaStore');
	Route::get('chart/Of/Accounts/get', [AccountController::class, 'getCOA'])->name('getCOA');
	Route::get('chart/Of/Accounts/edit', [AccountController::class, 'edit'])->name('editCOA');
	Route::Post('chart/Of/Accounts/update', [AccountController::class, 'update'])->name('coaUpdate');
	Route::Post('chart/Of/Accounts/delete', [AccountController::class, 'delete'])->name('coaDelete');
	Route::get('chart/Of/Accounts/get/Code/Range', [AccountController::class, 'getCodeRange'])->name('getCodeRange');
	




	/* Journal */ 
	Route::get('journal/view', [JournalController::class, 'index'])->name('journalView');
	Route::get('journal/get/Journal/Data', [JournalController::class, 'getJournalData'])->name('getJournalData');
	Route::get('journal/create', [JournalController::class, 'create'])->name('addJournal');
	Route::post('journal/store', [JournalController::class, 'store'])->name('journalStore');
	Route::get('journal/details/{id}', [JournalController::class, 'seeDetails'])->name('journalDetails');
	Route::get('journal/get/Equalization', [JournalController::class, 'equalization'])->name('getEqualization');
	





	/* expense */
	Route::get('expense/View/', [ExpenseController::class, 'index'])->name('expenseView');
	Route::get('expense/get/data/', [ExpenseController::class, 'getExpense'])->name('getExpense');
	Route::get('expense/create/', [ExpenseController::class, 'create'])->name('addExpense');
	Route::get('expense/get/Account/Status/', [ExpenseController::class, 'getAccountStatus'])->name('getAccountStatus');
	Route::get('expense/get/Amount/', [ExpenseController::class, 'getAmount'])->name('getAmount');
	Route::post('expense/store/', [ExpenseController::class, 'store'])->name('expenseStore');
	Route::get('expense/details/{id}', [ExpenseController::class, 'seeDetails'])->name('expense/details');
	Route::get('expenses/report/view', [ExpenseController::class, 'reportView'])->name('expensesReportView');
	Route::get('expenses/report/generate', [ExpenseController::class, 'expenseReportGenerate'])->name('expenseReportGenerate');
	Route::get('expense/report/Pdf/{data}', [ExpenseController::class, 'generateExpensePdf'])->name('generatePdf');
    
            

	



	




	/* Bill start */
	Route::get('account/bills/view', [BillController::class,'index'])->name('billView');
	Route::get('account/bills/create', [BillController::class,'create'])->name('addBills');
	Route::get('account/bill/details/{id}', [BillController::class,'seeDetails'])->name('seeDetails');
	Route::get('account/bill/get/bills', [BillController::class,'getBill'])->name('getBill');
	Route::post('bill/store/', [BillController::class, 'store'])->name('billStore');
	
	Route::get('account/bills/payment', [BillController::class,'payBills'])->name('payBills');
	Route::get('account/bills/payment/get/BillData', [BillController::class,'getBillData'])->name('getBillData');
	Route::post('bill/pay/store/', [BillController::class, 'billPayStore'])->name('billPayStore');
	/* bill end */









/* Banks start */
Route::get('account/banks/view', [BankController::class,'index'])->name('bankView');
Route::get('account/banks/get/data', [BankController::class, 'geData'])->name('getBanks');


/* transactions */
Route::get('account/view/transactions', [TransactionController::class, 'index'])->name('transactionsView');
Route::get('account/transactions/get/data', [TransactionController::class, 'geData'])->name('getTransactions');
Route::get('account/transactions/from/amount', [TransactionController::class, 'getFromAmount'])->name('getFromAmount');
Route::get('account/transactions/to/amount', [TransactionController::class, 'getToAmount'])->name('getToAmount');
Route::get('account/transactions/check/amount/transfer/limit', [TransactionController::class, 'checkTransferLimit'])->name('checkTransferLimit');
Route::post('account/transactions/store', [TransactionController::class, 'store'])->name('transactionStore');
Route::post('account/transactions/delete', [TransactionController::class, 'delete'])->name('transactionDelete');
Route::get('account/transactions/transfer/from/source', [TransactionController::class, 'getTransferFromSource'])->name('getTransferFromSource');
Route::get('account/transactions/transfer/to/source', [TransactionController::class, 'getTransferToSource'])->name('getTransferToSource');
Route::get('account/transactions/transfer/from/ac/no', [TransactionController::class, 'getTransferFromAcNo'])->name('getTransferFromAcNo');
Route::get('account/transactions/transfer/from/ac/no', [TransactionController::class, 'getTransferFromAcNo'])->name('getTransferFromAcNo');
Route::get('account/transactions/transfer/to/ac/no', [TransactionController::class, 'getTransferToAcNo'])->name('getTransferToAcNo');






/* report start */
Route::get('account/reports/vouchers', [ReportController::class,'index'])->name('partyLedger');
Route::get('account/reports/partyDues', [ReportController::class,'partyDues'])->name('partyDues');
Route::post('account/generate/vouchers', [ReportController::class,'generateVoucher'])->name('generateVoucher');
Route::get('account/vouchers/pdf/{vendor_id}/{date_from}/{date_to}', [ReportController::class,'generatePdf']);
Route::get('account/vouchers/datewise/summary', [ReportController::class,'accountsSummaryView'])->name('accountsLedgerDatewise');
Route::post('account/vouchers/datewise/summary/generate', [ReportController::class,'accountsSummaryGenerate'])->name('generateSummaryReport');
Route::get('account/closing/balance/store', [ReportController::class,'closingBalanceStore'])->name('closingBalanceStore');
Route::get('account/summary/pdf/{date_from}/{date_to}', [ReportController::class,'generateAccountsSummaryPdf']);
Route::get('account/daily/ledger/summary', [ReportController::class,'dailyAccountsLedger'])->name('dailyAccountsLedger');
Route::post('account/daily/ledger/summary/generate', [ReportController::class,'generateDailySummaryReport'])->name('generateDailySummaryReport');

Route::get('account/salesDetails/pdf/{date_from}/{date_to}', [ReportController::class, 'generateSalesDetailsAccountsPdf']);
Route::get('account/purchaseDetails/pdf/{date_from}/{date_to}', [ReportController::class, 'generatePurchaseDetailsAccountsPdf']);
Route::get('account/expenseDetails/pdf/{date_from}/{date_to}/{expenseId}', [ReportController::class, 'generateExpenseDetailsAccountsPdf']);
Route::get('account/openingClosingStockDetails/pdf/{date_from}/{date_to}/{stockType}', [ReportController::class, 'generateOpenigClosingStockDetailsPdf']);
Route::get('account/daily/closing/balance/store', [ReportController::class,'closingDayBalanceStore'])->name('closingDayBalanceStore');
Route::get('accounts/daily/summary/pdf/{date_from}', [ReportController::class,'generateDailyAccountsSummaryPdf']);
Route::get('service/salesummary/pdf/{date_from}/{date_to}', [ReportController::class, 'serviceSaleSummaryPdf']);

Route::get('daily/service/report/ServiceLedger', [ReportController::class,'dailyServiceLedgerReport'])->name('dailyServiceLedgerReport');

Route::post('daily/service/report/generate', [ReportController::class,'generateDailyServiceReport'])->name('generateDailyServiceReport');
Route::get('/reports/bankLedger/', [ReportController::class, 'bankLedger'])->name('bankLedger');
Route::post('/reports/generateBankLedger/', [ReportController::class, 'generateBankLedger'])->name('generateBankLedger');
Route::get('account/Bank/Ledger/pdf/{payment_method}/{source}/{accounts}/{date_from}/{date_to}', [ReportController::class,'generateBankLedgerPdf']);

Route::get('service/daily/report/pdf/{date_from}', [ReportController::class,'ServiceLedgerReportPdf'])->name('ServiceLedgerReportPdf');
Route::post('/get-daily-report', [ReportController::class, 'getDailyReport'])->name('getDailyReport');
Route::post('/saveTodayReport', [ReportController::class, 'saveTodayReport'])->name('saveTodayReport');
//order wise profit
Route::get('applicantWiseProfit/{type}', [ReportController::class,'applicantWiseProfit'])->name('applicantWiseProfit');
Route::post('generateOrderWiseProfit/', [ReportController::class,'generateOrderWiseProfit'])->name('generateOrderWiseProfit');
Route::get('generateOrderWiseProfit/pdf/{applicant_id}/{date_from}/{date_to}/{type}', [ReportController::class,'generateOrderWiseProfitPdf']);



/* reports end */


/*service Summary Report JTSC*/

Route::get('/serviceSaleSUmmaryReport', [ReportController::class, 'serviceSaleSummaryReport'])->name('serviceSaleSUmmaryReport');
Route::get('service/salesummary/pdf/{id}', [ReportController::class, 'serviceSaleSummaryPdf']);
Route::post('/generate/Sale/Summary/Report', [ReportController::class, 'generateSaleSummaryReport'])->name('generateSaleSummaryReport');
/* reports end */



});
