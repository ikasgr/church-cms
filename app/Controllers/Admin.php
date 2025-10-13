<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\JemaatModel;
use App\Models\KeuanganModel;
use App\Models\KegiatanModel;
use App\Models\IbadahModel;
use App\Models\FeedbackModel;
use App\Models\RegistrationModel;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    protected $userModel;
    protected $jemaatModel;
    protected $keuanganModel;
    protected $kegiatanModel;
    protected $ibadahModel;
    protected $feedbackModel;
    protected $registrationModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jemaatModel = new JemaatModel();
        $this->keuanganModel = new KeuanganModel();
        $this->kegiatanModel = new KegiatanModel();
        $this->ibadahModel = new IbadahModel();
        $this->feedbackModel = new FeedbackModel();
        $this->registrationModel = new RegistrationModel();

        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/admin/login');
        }
    }

    public function index(): string
    {
        $data = [
            'title' => 'Dashboard Admin - CMS Church FLOBAMORA',
            'stats' => $this->getDashboardStats(),
            'recent_activities' => $this->getRecentActivities(),
            'upcoming_events' => $this->getUpcomingEvents(),
        ];

        return view('admin/dashboard', $data);
    }

    private function getDashboardStats()
    {
        return [
            'total_jemaat' => $this->jemaatModel->countAll(),
            'active_jemaat' => $this->jemaatModel->where('status', 'aktif')->countAllResults(),
            'total_keuangan' => $this->keuanganModel->getBalance(),
            'this_month_income' => $this->keuanganModel->selectSum('amount')
                ->where('type', 'penerimaan')
                ->where('MONTH(transaction_date)', date('m'))
                ->where('YEAR(transaction_date)', date('Y'))
                ->first()['amount'] ?? 0,
            'this_month_expense' => $this->keuanganModel->selectSum('amount')
                ->where('type', 'pengeluaran')
                ->where('MONTH(transaction_date)', date('m'))
                ->where('YEAR(transaction_date)', date('Y'))
                ->first()['amount'] ?? 0,
            'upcoming_events' => $this->kegiatanModel->where('date_start >=', date('Y-m-d'))->countAllResults(),
            'pending_feedback' => $this->feedbackModel->where('status', 'new')->countAllResults(),
            'pending_registration' => $this->registrationModel->where('status', 'pending')->countAllResults(),
        ];
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Recent jemaat registrations
        $recentJemaat = $this->jemaatModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        foreach ($recentJemaat as $jemaat) {
            $activities[] = [
                'type' => 'jemaat',
                'message' => "Jemaat baru: {$jemaat['full_name']}",
                'date' => $jemaat['created_at'],
                'icon' => 'user-plus'
            ];
        }

        // Recent financial transactions
        $recentTransactions = $this->keuanganModel->orderBy('created_at', 'DESC')->limit(5)->findAll();
        foreach ($recentTransactions as $transaction) {
            $activities[] = [
                'type' => 'keuangan',
                'message' => "Transaksi {$transaction['type']}: Rp " . number_format($transaction['amount'], 0, ',', '.'),
                'date' => $transaction['created_at'],
                'icon' => $transaction['type'] == 'penerimaan' ? 'plus-circle' : 'minus-circle'
            ];
        }

        // Sort by date
        usort($activities, function($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return array_slice($activities, 0, 10);
    }

    private function getUpcomingEvents()
    {
        return $this->kegiatanModel->where('date_start >=', date('Y-m-d'))
                                   ->where('is_published', 1)
                                   ->orderBy('date_start', 'ASC')
                                   ->limit(5)
                                   ->findAll();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin');
        }

        $data = [
            'title' => 'Login Admin - CMS Church FLOBAMORA'
        ];

        if ($this->request->getMethod() === 'POST') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                if ($user['is_active']) {
                    session()->set([
                        'isLoggedIn' => true,
                        'userId' => $user['id'],
                        'username' => $user['username'],
                        'fullName' => $user['full_name'],
                        'role' => $user['role'],
                    ]);

                    $this->userModel->updateLastLogin($user['id']);

                    return redirect()->to('/admin');
                } else {
                    session()->setFlashdata('error', 'Akun Anda tidak aktif');
                }
            } else {
                session()->setFlashdata('error', 'Username atau password salah');
            }
        }

        return view('admin/login', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }

    public function profile()
    {
        $userId = session()->get('userId');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Profile Admin',
            'user' => $user
        ];

        if ($this->request->getMethod() === 'POST') {
            $rules = [
                'full_name' => 'required|min_length[3]',
                'email' => 'required|valid_email|is_unique[users.email,id,' . $userId . ']',
            ];

            if ($this->request->getPost('password')) {
                $rules['password'] = 'required|min_length[6]';
                $rules['confirm_password'] = 'required|matches[password]';
            }

            if ($this->validate($rules)) {
                $updateData = [
                    'full_name' => $this->request->getPost('full_name'),
                    'email' => $this->request->getPost('email'),
                ];

                if ($this->request->getPost('password')) {
                    $updateData['password'] = $this->request->getPost('password');
                }

                if ($this->userModel->update($userId, $updateData)) {
                    session()->setFlashdata('success', 'Profile berhasil diperbarui');
                    return redirect()->to('/admin/profile');
                } else {
                    session()->setFlashdata('error', 'Gagal memperbarui profile');
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        return view('admin/profile', $data);
    }
}
