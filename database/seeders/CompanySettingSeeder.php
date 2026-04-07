<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Contact Information
            [
                'key' => 'company_name',
                'value' => 'PinkTravel',
                'type' => 'string',
                'label' => 'Nama Perusahaan',
                'category' => 'general',
            ],
            [
                'key' => 'company_phone',
                'value' => '+62829510333',
                'type' => 'string',
                'label' => 'Nomor Telepon',
                'category' => 'contact',
            ],
            [
                'key' => 'company_email',
                'value' => 'info@pinktravel.com',
                'type' => 'string',
                'label' => 'Email Perusahaan',
                'category' => 'contact',
            ],
            [
                'key' => 'company_address',
                'value' => 'Jl. Merdeka No. 123, Jakarta, Indonesia',
                'type' => 'text',
                'label' => 'Alamat Perusahaan',
                'category' => 'contact',
            ],
            [
                'key' => 'company_whatsapp',
                'value' => '+62829510333',
                'type' => 'string',
                'label' => 'WhatsApp',
                'category' => 'contact',
            ],

            // Social Media
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com/pinktravel',
                'type' => 'string',
                'label' => 'Instagram',
                'category' => 'social',
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com/pinktravel',
                'type' => 'string',
                'label' => 'Facebook',
                'category' => 'social',
            ],
            [
                'key' => 'social_youtube',
                'value' => 'https://youtube.com/pinktravel',
                'type' => 'string',
                'label' => 'YouTube',
                'category' => 'social',
            ],

            // Email Configuration
            [
                'key' => 'email_from',
                'value' => 'noreply@pinktravel.com',
                'type' => 'string',
                'label' => 'Email Pengirim',
                'category' => 'email',
            ],
            [
                'key' => 'email_support',
                'value' => 'support@pinktravel.com',
                'type' => 'string',
                'label' => 'Email Support',
                'category' => 'email',
            ],

            // Payment Configuration
            [
                'key' => 'payment_gateway',
                'value' => 'midtrans',
                'type' => 'string',
                'label' => 'Payment Gateway',
                'description' => 'midtrans, xendit, atau payment gateway lainnya',
                'category' => 'payment',
            ],
            [
                'key' => 'payment_midtrans_key',
                'value' => '',
                'type' => 'string',
                'label' => 'Midtrans API Key',
                'category' => 'payment',
            ],
            [
                'key' => 'payment_xendit_key',
                'value' => '',
                'type' => 'string',
                'label' => 'Xendit API Key',
                'category' => 'payment',
            ],

            // General Settings
            [
                'key' => 'site_title',
                'value' => 'PinkTravel - Jelajahi Destinasi Impian Anda',
                'type' => 'string',
                'label' => 'Judul Website',
                'category' => 'general',
            ],
            [
                'key' => 'site_description',
                'value' => 'Platform wisata online terpercaya dengan paket tour berkualitas tinggi ke destinasi impian Anda',
                'type' => 'text',
                'label' => 'Deskripsi Website',
                'category' => 'general',
            ],
            [
                'key' => 'currency',
                'value' => 'IDR',
                'type' => 'string',
                'label' => 'Mata Uang',
                'category' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            CompanySetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
