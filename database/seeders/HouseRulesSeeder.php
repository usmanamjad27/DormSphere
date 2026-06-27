<?php

namespace Database\Seeders;

use App\Models\HouseRule;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::first();

        if (! $admin) {
            return;
        }

        $rules = [
            ['section_title' => 'Quiet Hours', 'content' => 'Quiet hours are from 10:00 PM to 7:00 AM. Please keep noise levels low during these hours.', 'sort_order' => 1],
            ['section_title' => 'No Pets', 'content' => 'No pets of any kind are allowed in the rooms or communal areas.', 'sort_order' => 2],
            ['section_title' => 'Music Instruments', 'content' => 'No musical instruments are permitted in rooms. Use the music room for practice.', 'sort_order' => 3],
            ['section_title' => 'Guest Policy', 'content' => 'Overnight guests require prior written consent for stays over 3 nights. A CHF 30 flat fee per overnight stay will be invoiced.', 'sort_order' => 4],
            ['section_title' => 'Lounge & Events', 'content' => 'The lounge/bar is for residents only and event spaces must be reserved in advance for gatherings of 15+ persons. A CHF 200 deposit may apply.', 'sort_order' => 5],
            ['section_title' => 'Laundry', 'content' => 'Laundry room usage is shared. Clean the machines after use and do not leave laundry unattended.', 'sort_order' => 6],
            ['section_title' => 'Cleaning Responsibilities', 'content' => 'Communal kitchens must be cleaned after each use. Personal food compartments must be kept tidy.', 'sort_order' => 7],
            ['section_title' => 'Bicycles', 'content' => 'No bicycles are allowed inside the building. Use designated bicycle parking areas.', 'sort_order' => 8],
            ['section_title' => 'Parking', 'content' => 'Student car parking is not available. Visitor parking spaces must be booked in advance.', 'sort_order' => 9],
            ['section_title' => 'Internet', 'content' => 'Internet is included. Students must provide their own router or use cable if required.', 'sort_order' => 10],
            ['section_title' => 'Subletting', 'content' => 'Subletting is allowed for a maximum of 6 months with admin consent and proof of the subtenant’s enrollment.', 'sort_order' => 11],
            ['section_title' => 'Notice Period', 'content' => 'A 2-month written notice period is required by registered post, not by email or caretaker mailbox.', 'sort_order' => 12],
            ['section_title' => 'Registration', 'content' => 'Registration with the residents’ registration office is required.', 'sort_order' => 13],
            ['section_title' => 'Mailbox', 'content' => 'A personal mailbox is provided for each resident.', 'sort_order' => 14],
        ];

        foreach ($rules as $rule) {
            HouseRule::updateOrCreate(
                ['section_title' => $rule['section_title']],
                array_merge($rule, ['admin_id' => $admin->id, 'is_active' => true])
            );
        }
    }
}
