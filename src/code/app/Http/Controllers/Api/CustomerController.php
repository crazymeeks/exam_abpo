<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repository\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exceptions\CustomerException;

class CustomerController extends Controller
{
    
    private CustomerRepository $customerRepository;


    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Retrieve all model
     * 
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {

        $customers = $this->customerRepository->get($request);
        return response()->json([
            'status' => true,
            'data' => $customers
        ]);
    }

    /**
     * Find a model
     *
     * @param integer $id
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(int $id)
    {
        $customer = $this->customerRepository->find($id);
        return response()->json([
            'result' => $customer
        ]);
    }

    /**
     * Create new customer
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|unique:customers|max:50',
            'age' => 'required|integer',
            'birthday' => 'required|date',
        ]);


        $this->customerRepository->create($request->toArray());

        return response()->json([
            'status' => true,
            'message' => 'Customer successfully created!'
        ], 201);

    }

    /**
     * Update model
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {

        $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => [
                'required',
                Rule::unique('customers')->ignore($id)
            ],
            'age' => 'required|integer',
            'birthday' => 'required|date',
        ]);

        try {

            $this->customerRepository->update($id, $request->toArray());
            return response()->json([
                'status' => true,
                'message' => 'Customer successfully updated!'
            ], 200);

        } catch (CustomerException $e) {
            return response()->json([
                'status' => false,
                'message' => sprintf("Customer cannot be updated. %s", $e->getMessage()),
            ], $e->getCode());
        }

    }

    /**
     * Delete model
     * 
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id)
    {
        try {
            $this->customerRepository->delete($id);
    
            return response()->json([
                'status' => true,
                'message' => 'Customer deleted successfully.'
            ]);

        } catch (CustomerException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
