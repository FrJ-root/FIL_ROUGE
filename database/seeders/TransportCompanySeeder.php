<?php

namespace Database\Seeders;

use App\Models\TransportCompany;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransportCompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get transport company users
        $transportUsers = User::where('role', 'transport company')->get();
        
        if ($transportUsers->isEmpty()) {
            // If no transport company users, create at least one
            $user = User::create([
                'name' => 'Transport Company Manager',
                'email' => 'transport@example.com', 
                'password' => 'password',
                'role' => 'transport company'
            ]);
            $transportUsers = collect([$user]);
        }
        
        $transportCompanies = [
            [
                'company_name' => 'Global Voyages',
                'transport_type' => 'Tourist vehicle',
                'license_number' => 'TC-12345-' . uniqid(), // Add unique suffix
                'address' => '123 Transport Street, Paris',
                'phone' => '+33123456789',
            ],
            [
                'company_name' => 'Sky Airlines',
                'transport_type' => 'Plane',
                'license_number' => 'TC-23456-' . uniqid(), // Add unique suffix
                'address' => '456 Airport Road, London',
                'phone' => '+44987654321',
            ],
            [
                'company_name' => 'Desert Tours',
                'transport_type' => 'Camel',
                'license_number' => 'TC-34567-' . uniqid(), // Add unique suffix
                'address' => '789 Sand Dune Avenue, Marrakech',
                'phone' => '+212987654321',
            ],
        ];
        
        foreach ($transportCompanies as $index => $company) {
            // Assign company to a transport user (if available), otherwise use the first transport user
            $userId = isset($transportUsers[$index]) ? $transportUsers[$index]->id : $transportUsers->first()->id;
            
            // Check if user already has a transport company
            $existingCompany = TransportCompany::where('user_id', $userId)->first();
            
            if (!$existingCompany) {
                TransportCompany::create([
                    'user_id' => $userId,
                    'company_name' => $company['company_name'],
                    'transport_type' => $company['transport_type'],
                    'license_number' => $company['license_number'],
                    'address' => $company['address'],
                    'phone' => $company['phone'],
                ]);
            }
        }
    }
}
