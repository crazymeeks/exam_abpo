<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{


    public function test_create_customer()
    {
        
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'age' => 25,
            'birthday' => '1991-12-25'
        ];

        $headers = $this->authenticate();

        $response = $this->json('POST', route('api.customers.create'), $data, $headers);
        
        $response->assertJsonStructure([
            'status',
            'message'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('customers', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ]);
    }

    public function test_update_customer()
    {
        $headers = $this->authenticate();

        $customer = Customer::factory()->create();

        $new_data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'age' => 25,
            'birthday' => '1991-12-25'
        ];
        $response = $this->json('PUT', route('api.customers.update', ['id' => $customer->id]), $new_data, $headers);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);

        $this->assertDatabaseHas('customers', [
            'first_name' => $new_data['first_name'],
            'age' => $new_data['age'],
        ]);

        $this->assertDatabaseMissing('customers', [
            'first_name' => 'John'
        ]);
    }

    public function test_cannot_update_if_customer_does_not_exist()
    {
        $headers = $this->authenticate();

        $new_data = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'age' => 25,
            'birthday' => '1991-12-25'
        ];

        $response = $this->json('PUT', route('api.customers.update', ['id' => 1]), $new_data, $headers);

        $response->assertStatus(500);
        $response->assertJsonStructure([
            'status',
            'message'
        ]);

        $this->assertDatabaseCount('customers', 0);

    }

    public function test_delete_customer()
    {
        $headers = $this->authenticate();

        $customer = Customer::factory()->create();
        
        $response = $this->json('DELETE', route('api.customers.delete', ['id' => $customer->id]), [], $headers);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'status',
            'message'
        ]);

        $this->assertEquals('Customer deleted successfully.', $response->original['message']);

        $this->assertDatabaseMissing('customers', [
            'first_name' => 'John'
        ]);
    }


    public function test_get_customers()
    {
        $headers = $this->authenticate();

        Customer::factory()->create();
        
        $response = $this->json('GET', route('api.customers.get'), [], $headers);
        
        $response->assertStatus(200);

        $response->assertJsonStructure([
            
            'data' => [
                'total',
                'page',
                'limit',
                'resultset' => [
                    [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'age',
                        'dob',
                        'created_at'
                    ]
                ]
            ]
        ]);
    }

    public function test_find_customer()
    {
        $headers = $this->authenticate();

        $customer = Customer::factory()->create();
        
        $response = $this->json('GET', route('api.customers.find', ['id' => $customer->id]), [], $headers);
        
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'result' => [
                'id',
                'first_name',
                'last_name',
                'email',
                'age',
                'dob',
                'created_at'
            ]
        ]);
    }

}
