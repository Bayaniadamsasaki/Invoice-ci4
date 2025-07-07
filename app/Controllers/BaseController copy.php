<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = ['url', 'form', 'html', 'text'];
    protected $session;
    protected $validation;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        
        // Set timezone
        date_default_timezone_set('Asia/Jakarta');
    }

    protected function isLoggedIn(): bool
    {
        return $this->session->get('isLoggedIn') ?? false;
    }

    protected function getUserId(): ?int
    {
        return $this->session->get('userId');
    }

    protected function getUserData(): ?array
    {
        return $this->session->get('userData');
    }

    protected function setAlert(string $type, string $message): void
    {
        $this->session->setFlashdata('alert', [
            'type' => $type,
            'message' => $message
        ]);
    }
}
