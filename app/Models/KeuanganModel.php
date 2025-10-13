<?php

namespace App\Models;

use CodeIgniter\Model;

class KeuanganModel extends Model
{
    protected $table            = 'keuangan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'transaction_code',
        'type',
        'category',
        'sub_category',
        'description',
        'amount',
        'transaction_date',
        'source',
        'receipt_number',
        'attachment',
        'notes',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'transaction_code' => 'required|is_unique[keuangan.transaction_code,id,{id}]',
        'type'             => 'required|in_list[penerimaan,pengeluaran]',
        'category'         => 'required|max_length[100]',
        'description'      => 'required',
        'amount'           => 'required|decimal',
        'transaction_date' => 'required|valid_date',
        'created_by'       => 'required|integer',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function generateTransactionCode()
    {
        $date = date('Ymd');
        $lastTransaction = $this->like('transaction_code', $date, 'after')->orderBy('id', 'DESC')->first();
        $sequence = $lastTransaction ? intval(substr($lastTransaction['transaction_code'], -3)) + 1 : 1;
        return $date . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    public function getMonthlyReport($year, $month)
    {
        return $this->select('type, category, SUM(amount) as total')
                    ->where('YEAR(transaction_date)', $year)
                    ->where('MONTH(transaction_date)', $month)
                    ->groupBy(['type', 'category'])
                    ->findAll();
    }

    public function getYearlyReport($year)
    {
        return $this->select('type, MONTH(transaction_date) as month, SUM(amount) as total')
                    ->where('YEAR(transaction_date)', $year)
                    ->groupBy(['type', 'MONTH(transaction_date)'])
                    ->findAll();
    }

    public function getBalance()
    {
        $penerimaan = $this->where('type', 'penerimaan')->selectSum('amount')->first()['amount'] ?? 0;
        $pengeluaran = $this->where('type', 'pengeluaran')->selectSum('amount')->first()['amount'] ?? 0;
        return $penerimaan - $pengeluaran;
    }
}
