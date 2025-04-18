<?php

namespace Database\Seeders;

use App\Models\Transport;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder{
    public function run()
    {
        $transportUsers = User::where('role', 'transport')->get();
        
        if ($transportUsers->isEmpty()) {
            $user = User::create([
                'name' => 'Transport Company Manager',
                'email' => 'transport@transport.com', 
                'password' => 'transport123',
                'role' => 'transport'
            ]);
            $transportUsers = collect([$user]);
        }
        
        $transports = [
            [
                'phone' => '+33123456789',
                'company_name' => 'Global Voyages',
                'transport_type' => 'Tourist vehicle',
                'license_number' => 'TC-12345-' . uniqid(),
                'address' => '123 Transport Street, Paris',
            ],
            [
                'phone' => '+44987654321',
                'transport_type' => 'Plane',
                'company_name' => 'Sky Airlines',
                'address' => '456 Airport Road, London',
                'license_number' => 'TC-23456-' . uniqid(),
            ],
            [
                'phone' => '+212987654321',
                'transport_type' => 'Camel',
                'company_name' => 'Desert Tours',
                'license_number' => 'TC-34567-' . uniqid(),
                'address' => '789 Sand Dune Avenue, Marrakech',
            ],
        ];
        
        foreach ($transports as $index => $transport) {
            $userId = isset($transportUsers[$index]) ? $transportUsers[$index]->id : $transportUsers->first()->id;
            
            $existingCompany = Transport::where('user_id', $userId)->first();
            
            if (!$existingCompany) {
                Transport::create([
                    'user_id' => $userId,
                    'company_name' => $transport['company_name'],
                    'transport_type' => $transport['transport_type'],
                    'license_number' => $transport['license_number'],
                    'address' => $transport['address'],
                    'phone' => $transport['phone'],
                ]);
            }
        }
    }
}