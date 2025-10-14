<?php

namespace App\Controllers;

use App\Models\KeuanganModel;

class AdminKeuangan extends BaseController
{
    protected $keuanganModel;

    public function __construct()
    {
        $this->keuanganModel = new KeuanganModel();

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    public function index()
    {
        $type = $this->request->getGet('type');
        $month = $this->request->getGet('month') ?: date('m');
        $year = $this->request->getGet('year') ?: date('Y');

        $builder = $this->keuanganModel;

        if ($type) {
            $builder->where('type', $type);
        }

        $builder->where('MONTH(transaction_date)', $month)
                ->where('YEAR(transaction_date)', $year);

        $transactions = $builder->orderBy('transaction_date', 'DESC')->findAll();

        // Calculate totals
        $totalIncome = 0;
        $totalExpense = 0;
        foreach ($transactions as $t) {
            if ($t['type'] == 'penerimaan') {
                $totalIncome += $t['amount'];
            } else {
                $totalExpense += $t['amount'];
            }
        }

        $data = [
            'title' => 'Keuangan Gereja',
            'transactions' => $transactions,
            'type' => $type,
            'month' => $month,
            'year' => $year,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'balance' => $totalIncome - $totalExpense
        ];

        return view('admin/keuangan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Transaksi'
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'type' => 'required|in_list[penerimaan,pengeluaran]',
                'category' => 'required',
                'amount' => 'required|numeric',
                'transaction_date' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $insertData = [
                    'type' => $this->request->getPost('type'),
                    'category' => $this->request->getPost('category'),
                    'description' => $this->request->getPost('description'),
                    'amount' => $this->request->getPost('amount'),
                    'transaction_date' => $this->request->getPost('transaction_date'),
                    'source' => $this->request->getPost('source'),
                    'notes' => $this->request->getPost('notes'),
                    'recorded_by' => session()->get('userId'),
                ];

                // Handle receipt upload
                $receiptFile = $this->request->getFile('receipt');
                if ($receiptFile && $receiptFile->isValid() && !$receiptFile->hasMoved()) {
                    $newName = $receiptFile->getRandomName();
                    $receiptFile->move('uploads/keuangan', $newName);
                    $insertData['receipt'] = $newName;
                }

                $this->keuanganModel->insert($insertData);
                session()->setFlashdata('success', 'Transaksi berhasil ditambahkan');
                return redirect()->to('/admin/keuangan');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/keuangan/create', $data);
    }

    public function edit($id)
    {
        $transaction = $this->keuanganModel->find($id);
        if (!$transaction) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Edit Transaksi',
            'transaction' => $transaction
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'type' => 'required|in_list[penerimaan,pengeluaran]',
                'category' => 'required',
                'amount' => 'required|numeric',
                'transaction_date' => 'required|valid_date',
            ];

            if ($this->validate($rules)) {
                $updateData = [
                    'type' => $this->request->getPost('type'),
                    'category' => $this->request->getPost('category'),
                    'description' => $this->request->getPost('description'),
                    'amount' => $this->request->getPost('amount'),
                    'transaction_date' => $this->request->getPost('transaction_date'),
                    'source' => $this->request->getPost('source'),
                    'notes' => $this->request->getPost('notes'),
                ];

                // Handle receipt upload
                $receiptFile = $this->request->getFile('receipt');
                if ($receiptFile && $receiptFile->isValid() && !$receiptFile->hasMoved()) {
                    $newName = $receiptFile->getRandomName();
                    $receiptFile->move('uploads/keuangan', $newName);
                    $updateData['receipt'] = $newName;
                }

                $this->keuanganModel->update($id, $updateData);
                session()->setFlashdata('success', 'Transaksi berhasil diperbarui');
                return redirect()->to('/admin/keuangan');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/keuangan/edit', $data);
    }

    public function view($id)
    {
        $transaction = $this->keuanganModel->find($id);
        if (!$transaction) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Detail Transaksi',
            'transaction' => $transaction
        ];

        return view('admin/keuangan/view', $data);
    }

    public function delete($id)
    {
        $this->keuanganModel->delete($id);
        session()->setFlashdata('success', 'Transaksi berhasil dihapus');
        return redirect()->to('/admin/keuangan');
    }

    public function report()
    {
        $year = $this->request->getGet('year') ?: date('Y');
        
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $income = $this->keuanganModel->selectSum('amount')
                ->where('type', 'penerimaan')
                ->where('MONTH(transaction_date)', $i)
                ->where('YEAR(transaction_date)', $year)
                ->first()['amount'] ?? 0;

            $expense = $this->keuanganModel->selectSum('amount')
                ->where('type', 'pengeluaran')
                ->where('MONTH(transaction_date)', $i)
                ->where('YEAR(transaction_date)', $year)
                ->first()['amount'] ?? 0;

            $monthlyData[] = [
                'month' => $i,
                'income' => $income,
                'expense' => $expense,
                'balance' => $income - $expense
            ];
        }

        // Category breakdown
        $incomeByCategory = $this->keuanganModel->select('category, SUM(amount) as total')
            ->where('type', 'penerimaan')
            ->where('YEAR(transaction_date)', $year)
            ->groupBy('category')
            ->findAll();

        $expenseByCategory = $this->keuanganModel->select('category, SUM(amount) as total')
            ->where('type', 'pengeluaran')
            ->where('YEAR(transaction_date)', $year)
            ->groupBy('category')
            ->findAll();

        $data = [
            'title' => 'Laporan Keuangan',
            'year' => $year,
            'monthlyData' => $monthlyData,
            'incomeByCategory' => $incomeByCategory,
            'expenseByCategory' => $expenseByCategory
        ];

        return view('admin/keuangan/report', $data);
    }

    public function export()
    {
        $month = $this->request->getGet('month') ?: date('m');
        $year = $this->request->getGet('year') ?: date('Y');

        $transactions = $this->keuanganModel
            ->where('MONTH(transaction_date)', $month)
            ->where('YEAR(transaction_date)', $year)
            ->orderBy('transaction_date', 'ASC')
            ->findAll();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=laporan_keuangan_' . $year . '_' . $month . '.csv');

        $output = fopen('php://output', 'w');

        // Header
        fputcsv($output, ['Tanggal', 'Tipe', 'Kategori', 'Deskripsi', 'Jumlah', 'Sumber', 'Catatan']);

        // Data
        foreach ($transactions as $t) {
            fputcsv($output, [
                $t['transaction_date'],
                $t['type'],
                $t['category'],
                $t['description'],
                $t['amount'],
                $t['source'],
                $t['notes']
            ]);
        }

        fclose($output);
        exit;
    }
}
