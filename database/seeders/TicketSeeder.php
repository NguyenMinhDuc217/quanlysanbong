<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tickets;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        Tickets::insert([
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '1',
            'month'=>'1',
            'name'=>'Vé tháng hăng say',
            'code_ticket'=>'TICKET123',
            'price'=>'1000000',
            'timeout'=>'2022-07-04',
            'discount'=>10,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '2',
            'month'=>'1',
            'name'=>'Vé tháng chăm chỉ',
            'code_ticket'=>'TICKET123',
            'price'=>'2000000',
            'timeout'=>'2022-07-04',
            'discount'=>0,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '1',
            'month'=>'1',
            'name'=>'Vé tháng hăng say',
            'code_ticket'=>'TICKET123',
            'price'=>'1000000',
            'timeout'=>'2022-07-04',
            'discount'=>10,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '2',
            'month'=>'1',
            'name'=>'Vé tháng chăm chỉ',
            'code_ticket'=>'TICKET123',
            'price'=>'2000000',
            'timeout'=>'2022-07-04',
            'discount'=>10,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '1',
            'month'=>'1',
            'name'=>'Vé tháng hăng say',
            'code_ticket'=>'TICKET123',
            'price'=>'1000000',
            'timeout'=>'2022-07-04',
            'discount'=>0,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '2',
            'month'=>'1',
            'name'=>'Vé tháng chăm chỉ',
            'code_ticket'=>'TICKET123',
            'price'=>'2000000',
            'timeout'=>'2022-07-04',
            'discount'=>0,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '1',
            'month'=>'1',
            'name'=>'Vé tháng hăng say',
            'code_ticket'=>'TICKET123',
            'price'=>'1000000',
            'timeout'=>'2022-07-04',
            'discount'=>0,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '2',
            'month'=>'1',
            'name'=>'Vé tháng chăm chỉ',
            'code_ticket'=>'TICKET123',
            'price'=>'2000000',
            'timeout'=>'2022-07-04',
            'discount'=>20,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '1',
            'month'=>'1',
            'name'=>'Vé tháng hăng say',
            'code_ticket'=>'TICKET123',
            'price'=>'1000000',
            'timeout'=>'2022-07-04',
            'discount'=>10,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '2',
            'month'=>'1',
            'name'=>'Vé tháng chăm chỉ',
            'code_ticket'=>'TICKET123',
            'price'=>'2000000',
            'timeout'=>'2022-07-04',
            'discount'=>0,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '1',
            'month'=>'1',
            'name'=>'Vé tháng hăng say',
            'code_ticket'=>'TICKET123',
            'price'=>'1000000',
            'timeout'=>'2022-07-04',
            'discount'=>10,
        ],
        [
            'image' => 'ticket1.png',
            'number_day_of_week' => '2',
            'month'=>'1',
            'name'=>'Vé tháng chăm chỉ',
            'code_ticket'=>'TICKET123',
            'price'=>'2000000',
            'timeout'=>'2022-07-04',
            'discount'=>20,
        ],
    ]);
    }
}
