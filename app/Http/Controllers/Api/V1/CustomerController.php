<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CustomerService;
use App\Http\Requests\CreateCustomerRequest;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of customers.
     */
    public function index()
    {
        $customers = $this->customerService->getAllCustomers();
        return $this->successResponse($customers);
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(CreateCustomerRequest $request): JsonResponse
    {
        $customer = $this->customerService->createCustomer($request->validated());

        return $this->successResponse($customer, 201);
    }

    /**
     * Display the specified customer.
     */
    public function show($identifier)
    {
        $customer = $this->customerService->getCustomerById($identifier);

        return $this->successResponse($customer);
    }

    /**
     * Display the points and redeemed rewards of a specific customer.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCustomerRewardsStatus(int $id)
    {
        $customer = $this->customerService->getCustomerRewardsStatus($id);
        return $this->successResponse($customer);
    }
}
