<?php
namespace App\Repositories;

use App\Models\Expense;
use App\Repositories\Interface\BookingRepositoryInterface;

class ExpenseRepository implements BookingRepositoryInterface
{
    public function getAll()
    {
        return Expense::all();
    }

    public function findById($id)
    {
        return Expense::findOrFail($id);
    }

    public function create(array $data)
    {
        return Expense::create($data);
    }

    public function update($id, array $data)
    {
        $expense = Expense::findOrFail($id);
        $expense->update($data);
        return $expense;
    }

    public function delete($id)
    {
        return Expense::destroy($id);
    }
}
