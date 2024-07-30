<?php

namespace App\Interfaces;

use App\Http\Responses\Response;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    public function index(Request $request) : Response;
    public function getById($id) : Response;
    public function store(array $data) : Response;
    public function update(array $data, $id) : Response;
    public function delete($id) : Response;
}
