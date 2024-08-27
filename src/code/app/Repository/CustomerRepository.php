<?php

namespace App\Repository;

use App\Models\Customer;
use App\Exceptions\CustomerException;
use Illuminate\Http\Request;

class CustomerRepository
{

    /**
     * Get all models
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {

        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);

        $page = (int) $page <= 0 ? 1 : $page;
        $offset = ($page -1) * $limit;

        $total = Customer::count();

        $customers = Customer::offset($offset)
                             ->limit($limit)
                             ->orderBy('last_name', 'asc')
                             ->get()
                             ->toArray();

        return [
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'resultset' => $customers,
        ];
    }

    /**
     * Retrieve single model
     *
     * @param int $id
     * 
     * @return array
     */
    public function find(int $id)
    {
        $customer = Customer::find($id)->toArray();

        return $customer;
    }

    /**
     * Create new model
     *
     * @param array $data
     * 
     * @return \App\Models\Customer
     */
    public function create(array $data)
    {

        $data = $this->mutate($data);

        unset($data['birthday']);
        
        return Customer::create($data);
    }

    /**
     * Mutate data
     *
     * @param array $data
     * 
     * @return array
     */
    private function mutate(array $data)
    {
        $data['dob'] = $data['birthday'];
        unset($data['birthday']);

        return $data;
    }

    /**
     * Update model
     *
     * @param integer $id
     * @param array $data
     * 
     * @return \App\Models\Customer
     */
    public function update(int $id, array $data)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $data = $this->mutate($data);
    
            $customer->fill($data)
                     ->save();
    
            return $customer;
        }

        throw CustomerException::not_found();
    }

    public function delete(int $id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->delete();
            return true;
        }

        throw CustomerException::delete_error();

    }
}